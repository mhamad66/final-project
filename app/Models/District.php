<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'districts';
    public $timestamps = false;
    public function showrooms()
    {
        return $this->hasMany(Showroom::class,'district_id');
    }
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class,'district_id');
    }
}
