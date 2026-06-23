<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'org_id',
        'subject_id',
        'gov_post_id',
        'title',
        'exam_type',
        'is_paid',
        'price',
        'duration_minutes',
        'is_active',
    ];


    /**
     * Organization relationship
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }


    /**
     * Subject relationship
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    /**
     * Government Post relationship
     */
    public function governmentPost()
    {
        return $this->belongsTo(GovernmentPost::class, 'gov_post_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

}
