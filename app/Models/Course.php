<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'original_fee',
        'duration',
        'teacher_id',
        'thumbnail',
        'course_code',
        'instructor_ids',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getCourseNameAttribute()
    {
        if ($this->course) {
            return $this->course->name;
        }
        return $this->course_name ?? 'N/A';
    }
}