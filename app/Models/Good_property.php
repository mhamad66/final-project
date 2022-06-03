<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good_property extends Model
{
    use HasFactory;
    public function goods()
    {
        return $this->hasMany(Good::class,'good_properties_id');
    }
}
