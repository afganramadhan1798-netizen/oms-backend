<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //     User::create([
        //     'name' => 'Afgan',
        //     'email' => 'afgan@gmail.com',
        //     'password' => bcrypt('123456'),
        //     'role' => 'employee',
        //     'position' => 'Frontend Developer'
        // ]);
        //     User::create([
        //     'name' => 'Altaf',
        //     'email' => 'altaf@lenna.ai',
        //     'password' => bcrypt('123456'),
        //     'role' => 'employee',
        //     'position' => 'Backend Developer'
        // ]);
        //     User::create([
        //     'name' => 'Katya',
        //     'email' => 'yaya@lenna.ai',
        //     'password' => bcrypt('123456'),
        //     'role' => 'employee',
        //     'position' => 'Fullstack Engineer'
        // ]);
        //     User::create([
        //     'name' => 'bang dhika',
        //     'email' => 'dhik@lenna.ai',
        //     'password' => bcrypt('123456'),
        //     'role' => 'employee',
        //     'position' => 'Fullstack Engineer',
        //     'profile' => 'Default'
        // ]);
        //     User::create([
        //     'name' => 'mba nicaa',
        //     'email' => 'niss@lenna.ai',
        //     'password' => bcrypt('123456'),
        //     'role' => 'product_manager',
        //     'position' => 'Product Manager',
        //     'profile' => 'Default'
        // ]);
            User::create([
            'name' => 'Mas Fachri',
            'email' => 'Fachri@lenna.ai',
            'password' => bcrypt('123456'),
            'role' => 'product_manager',
            'position' => 'Product Manager',
            'profile' => 'Default'
        ]);
            User::create([
            'name' => 'A Fuja',
            'email' => 'AFuja@lenna.ai',
            'password' => bcrypt('123456'),
            'role' => 'product_manager',
            'position' => 'Product Manager',
            'profile' => 'Default'
        ]);
            User::create([
            'name' => 'Mas Gilang',
            'email' => 'Gilang@lenna.ai',
            'password' => bcrypt('123456'),
            'role' => 'product_manager',
            'position' => 'Product Manager',
            'profile' => 'Default'
        ]);
    }
}
