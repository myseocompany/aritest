<?php

// database/seeders/ExamSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\User;
use App\Models\Subset;

class ExamSeeder extends Seeder
{
    public function run()
    {
        // Crear exámenes para usuarios
        $user = User::first();  // Asume que hay al menos un usuario
        $subset = Subset::first();  // Asume que hay al menos un subset

        Exam::create([
            'user_id' => $user->id,
            'subset_id' => $subset->id,
            'score' => 85.5,
            'total_questions' => 5,
            'correct_answers' => 4,
            'time_taken' => 30,
        ]);
    }
}
