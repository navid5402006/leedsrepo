<?php
// app/Models/TalentTestAttempt.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $casts = [
        'test_date' => 'date',
        'obtained_marks' => 'integer',
        'percentage' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Status constants.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PASS = 'pass';
    const STATUS_FAIL = 'fail';

    /**
     * Get the candidate for this attempt.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(TalentTestStudent::class, 'candidate_id');
    }

    /**
     * Get candidate name.
     */
    public function getCandidateNameAttribute()
    {
        return $this->candidate?->candidate_name;
    }

    /**
     * Get father name.
     */
    public function getFatherNameAttribute()
    {
        return $this->candidate?->father_name;
    }

    /**
     * Get contact number.
     */
    public function getContactNumberAttribute()
    {
        return $this->candidate?->contact_number;
    }

    /**
     * Check if attempt is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if attempt is passed.
     */
    public function isPassed(): bool
    {
        return $this->status === self::STATUS_PASS;
    }

    /**
     * Check if attempt is failed.
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAIL;
    }

    /**
     * Get status label with color.
     */
    public function getStatusLabelAttribute(): array
    {
        return match($this->status) {
            self::STATUS_PENDING => ['label' => 'Pending', 'class' => 'pending'],
            self::STATUS_PASS => ['label' => 'Pass', 'class' => 'pass'],
            self::STATUS_FAIL => ['label' => 'Fail', 'class' => 'fail'],
            default => ['label' => 'Unknown', 'class' => 'pending'],
        };
    }

    /**
     * Get formatted roll number.
     */
    public function getFormattedRollNumberAttribute(): string
    {
        return $this->roll_number ?? 'N/A';
    }

    /**
     * Get percentage formatted.
     */
    public function getFormattedPercentageAttribute(): string
    {
        return $this->percentage !== null ? number_format($this->percentage, 1) . '%' : '-';
    }

    /**
     * Get obtained marks formatted.
     */
    public function getFormattedMarksAttribute(): string
    {
        return $this->obtained_marks !== null ? $this->obtained_marks . '/100' : '-';
    }

    /**
     * Scope for pending attempts.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope for passed attempts.
     */
    public function scopePassed($query)
    {
        return $query->where('status', self::STATUS_PASS);
    }

    /**
     * Scope for failed attempts.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAIL);
    }

    /**
     * Scope for attempts with results published.
     */
    public function scopePublished($query)
    {
        return $query->whereIn('status', [self::STATUS_PASS, self::STATUS_FAIL]);
    }

    /**
     * Scope for attempts by date range.
     */
    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereBetween('test_date', [$from, $to]);
    }

    /**
     * Calculate percentage.
     */
    public function calculatePercentage(): ?float
    {
        if ($this->obtained_marks === null) {
            return null;
        }
        return ($this->obtained_marks / 100) * 100;
    }

    /**
     * Determine status based on marks.
     */
    public function determineStatus(): string
    {
        if ($this->obtained_marks === null) {
            return self::STATUS_PENDING;
        }
        return $this->obtained_marks >= 50 ? self::STATUS_PASS : self::STATUS_FAIL;
    }

    /**
     * Boot method for auto-generating roll number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->roll_number)) {
                $model->roll_number = self::generateRollNumber();
            }
        });
    }

    /**
     * Generate a unique roll number.
     */
    public static function generateRollNumber(): string
    {
        $lastAttempt = self::orderBy('id', 'desc')->first();
        if ($lastAttempt && $lastAttempt->roll_number) {
            $lastNumber = (int) substr($lastAttempt->roll_number, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1100;
        }
        return 'TT-' . $newNumber;
    }

    /**
     * Generate a unique roll number with prefix.
     */
    public static function generateRollNumberWithPrefix(string $prefix = 'TT'): string
    {
        $lastAttempt = self::orderBy('id', 'desc')->first();
        if ($lastAttempt && $lastAttempt->roll_number) {
            $lastNumber = (int) substr($lastAttempt->roll_number, strlen($prefix) + 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1100;
        }
        return $prefix . '-' . $newNumber;
    }

    /**
     * Check if roll number is unique.
     */
    public static function isRollNumberUnique(string $rollNumber): bool
    {
        return !self::withTrashed()->where('roll_number', $rollNumber)->exists();
    }
}