<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'product_category',
        'product_name',
        'product_buying_price',
        'product_selling_price',
        'product_quantity',
        'product_image',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category', 'id');
    }
}
