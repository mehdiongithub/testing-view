<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'exam_id',
        'subject_id',
        'organization_id',
        'question_text',
        'q_type',
        'marks',
        'order_no',
    ];

    /**
     * Question belongs to an Exam
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Question belongs to a Subject
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * One question has many options (only for MCQ)
     */
    public function options()
    {
        return $this->hasMany(McqOption::class);
    }

    public function writtenAnswer()
    {
        return $this->hasOne(WrittenAnswer::class);
    }

    public function attemptAnswers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

}
