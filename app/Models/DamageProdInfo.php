<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DamageProdInfo extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'user_id',
        'reference_no',
        'prepared_by',
        'date_preparation',
    ];

    protected $casts = [
        'date_preparation' => 'date',
    ];

    public function damageProducts()
    {
        return $this->hasMany(DamageProduct::class);
    }
}
