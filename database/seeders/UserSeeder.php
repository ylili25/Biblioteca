<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $userOne = User::create([
            'name'     => 'Liliana Peralta Palma',
            'email'    => 'liliana.peralta25@hotmail.com',
            'password' => '123456789'
        ]);
        $userOne->assignRole('Administrador');

        $userTwo = User::create([
            'name'     => 'Heriberto Garcia Valle',
            'email'    => 'valle9307@hotmail.com',
            'password' => '123456789'
        ]);
        $userTwo->assignRole('Prestatario');

        $userThree = User::create([
            'name'     => 'Carlos Peralta',
            'email'    => 'carlitos28@hotmail.com',
            'password' => '123456789'
        ]);
        $userThree->assignRole('Prestatario');
    }
}
