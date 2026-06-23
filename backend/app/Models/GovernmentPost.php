<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GovernmentPost extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'org_id',
        'country_id',
        'title',
        'department',
        'exam_type',
        'is_active',
    ];


    public function organization()
    {
        return $this->belongsTo(
            Organization::class,
            'org_id'
        );
    }


    public function country()
    {
        return $this->belongsTo(
            Country::class
        );
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'gov_post_id');
    }

}
