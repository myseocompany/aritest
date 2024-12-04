<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_id',
        'answer_id',
        'is_correct',
    ];

    /**
     * Relación uno a muchos inversa con Exam.
     * Una respuesta de examen pertenece a un examen.
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Relación uno a muchos inversa con Question.
     * Una respuesta de examen pertenece a una pregunta.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relación uno a muchos inversa con Answer.
     * Una respuesta de examen pertenece a una respuesta.
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}