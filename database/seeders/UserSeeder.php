<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => '',
            'email' => '',
            'passwor' => bcrypt(''),
        ]);

        // Crear un usuario admin (si es necesario)
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
