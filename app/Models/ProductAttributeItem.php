<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_id',
        'attribute_items_id'
    ];
}
