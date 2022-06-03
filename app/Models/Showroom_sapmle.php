<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom_sapmle extends Model
{
    use HasFactory;
    public function showroom()
    {
        return $this->belongsTo(Showroom::class,'branch_id');
    }

    /**
     * Get the Sample's Good Info.
     */
    public function good()
    {
        return $this->belongsTo(Good::class,'good_id');
    }
}
