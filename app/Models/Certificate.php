<?php
// app/Models/Certificate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enrollment_id',
        'certificate_no',
        'issue_date',
        'student_name',
        'student_id',
        'course_name',
        'status',
        'title',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the enrollment that owns the certificate.
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the student through enrollment.
     */
    public function student()
    {
        return $this->hasOneThrough(
            Student::class,
            Enrollment::class,
            'id',
            'id',
            'enrollment_id',
            'student_id'
        );
    }

    /**
     * Get the course through enrollment.
     */
    public function course()
    {
        return $this->hasOneThrough(
            Course::class,
            Enrollment::class,
            'id',
            'id',
            'enrollment_id',
            'course_id'
        );
    }

    /**
     * Generate a unique certificate number.
     * Format: LA-CERT-YYYY-XXXX (e.g., LA-CERT-2026-0001)
     */
    public static function generateCertificateNumber(): string
{
    $prefix = "CRT";
    $digits = 4;
    $maxAttempts = 50;
    
    for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
        // Generate random number between 1000 and 9999 (ensures 4 digits, no leading zeros)
        $randomNumber = random_int(1000, 9999);
        $certificateNo = $prefix . $randomNumber;
        
        // Check if this number is already used (including soft deleted)
        $exists = self::withTrashed()
            ->where('certificate_no', $certificateNo)
            ->exists();
        
        if (!$exists) {
            return $certificateNo;
        }
    }
    
    // If we couldn't generate a unique number, use timestamp as fallback
    $timestamp = now()->format('ymdHis');
    return "CRT" . $timestamp;
}

/**
 * Generate a unique certificate number with retry logic.
 */
public static function generateUniqueCertificateNumber(int $maxAttempts = 50): string
{
    return self::generateCertificateNumber();
}

    /**
     * Alternative method: Find the next available number by finding gaps.
     * This is more efficient for large datasets.
     */
    public static function generateCertificateNumberOptimized(): string
    {
        $year = date('Y');
        $prefix = "LA-CERT-{$year}-";
        
        // Get all certificate numbers for this year (including soft deleted)
        $numbers = self::withTrashed()
            ->where('certificate_no', 'LIKE', $prefix . '%')
            ->pluck('certificate_no')
            ->map(function ($certNo) {
                return (int) substr($certNo, -4);
            })
            ->sort()
            ->values()
            ->toArray();
        
        if (empty($numbers)) {
            return $prefix . '0001';
        }
        
        // Find the first gap
        $expectedNumber = 1;
        foreach ($numbers as $number) {
            if ($number > $expectedNumber) {
                break;
            }
            $expectedNumber++;
        }
        
        return $prefix . str_pad($expectedNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if certificate number is unique (including soft deleted).
     */
    public static function isCertificateNumberUnique(string $certificateNo): bool
    {
        return !self::withTrashed()->where('certificate_no', $certificateNo)->exists();
    }

    /**
     * Check if certificate is verified.
     */
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    /**
     * Check if certificate is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if certificate is issued.
     */
    public function isIssued(): bool
    {
        return $this->status === 'issued';
    }

    /**
     * Mark certificate as verified.
     */
    public function markAsVerified(): bool
    {
        return $this->update(['status' => 'verified']);
    }

    /**
     * Mark certificate as pending.
     */
    public function markAsPending(): bool
    {
        return $this->update(['status' => 'pending']);
    }

    /**
     * Mark certificate as issued.
     */
    public function markAsIssued(): bool
    {
        return $this->update(['status' => 'issued']);
    }

    /**
     * Get the status label with color.
     */
    public function getStatusLabelAttribute(): array
    {
        $labels = [
            'issued' => ['label' => 'Issued', 'color' => 'blue'],
            'verified' => ['label' => 'Verified', 'color' => 'green'],
            'pending' => ['label' => 'Pending', 'color' => 'orange'],
        ];

        return $labels[$this->status] ?? ['label' => 'Unknown', 'color' => 'gray'];
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope a query to only include verified certificates.
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope a query to only include pending certificates.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include issued certificates.
     */
    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    /**
     * Scope a query to only include certificates issued in a specific year.
     */
    public function scopeYear($query, $year)
    {
        return $query->whereYear('issue_date', $year);
    }

    /**
     * Scope a query to only include certificates issued in a specific month.
     */
    public function scopeMonth($query, $month)
    {
        return $query->whereMonth('issue_date', $month);
    }

    /**
     * Scope a query to only include certificates issued between dates.
     */
    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereBetween('issue_date', [$from, $to]);
    }

    /**
     * Scope a query to search by certificate number.
     */
    public function scopeSearchByNumber($query, $search)
    {
        return $query->where('certificate_no', 'LIKE', "%{$search}%");
    }

    /**
     * Scope a query to search by student name.
     */
    public function scopeSearchByStudent($query, $search)
    {
        return $query->where('student_name', 'LIKE', "%{$search}%");
    }

    /**
     * Scope a query to search by course name.
     */
    public function scopeSearchByCourse($query, $search)
    {
        return $query->where('course_name', 'LIKE', "%{$search}%");
    }

    /**
     * Scope a query to search across multiple fields.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('certificate_no', 'LIKE', "%{$search}%")
              ->orWhere('student_name', 'LIKE', "%{$search}%")
              ->orWhere('student_id', 'LIKE', "%{$search}%")
              ->orWhere('course_name', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to get certificates issued today.
     */
    public function scopeIssuedToday($query)
    {
        return $query->whereDate('issue_date', today());
    }

    /**
     * Scope a query to get certificates issued this week.
     */
    public function scopeIssuedThisWeek($query)
    {
        return $query->whereBetween('issue_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope a query to get certificates issued this month.
     */
    public function scopeIssuedThisMonth($query)
    {
        return $query->whereMonth('issue_date', now()->month)
                     ->whereYear('issue_date', now()->year);
    }

    // ============================================
    // STATISTICS METHODS
    // ============================================

    /**
     * Get statistics for certificates.
     */
    public static function getStatistics(): array
    {
        return [
            'total' => self::count(),
            'verified' => self::verified()->count(),
            'pending' => self::pending()->count(),
            'issued' => self::issued()->count(),
            'issued_this_month' => self::issuedThisMonth()->count(),
            'issued_today' => self::issuedToday()->count(),
        ];
    }

    /**
     * Get certificates grouped by course.
     */
    public static function getCountByCourse(): array
    {
        return self::select('course_name', DB::raw('count(*) as count'))
                   ->groupBy('course_name')
                   ->pluck('count', 'course_name')
                   ->toArray();
    }

    /**
     * Get certificates grouped by month.
     */
    public static function getCountByMonth($year = null): array
    {
        $year = $year ?? date('Y');
        return self::select(DB::raw('MONTH(issue_date) as month'), DB::raw('count(*) as count'))
                   ->whereYear('issue_date', $year)
                   ->groupBy('month')
                   ->orderBy('month')
                   ->pluck('count', 'month')
                   ->toArray();
    }

    // ============================================
    // BOOT METHOD
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->certificate_no)) {
                $model->certificate_no = self::generateUniqueCertificateNumber();
            }
        });
    }
}