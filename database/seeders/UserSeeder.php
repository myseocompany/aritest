<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear usuarios de prueba
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => bcrypt('password123'),
        ]);

        User::create([
            'name' => 'María González',
            'email' => 'maria@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Crear un usuario admin (si es necesario)
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
