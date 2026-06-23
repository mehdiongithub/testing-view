<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'org_id',
        'role',
        'permission_id',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

}
