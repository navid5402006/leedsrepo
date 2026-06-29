<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Certificate;
use App\Models\StudentCard;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        // ─── Get Real Data ───
        $stats = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_courses' => Course::count(),
            'active_enrollments' => Enrollment::where('status', 'active')->count(),
            'total_revenue' => Payment::sum('amount'),
            'remaining_balance' => $this->calculateRemainingBalance(),
            'total_certificates' => Certificate::count(),
            'total_cards' => StudentCard::count(),
            'total_enquiries' => Enquiry::count(),
        ];

        // ─── Recent Data ───
        $recentStudents = Student::orderBy('id', 'desc')->limit(5)->get();
        $recentPayments = Payment::with(['enrollment.student'])->orderBy('id', 'desc')->limit(5)->get();
        $topCourses = Course::withCount('enrollments')->orderBy('enrollments_count', 'desc')->limit(4)->get();

        // ─── Monthly Revenue ───
        $monthlyRevenue = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        // ─── Student Growth (This Month vs Last Month) ───
        $currentMonthStudents = Student::whereMonth('created_at', now()->month)->count();
        $lastMonthStudents = Student::whereMonth('created_at', now()->subMonth()->month)->count();
        $studentGrowth = $currentMonthStudents - $lastMonthStudents;

        // ─── Collection Rate ───
        $totalFee = Enrollment::sum('final_fee');
        $totalPaid = Payment::sum('amount');
        $collectionRate = $totalFee > 0 ? round(($totalPaid / $totalFee) * 100) : 0;

        // ─── Recent Activity ───
        $recentActivities = $this->getRecentActivities();

        // ─── Upcoming Tasks ───
        $upcomingTasks = $this->getUpcomingTasks();

        return view('admin.dashboard', compact(
            'admin',
            'stats',
            'recentStudents',
            'recentPayments',
            'topCourses',
            'monthlyRevenue',
            'studentGrowth',
            'collectionRate',
            'recentActivities',
            'upcomingTasks'
        ));
    }

    /**
     * Calculate remaining balance.
     */
    private function calculateRemainingBalance()
    {
        $totalFee = Enrollment::sum('final_fee');
        $totalPaid = Payment::sum('amount');
        return $totalFee - $totalPaid;
    }

    /**
     * Get recent activities.
     */
    private function getRecentActivities()
    {
        $activities = [];

        // Recent enrollments
        $recentEnrollments = Enrollment::with(['student', 'course'])
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
        foreach ($recentEnrollments as $enrollment) {
            $activities[] = [
                'icon' => 'fa-user-plus',
                'text' => '<strong>' . ($enrollment->student->name ?? 'Unknown') . '</strong> enrolled in <strong>' . ($enrollment->course->name ?? 'Course') . '</strong>',
                'time' => $enrollment->created_at->diffForHumans(),
                'color' => '#E53935'
            ];
        }

        // Recent payments
        $recentPayments = Payment::with(['enrollment.student'])
            ->orderBy('id', 'desc')
            ->limit(2)
            ->get();
        foreach ($recentPayments as $payment) {
            $activities[] = [
                'icon' => 'fa-dollar-sign',
                'text' => 'Fee payment received from <strong>' . ($payment->enrollment->student->name ?? 'Unknown') . '</strong> (PKR ' . number_format($payment->amount, 0) . ')',
                'time' => $payment->created_at->diffForHumans(),
                'color' => '#FFC107'
            ];
        }

        // Recent certificates
        $recentCertificates = Certificate::orderBy('id', 'desc')->limit(2)->get();
        foreach ($recentCertificates as $cert) {
            $activities[] = [
                'icon' => 'fa-certificate',
                'text' => 'Certificate issued to <strong>' . ($cert->student_name ?? 'Student') . '</strong>',
                'time' => $cert->created_at->diffForHumans(),
                'color' => '#E53935'
            ];
        }

        // Sort by time (most recent first)
        usort($activities, function ($a, $b) {
            return strtotime($a['time']) - strtotime($b['time']);
        });

        return array_slice($activities, 0, 5);
    }

    /**
     * Get upcoming tasks.
     */
    private function getUpcomingTasks()
    {
        $tasks = [];

        // Pending fee payments
        $pendingPayments = Enrollment::where('status', 'active')
            ->where('final_fee', '>', 0)
            ->with(['student'])
            ->get();
        $pendingCount = $pendingPayments->count();

        if ($pendingCount > 0) {
            $tasks[] = [
                'icon' => 'fa-dollar-sign',
                'color' => '#E53935',
                'text' => 'Pending Fees',
                'detail' => $pendingCount . ' students',
                'link' => url('/admin/reports/remaining')
            ];
        }

        // Certificates to generate
        $certificatesPending = Certificate::where('status', 'pending')->count();
        if ($certificatesPending > 0) {
            $tasks[] = [
                'icon' => 'fa-certificate',
                'color' => '#FFC107',
                'text' => 'Certificates to Generate',
                'detail' => $certificatesPending . ' pending',
                'link' => url('/admin/certificates/create')
            ];
        }

        // New enquiries
        $newEnquiries = Enquiry::where('status', 'new')->count();
        if ($newEnquiries > 0) {
            $tasks[] = [
                'icon' => 'fa-envelope',
                'color' => '#0B3C6D',
                'text' => 'New Enquiries',
                'detail' => $newEnquiries . ' unread',
                'link' => url('/admin/enquiries')
            ];
        }

        // If no tasks, add a default
        if (empty($tasks)) {
            $tasks[] = [
                'icon' => 'fa-check-circle',
                'color' => '#10B981',
                'text' => 'All caught up!',
                'detail' => 'No pending tasks',
                'link' => '#'
            ];
        }

        return $tasks;
    }

    /**
     * Get dashboard stats (AJAX).
     */
    public function getStats()
    {
        $totalFee = Enrollment::sum('final_fee');
        $totalPaid = Payment::sum('amount');

        return response()->json([
            'success' => true,
            'data' => [
                'total_students' => Student::count(),
                'total_teachers' => Teacher::count(),
                'total_courses' => Course::count(),
                'active_enrollments' => Enrollment::where('status', 'active')->count(),
                'total_revenue' => $totalPaid,
                'remaining_balance' => $totalFee - $totalPaid,
                'total_certificates' => Certificate::count(),
                'total_cards' => StudentCard::count(),
                'total_enquiries' => Enquiry::count(),
                'monthly_revenue' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
                'collection_rate' => $totalFee > 0 ? round(($totalPaid / $totalFee) * 100) : 0,
            ]
        ]);
    }
}