<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherProfile extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'org_id',
        'qualification',
        'specialization',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function organization()
    {
        return $this->belongsTo(
            Organization::class,
            'org_id'
        );
    }

}
