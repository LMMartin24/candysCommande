<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Table principale de la vente
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Le serveur
            $table->integer('total_amount'); // Montant total en centimes
            $table->timestamps();
        });

        // Table pivot détaillée (Lignes du ticket)
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->integer('price_unit'); // Prix de base au moment de la vente (en centimes)
            $table->timestamps();
        });

        // Table des suppléments appliqués à chaque ligne
        Schema::create('order_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_id')->constrained()->onDelete('cascade');
            $table->integer('price'); // Prix du supplément au moment de la vente (en centimes)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_options');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};