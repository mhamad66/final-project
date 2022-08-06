<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyManager = User::create([
            'name' => 'companyManager',
            'email' => 'companyManager@test.com',
            'password' => bcrypt('123456')
        ]);

        $showroomManager = User::create([
            'name' => 'showroomManager',
            'email' => 'showroomManager@test.com',
            'password' => bcrypt('123456')
        ]);
        $warehouseManager = User::create([
            'name' => 'warehouseManager',
            'email' => 'warehouseManager@test.com',
            'password' => bcrypt('123456')
        ]);
        $warehouseManagerRole =  Role::create(['name' => 'warehouseManagerRole']);
        $permission= Permission::create(['name' => 'addWarehouse']);
        $warehouseManagerRole->givePermissionTo($permission);
       $warehouseManager->assignRole('warehouseManagerRole');
    }

}
