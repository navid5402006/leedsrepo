<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',        // Add this
        'name',
        'father_name',
        'phone',             // Changed from 'phone' to match your form
        'email',
        'address',
        'date_of_birth',     // Changed from 'dob' to match your form
        'nationality',
        'qualification',
        'status',            // Add this
        'profile_image',     // Add this
    ];

    protected $casts = [
        'date_of_birth' => 'date',  // Changed from 'dob'
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

    public function certificates()
    {
        return $this->hasManyThrough(
            Certificate::class,
            Enrollment::class,
            'student_id',
            'enrollment_id',
            'id',
            'id'
        );
    }
}