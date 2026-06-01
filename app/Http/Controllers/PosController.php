<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Events\CartUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PosController extends Controller
{
    /**
     * Écran 1 : Affichage de la grille Bento principale (Sélection des catégories).
     */
    public function index()
    {
        $categories = Category::all();
        
        return view('pos.index', compact('categories'));
    }

    /**
     * Écran 2 : Affichage des déclinaisons de prix et suppléments pour la catégorie choisie.
     */
    public function show(Category $category)
    {
        $categories = Category::all(); // Nécessaire pour la barre de navigation rapide
        
        $products = Product::where('category_id', $category->id)
            ->with('options')
            ->get();

        return view('pos.show', compact('category', 'categories', 'products'));
    }

    /**
     * Synchronisation en temps réel du panier vers l'écran meuble/déporté.
     */
    public function syncCart(Request $request)
    {
        $request->validate([
            'items' => 'present|array',
            'total' => 'required|integer',
        ]);

        // ⚡ Diffusion instantanée via WebSockets (Laravel Reverb)
        broadcast(new CartUpdated([
            'status' => 'updating',
            'items' => $request->input('items', []),
            'total' => $request->input('total', 0)
        ]))->toOthers();

        return response()->json(['status' => 'synced']);
    }

    /**
     * Clôture de la vente, enregistrement en BDD et réinitialisation des terminaux.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'total' => 'required|integer',
        ]);

        try {
            // Utilisation d'une transaction DB pour garantir l'intégrité des données (Principe ACID)
            DB::transaction(function () use ($request) {
                
                // 1. Création de l'enregistrement de la commande principale
                $orderId = DB::table('orders')->insertGetId([
                    'user_id' => auth()->id(), // Le serveur qui a validé la vente
                    'total_amount' => $request->input('total'), // Prix total stocké en centimes
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 2. Enregistrement de chaque ligne du panier avec ses options
                foreach ($request->input('items') as $item) {
                    $orderItemId = DB::table('order_items')->insertGetId([
                        'order_id' => $orderId,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'] ?? 1,
                        'price_unit' => $item['base_price'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Si l'article contient des suppléments/options associés
                    if (!empty($item['options'])) {
                        foreach ($item['options'] as $option) {
                            DB::table('order_item_options')->insert([
                                'order_item_id' => $orderItemId,
                                'option_id' => $option['id'],
                                'price' => $option['additional_price'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            });

            broadcast(new CartUpdated([
                'status' => 'validated',
                'items' => [],
                'total' => 0
            ]))->toOthers();

            return response()->json([
                'status' => 'success',
                'message' => 'Commande enregistrée avec succès.'
            ]);

        } catch (\Exception $e) {
            // En cas d'erreur de base de données, on log l'incident pour ne rien perdre
            Log::error('Échec de la validation de la commande POS : ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la sauvegarde de la commande.'
            ], 500);
        }
    }
}