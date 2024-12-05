<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'question_type',
        'explanation',
        'topic_id'
    ];

    
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    public $timestamps = true;

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function subsets()
    {
        return $this->belongsToMany(Subset::class, 'question_subset', 'question_id', 'subset_id');
    }
}
