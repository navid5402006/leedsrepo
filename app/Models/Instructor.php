<?php
// app/Models/Instructor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'status',
    ];

    /**
     * Get courses for this instructor
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_instructor');
    }
}