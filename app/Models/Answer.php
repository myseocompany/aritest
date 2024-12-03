<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    // Relación con la pregunta
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
