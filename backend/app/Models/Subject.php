<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'org_id',
        'name',
        'slug',
        'description',
        'is_global',
    ];


    public function organization()
    {
        return $this->belongsTo(
            Organization::class,
            'org_id'
        );
    }

    public function teachers()
    {
        return $this->belongsToMany(
            User::class,
            'teacher_subjects'
        )
        ->withPivot('org_id')
        ->withTimestamps();
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function classes()
    {
        return $this->hasMany(OnlineClass::class);
    }

}
