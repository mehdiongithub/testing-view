<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'exam_id',
        'amount',
        'status',
        'gateway',
        'txn_id',
        'paid_at',
    ];

    /**
     * Payment belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Payment belongs to an exam
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

}
