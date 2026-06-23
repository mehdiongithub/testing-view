<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassEnrollment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'online_classes_id',
        'user_id',
    ];

    public function class()
    {
        return $this->belongsTo(OnlineClass::class, 'online_classes_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
