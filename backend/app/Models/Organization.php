<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'admin_user_id',
        'name',
        'slug',
        'logo',
        'address',
        'is_active',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function members()
    {
        return $this->hasMany(OrgMember::class, 'org_id');
    }

    public function studentProfiles()
    {
        return $this->hasMany(StudentProfile::class, 'org_id');
    }

    public function teacherProfiles()
    {
        return $this->hasMany(
            TeacherProfile::class,
            'org_id'
        );
    }

    public function subjects()
    {
        return $this->hasMany(
            Subject::class,
            'org_id'
        );
    }

    public function teacherSubjects()
    {
        return $this->hasMany(
            TeacherSubject::class,
            'org_id'
        );
    }

    public function governmentPosts()
    {
        return $this->hasMany(
            GovernmentPost::class,
            'org_id'
        );
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'org_id');
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function classes()
    {
        return $this->hasMany(OnlineClass::class, 'org_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'org_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
