<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'district_id',
        'address',
        'total_space',
        'longitude',
        'latitude',
        'avg_sales'
    ];
    use HasFactory;

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function goods()
    {
        return $this->hasMany(Warehouse_good::class);
    }
}
