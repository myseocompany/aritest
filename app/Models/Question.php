<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si el nombre coincide con el plural del modelo)
    protected $table = 'questions';

    // Indica si la tabla tiene marcas de tiempo automáticas (created_at y updated_at)
    public $timestamps = true;

    // Clave primaria
    protected $primaryKey = 'id';

    // Los atributos que se pueden asignar en masa
    protected $fillable = [
        'question_text',
        'question_type',
        'explanation',
    ];

    // Los atributos que se deben convertir a tipos específicos
    protected $casts = [
        'question_type' => 'string', // Enum como string
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con el modelo de respuestas (answers)
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
