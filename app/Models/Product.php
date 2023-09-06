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
        'unit',
        'quantity',
        'image',
        'status',
        'supplier_info',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function purchasedProducts()
    {
        return $this->hasMany(PurchasedProduct::class);
    }

    public function returnProducts()
    {
        return $this->hasMany(ReturnProduct::class);
    }

    public function damageProducts()
    {
        return $this->hasMany(DamageProduct::class);
    }

}
