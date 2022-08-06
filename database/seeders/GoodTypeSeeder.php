<?php

namespace Database\Seeders;

use App\Models\Good_Type;
use Illuminate\Database\Seeder;

class GoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Good_Type::create(['name'=>'chair']);
        Good_Type::create(['name'=>'sofa']);
        Good_Type::create(['name'=>'armchair']);
        Good_Type::create(['name'=>'lamppost']);
        Good_Type::create(['name'=>'lamp']);
        Good_Type::create(['name'=>'fan']);
        Good_Type::create(['name'=>'table']);
        Good_Type::create(['name'=>'bed']);

    }
}
