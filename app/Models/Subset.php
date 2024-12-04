<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subset extends Model
{
    function questions(){
        return $this->hasMany(Question::class);
    }
}
