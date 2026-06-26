<?php
// app/Models/TalentTestStudent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected $casts = [
        'registration_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get all attempts for this candidate.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(TalentTestAttempt::class, 'candidate_id');
    }

    /**
     * Get total number of attempts.
     */
    public function getTotalAttemptsAttribute()
    {
        return $this->attempts()->count();
    }

    /**
     * Get the last test date.
     */
    public function getLastTestDateAttribute()
    {
        $lastAttempt = $this->attempts()->orderBy('test_date', 'desc')->first();
        return $lastAttempt ? $lastAttempt->test_date : null;
    }

    /**
     * Get the last test attempt.
     */
    public function getLastAttemptAttribute()
    {
        return $this->attempts()->orderBy('test_date', 'desc')->first();
    }

    /**
     * Get the highest score.
     */
    public function getHighestScoreAttribute()
    {
        return $this->attempts()->max('percentage') ?? 0;
    }

    /**
     * Get the average score.
     */
    public function getAverageScoreAttribute()
    {
        return $this->attempts()->avg('percentage') ?? 0;
    }

    /**
     * Get passed attempts count.
     */
    public function getPassedAttemptsAttribute()
    {
        return $this->attempts()->where('status', 'pass')->count();
    }

    /**
     * Get failed attempts count.
     */
    public function getFailedAttemptsAttribute()
    {
        return $this->attempts()->where('status', 'fail')->count();
    }

    /**
     * Get pending attempts count.
     */
    public function getPendingAttemptsAttribute()
    {
        return $this->attempts()->where('status', 'pending')->count();
    }

    /**
     * Scope for searching candidates.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('candidate_name', 'LIKE', "%{$search}%")
                     ->orWhere('father_name', 'LIKE', "%{$search}%")
                     ->orWhere('contact_number', 'LIKE', "%{$search}%");
    }
}