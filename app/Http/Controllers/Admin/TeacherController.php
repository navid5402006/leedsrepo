<?php
// app/Http/Controllers/Admin/TeacherController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $teachers = Teacher::orderBy('id', 'desc')->get();
            return response()->json(['data' => $teachers]);
        }
        return view('admin.teacher');
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('admin.teacher');
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:teachers,email',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate teacher ID
        $lastTeacher = Teacher::orderBy('id', 'desc')->first();
        $nextId = $lastTeacher ? intval(substr($lastTeacher->teacher_id, 4)) + 1 : 1;
        $teacherId = 'TCH-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Handle profile image upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('teachers/profiles', $filename, 'public');
        }

        $teacher = Teacher::create([
            'teacher_id' => $teacherId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'qualification' => $request->qualification,
            'address' => $request->address,
            'status' => $request->status,
            'profile_image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher added successfully!',
            'data' => $teacher
        ]);
    }

    /**
     * Display the specified teacher.
     */
    public function show($id)
    {
        $teacher = Teacher::with('courses')->findOrFail($id);
        return response()->json(['data' => $teacher]);
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return response()->json(['data' => $teacher]);
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:teachers,email,' . $id,
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            if ($teacher->profile_image && Storage::disk('public')->exists($teacher->profile_image)) {
                Storage::disk('public')->delete($teacher->profile_image);
            }
            
            $file = $request->file('profile_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('teachers/profiles', $filename, 'public');
            $teacher->profile_image = $imagePath;
        }

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'qualification' => $request->qualification,
            'address' => $request->address,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher updated successfully!',
            'data' => $teacher
        ]);
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        
        // Check if teacher has any courses assigned (if the relationship exists)
        // Using a more safe approach - check if the relation method exists
        try {
            if (method_exists($teacher, 'courses') && $teacher->courses()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete teacher with assigned courses. Remove assignments first.'
                ], 400);
            }
        } catch (\Exception $e) {
            // If the relationship doesn't exist, proceed with deletion
            // This handles the case where courses.teacher_id doesn't exist
        }

        // Delete profile image if exists
        if ($teacher->profile_image && Storage::disk('public')->exists($teacher->profile_image)) {
            Storage::disk('public')->delete($teacher->profile_image);
        }

        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully!'
        ]);
    }

    /**
     * Get teacher statistics.
     */
    public function stats()
    {
        $total = Teacher::count();
        $active = Teacher::where('status', 'active')->count();
        $inactive = Teacher::where('status', 'inactive')->count();

        return response()->json([
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive
        ]);
    }
}