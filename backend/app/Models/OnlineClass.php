<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineClass extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'org_id',
        'teacher_id',
        'subject_id',
        'title',
        'class_type',
        'stream_url',
        'record_url',
        'scheduled_at',
        'duration_minutes',
        'is_active',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function enrollments()
    {
        return $this->hasMany(ClassEnrollment::class, 'online_classes_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_enrollments', 'online_classes_id', 'user_id');
    }

}
