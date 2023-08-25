<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProductInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'prepared_by',
        'date_preparation',
    ];

    protected $casts = [
        'date_preparation' => 'date',
    ];

    
}
