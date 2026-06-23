<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherSubject extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'user_id',
        'subject_id',
        'org_id',
    ];


    public function teacher()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    public function subject()
    {
        return $this->belongsTo(
            Subject::class
        );
    }


    public function organization()
    {
        return $this->belongsTo(
            Organization::class,
            'org_id'
        );
    }

}
