<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasedProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_product_info_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchaseProductInfo()
    {
        return $this->belongsTo(PurchaseProductInfo::class, 'purchase_product_info_id');
    }
}
