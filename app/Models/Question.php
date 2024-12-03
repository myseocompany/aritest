<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Relación con las respuestas
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
