<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttemptAnswer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option_id',
        'written_response',
        'is_correct',
    ];

    /**
     * Belongs to exam attempt
     */
    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'attempt_id');
    }

    /**
     * Belongs to question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Selected MCQ option (if MCQ question)
     */
    public function selectedOption()
    {
        return $this->belongsTo(McqOption::class, 'selected_option_id');
    }

}
