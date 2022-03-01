<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            'Editorial', 'Libro', 'Prestamo', 'User'
        ];

        Permission::truncate();

        foreach($modules as $module){
            Permission::create(['name' => $module.'.create']);
            Permission::create(['name' => $module.'.read']);
            Permission::create(['name' => $module.'.update']);
            Permission::create(['name' => $module.'.delete']);
        }
    }
}
