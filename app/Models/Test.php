<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "quiz",
        "tester",
        "start",
        "answers",
        "score",
        "totalScore",
        "end",
    ];

    public function getAnswersAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getTester() {
        return $this->belongsTo(User::class, 'tester');
    }

    public function tester()
    {
        return $this->getTester();
    }


    public function getQuiz() {
        return $this->belongsTo(quiz::class, 'quiz');
    }
}
