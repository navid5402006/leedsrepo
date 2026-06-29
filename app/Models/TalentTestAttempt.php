<?php
// app/Models/TalentTestAttempt.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TalentTestAttempt extends Model
{
    use SoftDeletes;

    protected $table = 'talent_test_attempts';

    protected $fillable = [
        'candidate_id',
        'roll_number',
        'test_date',
        'obtained_marks',
        'percentage',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(TalentTestStudent::class, 'candidate_id');
    }
}