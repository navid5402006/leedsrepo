<?php
// app/Http/Controllers/Admin/StudentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Certificate;
use App\Models\StudentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $students = Student::orderBy('id', 'desc')->get();
                return response()->json([
                    'success' => true,
                    'data' => $students
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error loading students: ' . $e->getMessage(),
                    'data' => []
                ], 500);
            }
        }
        
        return view('admin.student');
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('admin.student');
    }

    /**
     * Generate a unique student ID.
     * Format: STU-XXXX (e.g., STU-0001, STU-0002)
     */
    private function generateStudentId(): string
    {
        $lastStudent = Student::withTrashed()->orderBy('id', 'desc')->first();
        
        if ($lastStudent && $lastStudent->student_id) {
            // Extract the number from the last student ID
            $lastNumber = (int) substr($lastStudent->student_id, 4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'STU-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a random student ID with prefix.
     * Format: STU-XXXXX (random alphanumeric)
     */
    private function generateRandomStudentId(): string
    {
        $prefix = 'STU-';
        $random = strtoupper(Str::random(5));
        return $prefix . $random;
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:students,email',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,pending',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate student ID with retry logic
        $studentId = null;
        $maxAttempts = 10;
        $attempt = 0;
        
        while ($attempt < $maxAttempts) {
            $attempt++;
            $generatedId = $this->generateStudentId();
            
            // Check if this ID already exists (including soft deleted)
            $exists = Student::withTrashed()->where('student_id', $generatedId)->exists();
            
            if (!$exists) {
                $studentId = $generatedId;
                break;
            }
        }
        
        // If all attempts failed, use random ID
        if (!$studentId) {
            $studentId = $this->generateRandomStudentId();
        }

        // Handle profile image upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('students/profiles', $filename, 'public');
        }

        $student = Student::create([
            'student_id' => $studentId,
            'name' => $request->name,
            'father_name' => $request->father_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'qualification' => $request->qualification,
            'status' => $request->status,
            'profile_image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student added successfully! Student ID: ' . $studentId,
            'data' => $student
        ]);
    }

    /**
     * Display the specified student.
     */
    public function show($id)
    {
        $student = Student::with(['enrollments.course', 'enrollments.payments', 'studentCard'])->findOrFail($id);
        
        // Get student statistics
        $totalEnrollments = $student->enrollments->count();
        $totalPaid = $student->enrollments->flatMap->payments->sum('amount');
        $totalFee = $student->enrollments->sum('final_fee');
        $remaining = $totalFee - $totalPaid;
        
        return response()->json([
            'success' => true,
            'data' => [
                'student' => $student,
                'stats' => [
                    'total_enrollments' => $totalEnrollments,
                    'total_fee' => $totalFee,
                    'total_paid' => $totalPaid,
                    'remaining' => $remaining,
                ]
            ]
        ]);
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:students,email,' . $id,
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,pending',
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
            // Delete old image
            if ($student->profile_image && Storage::disk('public')->exists($student->profile_image)) {
                Storage::disk('public')->delete($student->profile_image);
            }
            
            $file = $request->file('profile_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('students/profiles', $filename, 'public');
            $student->profile_image = $imagePath;
        }

        $student->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'qualification' => $request->qualification,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully!',
            'data' => $student
        ]);
    }

    /**
     * Permanently delete the specified student and all related data.
     */
    public function destroy($id)
    {
        $student = Student::with(['enrollments', 'studentCard'])->findOrFail($id);
        
        try {
            // Get all enrollment IDs
            $enrollmentIds = $student->enrollments()->pluck('id')->toArray();
            
            // Delete related payments and certificates
            if (!empty($enrollmentIds)) {
                Payment::whereIn('enrollment_id', $enrollmentIds)->delete();
                Certificate::whereIn('enrollment_id', $enrollmentIds)->delete();
            }
            
            // Delete enrollments
            $student->enrollments()->delete();
            
            // Delete student card
            if ($student->studentCard) {
                $student->studentCard->delete();
            }
            
            // Delete profile image
            if ($student->profile_image && Storage::disk('public')->exists($student->profile_image)) {
                Storage::disk('public')->delete($student->profile_image);
            }
            
            // Force delete student
            $student->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Student and all related data deleted permanently!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get student statistics.
     */
    public function stats()
    {
        $total = Student::count();
        $active = Student::where('status', 'active')->count();
        $inactive = Student::where('status', 'inactive')->count();
        $pending = Student::where('status', 'pending')->count();

        return response()->json([
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'pending' => $pending
        ]);
    }

    /**
     * Get students with their enrollment and payment info.
     */
    public function getStudentsWithDetails()
    {
        $students = Student::with(['enrollments.course', 'enrollments.payments'])
            ->get()
            ->map(function($student) {
                $totalFee = $student->enrollments->sum('final_fee');
                $totalPaid = $student->enrollments->flatMap->payments->sum('amount');
                $remaining = $totalFee - $totalPaid;
                
                return [
                    'id' => $student->id,
                    'student_id' => $student->student_id,
                    'name' => $student->name,
                    'father_name' => $student->father_name,
                    'phone' => $student->phone,
                    'email' => $student->email,
                    'status' => $student->status,
                    'total_enrollments' => $student->enrollments->count(),
                    'total_fee' => $totalFee,
                    'total_paid' => $totalPaid,
                    'remaining' => $remaining,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }
}