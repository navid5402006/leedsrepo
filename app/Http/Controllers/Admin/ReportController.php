<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $stats = $this->getStats();
        $reportData = $this->getFeeReportData();
        $totals = $this->calculateTotals($reportData);
        $courses = $this->getCourses();
        
        return view('admin.report', [
            'reportType' => 'fee',
            'reportTitle' => 'Student Fee Report',
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
            'courses' => $courses,
        ]);
    }

    public function feeReport()
    {
        $stats = $this->getStats();
        $reportData = $this->getFeeReportData();
        $totals = $this->calculateTotals($reportData);
        $courses = $this->getCourses();
        
        return view('admin.report', [
            'reportType' => 'fee',
            'reportTitle' => 'Student Fee Report',
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
            'courses' => $courses,
        ]);
    }

    public function remainingFeeReport()
    {
        $stats = $this->getStats();
        $allData = $this->getFeeReportData();
        $reportData = $allData->filter(function($row) {
            return $row->remaining > 0;
        })->values();
        
        $totals = $this->calculateTotals($reportData);
        $courses = $this->getCourses();
        
        return view('admin.report', [
            'reportType' => 'remaining',
            'reportTitle' => 'Remaining Fee Report',
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
            'courses' => $courses,
        ]);
    }

    public function monthlyCollection()
    {
        $stats = $this->getStats();
        $reportData = $this->getMonthlyCollectionData();
        $totals = $this->calculateTotals($reportData);
        $courses = $this->getCourses();
        
        return view('admin.report', [
            'reportType' => 'monthly',
            'reportTitle' => 'Monthly Collection Report',
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
            'courses' => $courses,
        ]);
    }

    public function weeklyCollection()
    {
        $stats = $this->getStats();
        $reportData = $this->getWeeklyCollectionData();
        $totals = $this->calculateTotals($reportData);
        $courses = $this->getCourses();
        
        return view('admin.report', [
            'reportType' => 'weekly',
            'reportTitle' => 'Weekly Collection Report',
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
            'courses' => $courses,
        ]);
    }

    public function dailyCollection()
    {
        $stats = $this->getStats();
        $reportData = $this->getDailyCollectionData();
        $totals = $this->calculateTotals($reportData);
        $courses = $this->getCourses();
        
        return view('admin.report', [
            'reportType' => 'daily',
            'reportTitle' => 'Daily Collection Report',
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
            'courses' => $courses,
        ]);
    }

    public function studentReport()
    {
        $stats = $this->getStats();
        $reportData = $this->getStudentReportData();
        $totals = $this->calculateTotals($reportData);
        $courses = $this->getCourses();
        
        return view('admin.report', [
            'reportType' => 'students',
            'reportTitle' => 'Student Report',
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
            'courses' => $courses,
        ]);
    }

    public function certificateReport()
    {
        $stats = $this->getStats();
        $reportData = $this->getCertificateReportData();
        $totals = $this->calculateTotals($reportData);
        $courses = $this->getCourses();
        
        return view('admin.report', [
            'reportType' => 'certificates',
            'reportTitle' => 'Certificate Report',
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
            'courses' => $courses,
        ]);
    }

    public function export($type)
    {
        return redirect()->route('admin.reports.index')->with('success', 'Report exported!');
    }

    // ─── AJAX Data Endpoints ───
    public function getReportData($reportType)
    {
        $stats = $this->getStats();
        
        switch($reportType) {
            case 'fee':
                $reportData = $this->getFeeReportData();
                break;
            case 'remaining':
                $allData = $this->getFeeReportData();
                $reportData = $allData->filter(function($row) {
                    return $row->remaining > 0;
                })->values();
                break;
            case 'monthly':
                $reportData = $this->getMonthlyCollectionData();
                break;
            case 'weekly':
                $reportData = $this->getWeeklyCollectionData();
                break;
            case 'daily':
                $reportData = $this->getDailyCollectionData();
                break;
            default:
                $reportData = collect();
        }

        $totals = $this->calculateTotals($reportData);

        return response()->json([
            'stats' => $stats,
            'reportData' => $reportData,
            'totals' => $totals,
        ]);
    }

    // ─── Private Helper Methods ───

    /**
     * Get courses list safely.
     */
    private function getCourses()
    {
        try {
            // Try to get courses with title column
            return Course::select('title')->distinct()->pluck('title');
        } catch (\Exception $e) {
            // If 'title' column doesn't exist, try 'name' or get from enrollments
            try {
                // Try 'name' column
                return Course::select('name')->distinct()->pluck('name');
            } catch (\Exception $e2) {
                // Fallback: get courses from enrollments
                return Enrollment::with('course')
                    ->get()
                    ->pluck('course.title')
                    ->filter()
                    ->unique()
                    ->values();
            }
        }
    }

    private function getStats()
    {
        $totalStudents = Student::count();
        
        // Total fee from enrollments - using final_fee
        $totalFee = Enrollment::sum('final_fee');
        
        // Total paid from payments - using amount
        $totalPaid = Payment::sum('amount');
        
        // Total remaining
        $totalRemaining = $totalFee - $totalPaid;
        
        // Monthly collection
        $monthlyCollection = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');
        
        // Overdue students - enrollments where final_fee > total paid
        $overdueStudents = Enrollment::where('final_fee', '>', 0)
            ->whereRaw('final_fee > (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE payments.enrollment_id = enrollments.id AND payments.deleted_at IS NULL)')
            ->count();

        $averageCollection = $totalStudents > 0 ? $totalPaid / $totalStudents : 0;

        return [
            'total_students' => $totalStudents,
            'total_fee' => $totalFee,
            'total_paid' => $totalPaid,
            'total_remaining' => $totalRemaining,
            'monthly_collection' => $monthlyCollection,
            'overdue_students' => $overdueStudents,
            'average_collection' => $averageCollection,
        ];
    }

    private function getFeeReportData()
    {
        return Enrollment::with(['student', 'course', 'payments'])
            ->get()
            ->map(function($enrollment) {
                $totalPaid = $enrollment->payments->sum('amount');
                $remaining = $enrollment->final_fee - $totalPaid;
                
                // Determine status
                $status = 'unpaid';
                if ($remaining <= 0) {
                    $status = 'paid';
                } elseif ($totalPaid > 0 && $remaining > 0) {
                    $status = 'partial';
                }
                
                // Get last payment date
                $lastPayment = $enrollment->payments->sortByDesc('payment_date')->first();
                
                // Get course name safely
                $courseName = 'N/A';
                if ($enrollment->course) {
                    $courseName = $enrollment->course->title ?? $enrollment->course->name ?? 'N/A';
                }
                
                return (object) [
                    'student_id' => $enrollment->student->id ?? 'N/A',
                    'student_name' => $enrollment->student->name ?? 'N/A',
                    'course_name' => $courseName,
                    'original_fee' => $enrollment->original_fee ?? 0,
                    'discount' => $enrollment->discount ?? 0,
                    'final_fee' => $enrollment->final_fee ?? 0,
                    'paid' => $totalPaid,
                    'remaining' => $remaining,
                    'last_payment' => $lastPayment?->payment_date?->format('d M Y') ?? 'N/A',
                    'status' => $status,
                ];
            });
    }

    private function getMonthlyCollectionData()
    {
        return Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->with(['enrollment.student', 'enrollment.course'])
            ->get()
            ->map(function($payment) {
                $enrollment = $payment->enrollment;
                $totalPaid = $enrollment->payments->sum('amount');
                $remaining = $enrollment->final_fee - $totalPaid;
                
                $status = 'unpaid';
                if ($remaining <= 0) {
                    $status = 'paid';
                } elseif ($totalPaid > 0 && $remaining > 0) {
                    $status = 'partial';
                }
                
                $courseName = 'N/A';
                if ($enrollment->course) {
                    $courseName = $enrollment->course->title ?? $enrollment->course->name ?? 'N/A';
                }
                
                return (object) [
                    'student_id' => $enrollment->student->id ?? 'N/A',
                    'student_name' => $enrollment->student->name ?? 'N/A',
                    'course_name' => $courseName,
                    'original_fee' => $enrollment->original_fee ?? 0,
                    'discount' => $enrollment->discount ?? 0,
                    'final_fee' => $enrollment->final_fee ?? 0,
                    'paid' => $totalPaid,
                    'remaining' => $remaining,
                    'last_payment' => $payment->payment_date ? $payment->payment_date->format('d M Y') : 'N/A',
                    'status' => $status,
                ];
            });
    }

    private function getWeeklyCollectionData()
    {
        return Payment::whereBetween('payment_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->with(['enrollment.student', 'enrollment.course'])
            ->get()
            ->map(function($payment) {
                $enrollment = $payment->enrollment;
                $totalPaid = $enrollment->payments->sum('amount');
                $remaining = $enrollment->final_fee - $totalPaid;
                
                $status = 'unpaid';
                if ($remaining <= 0) {
                    $status = 'paid';
                } elseif ($totalPaid > 0 && $remaining > 0) {
                    $status = 'partial';
                }
                
                $courseName = 'N/A';
                if ($enrollment->course) {
                    $courseName = $enrollment->course->title ?? $enrollment->course->name ?? 'N/A';
                }
                
                return (object) [
                    'student_id' => $enrollment->student->id ?? 'N/A',
                    'student_name' => $enrollment->student->name ?? 'N/A',
                    'course_name' => $courseName,
                    'original_fee' => $enrollment->original_fee ?? 0,
                    'discount' => $enrollment->discount ?? 0,
                    'final_fee' => $enrollment->final_fee ?? 0,
                    'paid' => $totalPaid,
                    'remaining' => $remaining,
                    'last_payment' => $payment->payment_date ? $payment->payment_date->format('d M Y') : 'N/A',
                    'status' => $status,
                ];
            });
    }

    private function getDailyCollectionData()
    {
        return Payment::whereDate('payment_date', today())
            ->with(['enrollment.student', 'enrollment.course'])
            ->get()
            ->map(function($payment) {
                $enrollment = $payment->enrollment;
                $totalPaid = $enrollment->payments->sum('amount');
                $remaining = $enrollment->final_fee - $totalPaid;
                
                $status = 'unpaid';
                if ($remaining <= 0) {
                    $status = 'paid';
                } elseif ($totalPaid > 0 && $remaining > 0) {
                    $status = 'partial';
                }
                
                $courseName = 'N/A';
                if ($enrollment->course) {
                    $courseName = $enrollment->course->title ?? $enrollment->course->name ?? 'N/A';
                }
                
                return (object) [
                    'student_id' => $enrollment->student->id ?? 'N/A',
                    'student_name' => $enrollment->student->name ?? 'N/A',
                    'course_name' => $courseName,
                    'original_fee' => $enrollment->original_fee ?? 0,
                    'discount' => $enrollment->discount ?? 0,
                    'final_fee' => $enrollment->final_fee ?? 0,
                    'paid' => $totalPaid,
                    'remaining' => $remaining,
                    'last_payment' => $payment->payment_date ? $payment->payment_date->format('d M Y') : 'N/A',
                    'status' => $status,
                ];
            });
    }

    private function getStudentReportData()
    {
        return Student::with(['enrollments.course', 'enrollments.payments'])
            ->get()
            ->map(function($student) {
                $totalFinalFee = $student->enrollments->sum('final_fee');
                $totalPaid = $student->enrollments->flatMap->payments->sum('amount');
                $remaining = $totalFinalFee - $totalPaid;
                $lastPayment = $student->enrollments->flatMap->payments->sortByDesc('payment_date')->first();
                
                $status = 'unpaid';
                if ($remaining <= 0) {
                    $status = 'paid';
                } elseif ($totalPaid > 0 && $remaining > 0) {
                    $status = 'partial';
                }
                
                $firstEnrollment = $student->enrollments->first();
                $courseName = 'N/A';
                if ($firstEnrollment && $firstEnrollment->course) {
                    $courseName = $firstEnrollment->course->title ?? $firstEnrollment->course->name ?? 'N/A';
                }
                
                return (object) [
                    'student_id' => $student->id ?? 'N/A',
                    'student_name' => $student->name ?? 'N/A',
                    'course_name' => $courseName,
                    'original_fee' => $student->enrollments->sum('original_fee'),
                    'discount' => $student->enrollments->sum('discount'),
                    'final_fee' => $totalFinalFee,
                    'paid' => $totalPaid,
                    'remaining' => $remaining,
                    'last_payment' => $lastPayment?->payment_date?->format('d M Y') ?? 'N/A',
                    'status' => $status,
                ];
            });
    }

    private function getCertificateReportData()
    {
        return Certificate::with(['enrollment.student', 'enrollment.course'])
            ->get()
            ->map(function($certificate) {
                $enrollment = $certificate->enrollment;
                $courseName = 'N/A';
                if ($enrollment && $enrollment->course) {
                    $courseName = $enrollment->course->title ?? $enrollment->course->name ?? 'N/A';
                }
                
                return (object) [
                    'student_id' => $enrollment->student->id ?? 'N/A',
                    'student_name' => $enrollment->student->name ?? 'N/A',
                    'course_name' => $courseName,
                    'certificate_no' => $certificate->certificate_no ?? 'N/A',
                    'issue_date' => $certificate->issue_date ? $certificate->issue_date->format('d M Y') : 'N/A',
                    'status' => 'issued',
                ];
            });
    }

    private function calculateTotals($data)
    {
        $finalFee = $data->sum('final_fee');
        $paid = $data->sum('paid');
        $remaining = $data->sum('remaining');
        
        return [
            'final_fee' => $finalFee,
            'paid' => $paid,
            'remaining' => $remaining,
        ];
    }
}