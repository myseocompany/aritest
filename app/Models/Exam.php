<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subset_id',
        'score',
        'total_questions',
        'correct_answers',
        'time_taken',
    ];

    /**
     * Relación uno a muchos inversa con User.
     * Un examen pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación uno a muchos inversa con Subset.
     * Un examen pertenece a un subset.
     */
    public function subset()
    {
        return $this->belongsTo(Subset::class);
    }

    /**
     * Relación uno a muchos con ExamAnswer.
     * Un examen tiene muchas respuestas de examen.
     */
    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class);
    }
}