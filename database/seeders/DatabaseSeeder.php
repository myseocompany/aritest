<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'soporterapido@myseocompany.co',
            'password' => Hash::make('myseo2025'), // Asegúrate de cambiar 'your_default_password' por una contraseña real segura
            
        ]);
        $this->call(ExamSeeder::class);
        /*
        $this->call([
            UserSeeder::class,
            SubsetSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            ExamSeeder::class,
            ExamAnswerSeeder::class,
        ]);
        */
    }
}
