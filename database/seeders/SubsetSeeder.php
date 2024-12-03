<?php

// database/seeders/SubsetSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subset;

class SubsetSeeder extends Seeder
{
    public function run()
    {
        // Crear subsets de prueba
        Subset::create([
            'name' => 'Matemáticas Básicas',
        ]);

        Subset::create([
            'name' => 'Geometría',
        ]);

        Subset::create([
            'name' => 'Física',
        ]);

        Subset::create([
            'name' => 'Química',
        ]);
    }
}
