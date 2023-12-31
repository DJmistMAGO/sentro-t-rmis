<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnProduct extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'return_prod_info_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function returnProdInfo()
    {
        return $this->belongsTo(ReturnProdInfo::class, 'return_prod_info_id');
    }
}
