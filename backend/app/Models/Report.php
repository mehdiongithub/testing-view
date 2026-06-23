<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'org_id',
        'user_id',
        'report_type',
        'filters',
        'data_snapshot',
        'generated_at',
    ];

    protected $casts = [
        'filters' => 'array',
        'data_snapshot' => 'array',
        'generated_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
