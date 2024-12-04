<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 

class Subset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relación muchos a muchos con Question.
     * Un subset puede tener muchas preguntas y una pregunta puede pertenecer a muchos subsets.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }

    /**
     * Relación uno a muchos con Exam.
     * Un subset puede tener muchos exámenes.
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}