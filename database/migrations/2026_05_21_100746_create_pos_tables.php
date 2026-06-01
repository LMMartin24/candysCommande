<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name'); 
            $table->integer('base_price'); // Stocké en centimes (ex: 400 pour 4,00€)
            $table->text('description')->nullable(); 
            $table->timestamps();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->integer('additional_price'); // En centimes (ex: 100 pour 1,00€)
            $table->timestamps();
        });

        Schema::create('option_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_product');
        Schema::dropIfExists('options');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};