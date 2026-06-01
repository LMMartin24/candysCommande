<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $guarded = []; // 👈 Débloque l'insertion

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function options(): BelongsToMany
    {
        // On force Eloquent à utiliser 'option_product'
        return $this->belongsToMany(Option::class, 'option_product');
    }
}