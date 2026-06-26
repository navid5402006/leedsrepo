<?php
// app/Http/Controllers/Admin/CourseController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // If AJAX request, return JSON data
        if ($request->ajax()) {
            $courses = Course::orderBy('id', 'desc')->get();
            return response()->json(['data' => $courses]);
        }
        
        // For non-AJAX requests, return the view
        $instructors = Teacher::where('status', 'active')->get();
        return view('admin.course', compact('instructors'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $instructors = Teacher::where('status', 'active')->get();
        return view('admin.course', compact('instructors'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'original_fee' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending',
            'instructors' => 'nullable|array',
            'instructors.*' => 'exists:teachers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate course code
        $lastCourse = Course::orderBy('id', 'desc')->first();
        $nextId = $lastCourse ? intval(substr($lastCourse->course_code, 4)) + 1 : 1;
        $courseCode = 'CRS-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $course = Course::create([
            'course_code' => $courseCode,
            'name' => $request->name,
            'original_fee' => $request->original_fee,
            'duration' => $request->duration,
            'description' => $request->description,
            'status' => $request->status,
            'instructor_ids' => $request->instructors ? json_encode($request->instructors) : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course added successfully!',
            'data' => $course
        ]);
    }

    /**
     * Display the specified course.
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json(['data' => $course]);
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $instructors = Teacher::where('status', 'active')->get();
        
        // Decode instructor_ids if exists
        if ($course->instructor_ids) {
            $course->instructor_ids = json_decode($course->instructor_ids, true);
        }
        
        return response()->json([
            'success' => true,
            'data' => $course,
            'instructors' => $instructors
        ]);
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'original_fee' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending',
            'instructors' => 'nullable|array',
            'instructors.*' => 'exists:teachers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $course->update([
            'name' => $request->name,
            'original_fee' => $request->original_fee,
            'duration' => $request->duration,
            'description' => $request->description,
            'status' => $request->status,
            'instructor_ids' => $request->instructors ? json_encode($request->instructors) : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully!',
            'data' => $course
        ]);
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        
        // Check if course has enrollments
        if ($course->enrollments()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete course with existing enrollments. Archive instead.'
            ], 400);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully!'
        ]);
    }

    /**
     * Get course statistics.
     */
    public function stats()
    {
        $total = Course::count();
        $active = Course::where('status', 'active')->count();
        $inactive = Course::where('status', 'inactive')->count();
        $pending = Course::where('status', 'pending')->count();

        return response()->json([
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'pending' => $pending
        ]);
    }
}