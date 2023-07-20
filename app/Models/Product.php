<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_name',
        'product_code',
        'description',
        'category',
        'price',
        'quantity',
        'image',
        'status',
        'supplier_info',
    ];

    protected $dates = [
        'deleted_at',
    ];

}
