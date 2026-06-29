<?php
// app/Models/Student.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'name',
        'father_name',
        'phone',
        'email',
        'address',
        'date_of_birth',
        'nationality',
        'qualification',
        'status',
        'profile_image',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function studentCard()
    {
        return $this->hasOne(StudentCard::class);
    }

    // FIX: Add this relationship to get certificates through enrollments
    public function certificates(): HasManyThrough
    {
        return $this->hasManyThrough(
            Certificate::class,
            Enrollment::class,
            'student_id',  // Foreign key on enrollments table
            'enrollment_id', // Foreign key on certificates table
            'id',           // Local key on students table
            'id'            // Local key on enrollments table
        );
    }

    // Alternative: Get certificates with course and enrollment data
    public function certificatesWithDetails()
    {
        return $this->hasManyThrough(
            Certificate::class,
            Enrollment::class,
            'student_id',
            'enrollment_id',
            'id',
            'id'
        )->with(['enrollment.course']);
    }
}