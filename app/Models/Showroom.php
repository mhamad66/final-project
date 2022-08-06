<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    protected $fillable = [
        'district',
        'address',
        'name',
        'total_space',
        'longitude',
        'latitude',
        'avg_sales'
    ];
    use HasFactory;

    public function samples()
    {
        return $this->hasMany(Showroom_sapmle::class, 'branch_id');
    }
}
