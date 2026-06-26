<?php

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

        // Get real data for dashboard
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

        // Recent data
        $recentStudents = Student::orderBy('id', 'desc')->limit(5)->get();
        $recentPayments = Payment::with(['enrollment.student'])->orderBy('id', 'desc')->limit(5)->get();
        $topCourses = Course::withCount('enrollments')->orderBy('enrollments_count', 'desc')->limit(4)->get();

        return view('admin.dashboard', compact(
            'admin', 'stats', 'recentStudents', 'recentPayments', 'topCourses'
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
}