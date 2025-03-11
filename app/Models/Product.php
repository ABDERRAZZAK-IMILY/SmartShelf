<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'rayon_id', 'name', 'category', 'price', 'stock', 
        'stock_threshold', 'is_popular', 'is_on_sale', 'sale_price'
    ];

    public function rayon()
    {
        return $this->belongsTo(Rayon::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}