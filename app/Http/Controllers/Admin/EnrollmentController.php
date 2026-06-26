<?php
// app/Http/Controllers/Admin/EnrollmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of enrollments.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $enrollments = Enrollment::with(['student', 'course'])->orderBy('id', 'desc')->get();
            return response()->json(['data' => $enrollments]);
        }
        
        // Get students and courses for dropdowns
        $students = Student::where('status', 'active')->get();
        $courses = Course::where('status', 'active')->get();
        return view('admin.enrollment', compact('students', 'courses'));
    }

    /**
     * Show the form for creating a new enrollment.
     */
    public function create()
    {
        $students = Student::where('status', 'active')->get();
        $courses = Course::where('status', 'active')->get();
        return view('admin.enrollment', compact('students', 'courses'));
    }

    /**
     * Store a newly created enrollment in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
            'original_fee' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'final_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,withdrawn',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $enrollment = Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'enrollment_date' => $request->enrollment_date,
            'original_fee' => $request->original_fee,
            'discount' => $request->discount ?? 0,
            'final_fee' => $request->final_fee,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment created successfully!',
            'data' => $enrollment
        ]);
    }

    /**
     * Display the specified enrollment.
     */
    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        return response()->json(['data' => $enrollment]);
    }

    /**
     * Show the form for editing the specified enrollment.
     */
    public function edit($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        $students = Student::where('status', 'active')->get();
        $courses = Course::where('status', 'active')->get();
        
        return response()->json([
            'success' => true,
            'data' => $enrollment,
            'students' => $students,
            'courses' => $courses
        ]);
    }

    /**
     * Update the specified enrollment in storage.
     */
    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
            'original_fee' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'final_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,withdrawn',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $enrollment->update([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'enrollment_date' => $request->enrollment_date,
            'original_fee' => $request->original_fee,
            'discount' => $request->discount ?? 0,
            'final_fee' => $request->final_fee,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment updated successfully!',
            'data' => $enrollment
        ]);
    }

    /**
     * Remove the specified enrollment from storage.
     */
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        
        // Check if enrollment has payments
        if ($enrollment->payments()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete enrollment with existing payments.'
            ], 400);
        }

        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enrollment deleted successfully!'
        ]);
    }

    /**
     * Get enrollment statistics.
     */
    public function stats()
    {
        $total = Enrollment::count();
        $active = Enrollment::where('status', 'active')->count();
        $completed = Enrollment::where('status', 'completed')->count();
        $withdrawn = Enrollment::where('status', 'withdrawn')->count();

        return response()->json([
            'total' => $total,
            'active' => $active,
            'completed' => $completed,
            'withdrawn' => $withdrawn
        ]);
    }
}