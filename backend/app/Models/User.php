<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
   
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'phone',
        'auth_provider',
        'provider_id',
        'role',
        'is_active',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'admin_user_id');
    }

    public function orgMemberships()
    {
        return $this->hasMany(OrgMember::class, 'user_id');
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class);
    }

    public function teacherSubjects()
    {
        return $this->hasMany(
            TeacherSubject::class,
            'user_id'
        );
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function teachingClasses()
    {
        return $this->hasMany(OnlineClass::class, 'teacher_id');
    }

    public function classEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class);
    }

    public function enrolledClasses()
    {
        return $this->belongsToMany(OnlineClass::class, 'class_enrollments', 'user_id', 'online_classes_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

}
