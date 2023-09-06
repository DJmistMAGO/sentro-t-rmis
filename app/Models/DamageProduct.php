<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageProduct extends Model
{
    use HasFactory;



    protected $fillable = [
        'damage_prod_info_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function damageProdInfo()
    {
        return $this->belongsTo(DamageProdInfo::class, 'damage_prod_info_id');
    }

}
