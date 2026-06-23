<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WrittenAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'model_answer',
        'marking_scheme',
    ];

    /**
     * Each written answer belongs to a question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
