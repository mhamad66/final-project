<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseTradeGoodsSuggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'good_id',
        'warehouses',
    ];

    //    protected $casts = [
    //        'warehouses' => array()
    //    ];
}
