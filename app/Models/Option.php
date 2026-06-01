<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Option extends Model
{
    protected $guarded = []; // 👈 Débloque l'insertion

    public function products(): BelongsToMany
    {
        // On force Eloquent à utiliser 'option_product'
        return $this->belongsToMany(Product::class, 'option_product');
    }
}