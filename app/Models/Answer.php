<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si el nombre coincide con el plural del modelo)
    protected $table = 'answers';

    // Indica si la tabla tiene marcas de tiempo automáticas (created_at y updated_at)
    public $timestamps = true;

    // Clave primaria
    protected $primaryKey = 'id';

    // Los atributos que se pueden asignar en masa
    protected $fillable = [
        'question_id',
        'answer_text',
        'is_correct',
    ];

    // Los atributos que se deben convertir a tipos específicos
    protected $casts = [
        'is_correct' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con el modelo de preguntas (questions)
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
