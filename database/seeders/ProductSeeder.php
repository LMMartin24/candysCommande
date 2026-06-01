<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Nettoyage des tables pour éviter les doublons
        DB::table('categories')->truncate();
        DB::table('products')->truncate();
        DB::table('options')->truncate();
        
        // ⚡ CORRECTION : On utilise le nom standard de la table pivot Laravel
        DB::table('option_product')->truncate(); 

        // ==========================================
        // 1. CATÉGORIE : GLACES
        // ==========================================
        $glacesId = DB::table('categories')->insertGetId([
            'name' => 'Glaces', 'created_at' => now(), 'updated_at' => now()
        ]);
        
        $simpleId = DB::table('products')->insertGetId([
            'category_id' => $glacesId, 'name' => 'Simple', 'base_price' => 300, 'created_at' => now(), 'updated_at' => now()
        ]);
        $doubleId = DB::table('products')->insertGetId([
            'category_id' => $glacesId, 'name' => 'Double', 'base_price' => 450, 'created_at' => now(), 'updated_at' => now()
        ]);
        $tripleId = DB::table('products')->insertGetId([
            'category_id' => $glacesId, 'name' => 'Triple', 'base_price' => 550, 'created_at' => now(), 'updated_at' => now()
        ]);

        $chantillyId = DB::table('options')->insertGetId([
            'name' => 'Chantilly / Coulis', 'additional_price' => 100, 'created_at' => now(), 'updated_at' => now()
        ]);

        // ⚡ CORRECTION : Liaison Pivot Glaces
        DB::table('option_product')->insert([
            ['product_id' => $simpleId, 'option_id' => $chantillyId],
            ['product_id' => $doubleId, 'option_id' => $chantillyId],
            ['product_id' => $tripleId, 'option_id' => $chantillyId],
        ]);

        // ==========================================
        // 2. CATÉGORIE : CRÊPES & GAUFRES
        // ==========================================
        $crepesId = DB::table('categories')->insertGetId([
            'name' => 'Crêpes & Gaufres', 'created_at' => now(), 'updated_at' => now()
        ]);
        
        DB::table('products')->insert([
            ['category_id' => $crepesId, 'name' => 'Sucre', 'base_price' => 200, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $crepesId, 'name' => 'Citron, Beurre', 'base_price' => 300, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $crepesId, 'name' => 'Garnitures Classiques', 'base_price' => 400, 'description' => 'Nutella, Caramel, Crème de marron, Chantilly sucre, Confiture, Noix de coco, Maxi, Bueno, Grand Marnier', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $crepesId, 'name' => 'Gourmande', 'base_price' => 750, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ==========================================
        // 3. CATÉGORIE : CHICHIS
        // ==========================================
        $chichisId = DB::table('categories')->insertGetId([
            'name' => 'Chichis', 'created_at' => now(), 'updated_at' => now()
        ]);
        
        $c3Id = DB::table('products')->insertGetId([
            'category_id' => $chichisId, 'name' => 'Les 3 Chichis', 'base_price' => 200, 'created_at' => now(), 'updated_at' => now()
        ]);
        $c6Id = DB::table('products')->insertGetId([
            'category_id' => $chichisId, 'name' => 'Les 6 Chichis', 'base_price' => 400, 'created_at' => now(), 'updated_at' => now()
        ]);
        $c9Id = DB::table('products')->insertGetId([
            'category_id' => $chichisId, 'name' => 'Les 9 Chichis', 'base_price' => 500, 'created_at' => now(), 'updated_at' => now()
        ]);

        $nutellaId = DB::table('options')->insertGetId([
            'name' => 'Option Nutella', 'additional_price' => 150, 'created_at' => now(), 'updated_at' => now()
        ]);

        // ⚡ CORRECTION : Liaison Pivot Chichis
        DB::table('option_product')->insert([
            ['product_id' => $c3Id, 'option_id' => $nutellaId],
            ['product_id' => $c6Id, 'option_id' => $nutellaId],
            ['product_id' => $c9Id, 'option_id' => $nutellaId],
        ]);

        // ==========================================
        // 4. CATÉGORIE : BOISSONS
        // ==========================================
        $boissonsId = DB::table('categories')->insertGetId([
            'name' => 'Boissons', 'created_at' => now(), 'updated_at' => now()
        ]);
        
        DB::table('products')->insert([
            ['category_id' => $boissonsId, 'name' => 'Eau', 'base_price' => 100, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $boissonsId, 'name' => 'Canette', 'base_price' => 200, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $boissonsId, 'name' => 'Bouteille', 'base_price' => 250, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}