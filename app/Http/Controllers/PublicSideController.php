<?php
// app/Http/Controllers/PublicSideController.php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\Gallery;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicSideController extends Controller
{
    public function home()
    {
        $settings = Setting::getAllSettings();
        
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'courses' => Course::count(),
            'success_rate' => $this->calculateSuccessRate(),
        ];
        
        $courses = Course::where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        $teachers = Teacher::where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        // Get all courses for footer
        $allCourses = Course::where('status', true)->get();
       
        return view('public.home', compact('settings', 'stats', 'courses', 'teachers', 'allCourses'));
    }
    
    private function calculateSuccessRate()
    {
        $total = Student::count();
        if ($total === 0) return 98;
        
        $passed = Student::where('status', 'active')->count();
        return round(($passed / $total) * 100);
    }

        public function aboutus()
    {
        $settings = Setting::getAllSettings();
        $allCourses = Course::where('status', true)->get();
        
        // Get real stats from database
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'courses' => Course::count(),
            'success_rate' => $this->calculateSuccessRate(),
        ];
        
        return view('public.aboutus', compact('settings', 'allCourses', 'stats'));
    }


    public function courses()
    {
        $settings = Setting::getAllSettings();
        $courses = Course::where('status', true)->get();
        $allCourses = $courses;
        return view('public.courses', compact('settings', 'courses', 'allCourses'));
    }

    public function admissions()
    {
        $settings = Setting::getAllSettings();
        $allCourses = Course::where('status', true)->get();
        return view('public.admissions', compact('settings', 'allCourses'));
    }

    public function faq()
    {
        $settings = Setting::getAllSettings();
        $allCourses = Course::where('status', true)->get();
        return view('public.faq', compact('settings', 'allCourses'));
    }

    public function teachers()
{
    $settings = Setting::getAllSettings();
    $teachers = Teacher::where('status', true)->get();
    $allCourses = Course::where('status', true)->get();
    return view('public.teachers', compact('settings', 'teachers', 'allCourses'));
}


   public function gallery()
{
    $settings = Setting::getAllSettings();
    $galleries = Gallery::active()->ordered()->get();
    $allCourses = Course::where('status', true)->get();
    return view('public.gallery', compact('settings', 'galleries', 'allCourses'));
}


    public function contact()
    {
        $settings = Setting::getAllSettings();
        $courses = Course::where('status', true)->get();
        $allCourses = $courses;
        return view('public.contact', compact('settings', 'courses', 'allCourses'));
    }

    public function crtverfictaion()
    {
        $settings = Setting::getAllSettings();
        $allCourses = Course::where('status', true)->get();
        return view('public.crtverfictaion', compact('settings', 'allCourses'));
    }

    public function certifcate_number_verfy($certificate_number)
    {
        $settings = Setting::getAllSettings();
        $certificate = Certificate::where('certificate_number', $certificate_number)->first();
        $allCourses = Course::where('status', true)->get();
        return view('public.certificate_verify', compact('settings', 'certificate', 'allCourses'));
    }

    public function search_results(Request $request)
    {
        $settings = Setting::getAllSettings();
        $query = $request->get('q');
        $allCourses = Course::where('status', true)->get();
        return view('public.search_results', compact('settings', 'query', 'allCourses'));
    }

    public function Terms_Privacy()
    {
        $settings = Setting::getAllSettings();
        $allCourses = Course::where('status', true)->get();
        return view('public.terms_privacy', compact('settings', 'allCourses'));
    }

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