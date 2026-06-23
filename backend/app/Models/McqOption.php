<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class McqOption extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
    ];

    /**
     * Each option belongs to one question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
