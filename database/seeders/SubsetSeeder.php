<?php

// database/seeders/SubsetSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subset;

class SubsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agregar registros de prueba
        Subset::create([
            'name' => 'Tema de prueba 1',
        ]);
        Subset::create([
            'name' => 'Tema de prueba 2',
        ]);
        Subset::create([
            'name' => 'Tema de prueba 3',
        ]);
        Subset::create([
            'name' => 'Tema de prueba 4',
        ]);
        Subset::create([
            'name' => 'Tema de prueba 5',
        ]);
    }
}

