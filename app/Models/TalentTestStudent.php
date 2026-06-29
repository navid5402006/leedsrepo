<?php
// app/Models/TalentTestStudent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TalentTestStudent extends Model
{
    use SoftDeletes;

    protected $table = 'talent_test_students';

    protected $fillable = [
        'candidate_name',
        'father_name',
        'contact_number',
        'email',
        'address',
        'registration_date',
        'course',
    ];

    public function attempts()
    {
        return $this->hasMany(TalentTestAttempt::class, 'candidate_id');
    }
}