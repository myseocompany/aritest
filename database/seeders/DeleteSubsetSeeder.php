<?php

// database/seeders/DeleteSubsetSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subset;

class DeleteSubsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Eliminar los subsets de prueba
        Subset::where('name', 'like', 'Tema de prueba%')->delete();
    }
}

