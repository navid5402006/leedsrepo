<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\Enquiry;  // <-- ADD THIS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  // <-- ADD THIS

class PublicSideController extends Controller
{
    public function home()
    {
        // Get all settings
        $settings = Setting::getAllSettings();
        
        // Get real data from database
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'courses' => Course::count(),
            'success_rate' => $this->calculateSuccessRate(),
        ];
        
        // Get featured courses (limit to 6)
        $courses = Course::with('teacher')
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        // Get teachers (limit to 4)
        $teachers = Teacher::where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
       
        return view('public.home', compact('settings', 'stats', 'courses', 'teachers'));
    }
    
    private function calculateSuccessRate()
    {
        $total = Student::count();
        if ($total === 0) return 98; // Default value
        
        $passed = Student::where('status', 'passed')->count();
        return round(($passed / $total) * 100);
    }

    public function aboutus()
    {
        $settings = Setting::getAllSettings();
        return view('public.aboutus', compact('settings'));
    }

    public function courses()
    {
        $settings = Setting::getAllSettings();
        $courses = Course::where('status', true)->get();
        return view('public.courses', compact('settings', 'courses'));
    }

    public function admissions()
    {
        $settings = Setting::getAllSettings();
        return view('public.admissions', compact('settings'));
    }

    public function faq()
    {
        $settings = Setting::getAllSettings();
        return view('public.faq', compact('settings'));
    }

    public function teachers()
    {
        $settings = Setting::getAllSettings();
        $teachers = Teacher::where('status', true)->get();
        return view('public.teachers', compact('settings', 'teachers'));
    }

    public function gallery()
    {
        $settings = Setting::getAllSettings();
        return view('public.gallery', compact('settings'));
    }

    public function contact()
    {
        $settings = Setting::getAllSettings();
        // Get courses for the dropdown
        $courses = Course::where('status', true)->get();
        return view('public.contact', compact('settings', 'courses'));
    }

    public function crtverfictaion()
    {
        $settings = Setting::getAllSettings();
        return view('public.crtverfictaion', compact('settings'));
    }

    public function certifcate_number_verfy($certificate_number)
    {
        $settings = Setting::getAllSettings();
        $certificate = Certificate::where('certificate_number', $certificate_number)->first();
        return view('public.certificate_verify', compact('settings', 'certificate'));
    }

    public function search_results(Request $request)
    {
        $settings = Setting::getAllSettings();
        $query = $request->get('q');
        // Add search logic here
        return view('public.search_results', compact('settings', 'query'));
    }

    public function Terms_Privacy()
    {
        $settings = Setting::getAllSettings();
        return view('public.terms_privacy', compact('settings'));
    }

    // Store Enquiry from Contact Form
    public function storeEnquiry(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'interested_course' => 'nullable|string|max:255',
                'message' => 'nullable|string',
            ]);

            $enquiry = Enquiry::create([
                'full_name' => $validated['full_name'],
                'phone_number' => $validated['phone_number'],
                'email' => $validated['email'],
                'interested_course' => $validated['interested_course'] ?? null,
                'message' => $validated['message'] ?? null,
                'status' => 'new',
            ]);

            // Optional: Send email notification to admin
            // Mail::to('admin@leedsinstitute.edu.pk')->send(new NewEnquiryNotification($enquiry));

            return response()->json([
                'success' => true,
                'message' => 'Your enquiry has been submitted successfully! We will contact you shortly.',
                'data' => $enquiry
            ]);

        } catch (\Exception $e) {
            Log::error('Enquiry submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}