<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'manufacturer',
        'sku',
        'price',
        'sale_price',
        'index_image',
        'description',
        'short_description',
        'status',
        'ean',
        'stock',
        'connection_key',
        'connection'
    ];
}
