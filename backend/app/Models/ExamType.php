<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];
    public function governmentPosts()
    {
        return $this->hasMany(GovernmentPost::class);
    }
}
