<?php
// app/Http/Controllers/Admin/CertificateController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    /**
     * Display a listing of certificates.
     */
    public function index(Request $request)
    {
        $query = Certificate::query();

        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('certificate_no', 'LIKE', "%{$search}%")
                  ->orWhere('student_name', 'LIKE', "%{$search}%")
                  ->orWhere('student_id', 'LIKE', "%{$search}%")
                  ->orWhere('course_name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('student')) {
            $query->where('student_name', 'LIKE', "%{$request->student}%");
        }

        if ($request->filled('cert_no')) {
            $query->where('certificate_no', 'LIKE', "%{$request->cert_no}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('course')) {
            $query->where('course_name', $request->course);
        }

        if ($request->filled('date')) {
            $query->whereDate('issue_date', $request->date);
        }

        $certificates = $query->orderBy('id', 'desc')->paginate(15);

        // Stats
        $stats = [
            'total' => Certificate::count(),
            'issued_this_month' => Certificate::whereMonth('issue_date', now()->month)
                                        ->whereYear('issue_date', now()->year)
                                        ->count(),
            'pending' => Certificate::where('status', 'pending')->count(),
            'verified' => Certificate::where('status', 'verified')->count(),
        ];

        // Get unique courses for filter
        $courses = Certificate::select('course_name')->distinct()->pluck('course_name');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'certificates' => $certificates,
                'stats' => $stats,
                'courses' => $courses,
            ]);
        }

        return view('admin.certificate', compact('certificates', 'stats', 'courses'));
    }

    /**
     * Get students for dropdown.
     */
    public function getStudents(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('father_name', 'LIKE', "%{$search}%")
                  ->orWhere('student_id', 'LIKE', "%{$search}%");
            });
        }

        $students = $query->limit(20)->get();

        return response()->json($students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'father' => $student->father_name ?? 'N/A',
                'student_id' => $student->student_id ?? 'STU-' . str_pad($student->id, 3, '0', STR_PAD_LEFT),
                'registration_no' => $student->registration_no ?? 'N/A',
            ];
        }));
    }

    /**
     * Get student data with enrollments for certificate generation.
     */
    public function getStudentData($studentId)
    {
        $student = Student::with(['enrollments.course'])->findOrFail($studentId);
        
        $enrollments = $student->enrollments->map(function ($enrollment) {
            return [
                'id' => $enrollment->id,
                'course' => $enrollment->course->name ?? 'Unknown Course',
                'duration' => $enrollment->course->duration ?? 'N/A',
                'cert_exists' => Certificate::where('enrollment_id', $enrollment->id)->exists(),
                'enrollment_id' => $enrollment->id,
            ];
        });

        return response()->json([
            'id' => $student->id,
            'name' => $student->name,
            'father' => $student->father_name ?? 'N/A',
            'regNo' => $student->registration_no ?? 'N/A',
            'student_id' => $student->student_id ?? 'STU-' . str_pad($student->id, 3, '0', STR_PAD_LEFT),
            'enrollments' => $enrollments,
        ]);
    }

    /**
     * Store certificates.
     */
   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'student_id' => 'required|exists:students,id',
        'enrollment_ids' => 'required|array',
        'enrollment_ids.*' => 'exists:enrollments,id',
        'issue_date' => 'required|date',
        'title' => 'nullable|string|max:255',
        'remarks' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        DB::beginTransaction();

        $student = Student::find($request->student_id);
        $generated = [];
        $errors = [];

        foreach ($request->enrollment_ids as $enrollmentId) {
            // Check if certificate already exists (including soft deleted)
            $existing = Certificate::withTrashed()
                ->where('enrollment_id', $enrollmentId)
                ->first();
                
            if ($existing) {
                $errors[] = "Certificate already exists for enrollment #{$enrollmentId}";
                continue;
            }

            $enrollment = Enrollment::find($enrollmentId);
            
            // Generate unique certificate number
            $certificateNo = Certificate::generateUniqueCertificateNumber();
            
            // Double check uniqueness
            if (!Certificate::isCertificateNumberUnique($certificateNo)) {
                // If still not unique, try one more time
                $certificateNo = Certificate::generateCertificateNumberOptimized();
                if (!Certificate::isCertificateNumberUnique($certificateNo)) {
                    $errors[] = "Failed to generate unique certificate number for enrollment #{$enrollmentId}";
                    continue;
                }
            }

            $certificate = Certificate::create([
                'enrollment_id' => $enrollmentId,
                'certificate_no' => $certificateNo,
                'issue_date' => $request->issue_date,
                'remarks' => $request->remarks,
                'title' => $request->title ?? 'Certificate of Completion',
                'status' => 'issued',
                'student_name' => $student->name,
                'student_id' => $student->student_id ?? 'STU-' . str_pad($student->id, 3, '0', STR_PAD_LEFT),
                'course_name' => $enrollment->course->name ?? 'Unknown Course',
            ]);

            $generated[] = $certificate;
        }

        DB::commit();

        $message = count($generated) . ' certificate(s) generated successfully!';
        if (!empty($errors)) {
            $message .= ' However, ' . count($errors) . ' enrollment(s) had issues: ' . implode(', ', $errors);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'certificates' => $generated,
            'count' => count($generated),
            'errors' => $errors,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Failed to generate certificates: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Update certificate.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'status' => 'required|in:issued,verified,pending',
            'remarks' => 'nullable|string',
            'course_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $certificate = Certificate::findOrFail($id);
            $certificate->update([
                'title' => $request->title,
                'issue_date' => $request->issue_date,
                'status' => $request->status,
                'remarks' => $request->remarks,
                'course_name' => $request->course_name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificate updated successfully!',
                'certificate' => $certificate
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete certificate.
     */
   /**
 * Delete certificate permanently (force delete).
 */
public function destroy($id)
{
    try {
        $certificate = Certificate::withTrashed()->findOrFail($id);
        $certificateNo = $certificate->certificate_no;
        
        // Force delete (permanently remove from database)
        $certificate->forceDelete();

        return response()->json([
            'success' => true,
            'message' => "Certificate {$certificateNo} permanently deleted successfully!"
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete certificate: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Verify certificate.
     */
    public function verify($id)
    {
        try {
            $certificate = Certificate::findOrFail($id);
            $certificate->update(['status' => 'verified']);

            return response()->json([
                'success' => true,
                'message' => 'Certificate verified successfully!',
                'certificate' => $certificate
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show certificate preview.
     */
    public function edit($id)
    {
        $certificate = Certificate::with(['enrollment.student', 'enrollment.course'])->findOrFail($id);
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($certificate);
        }
        
        return view('admin.certificate-preview', compact('certificate'));
    }

    /**
     * Get certificate stats.
     */
    public function getStats()
    {
        return response()->json([
            'total' => Certificate::count(),
            'issued_this_month' => Certificate::whereMonth('issue_date', now()->month)
                                        ->whereYear('issue_date', now()->year)
                                        ->count(),
            'pending' => Certificate::where('status', 'pending')->count(),
            'verified' => Certificate::where('status', 'verified')->count(),
            'by_course' => Certificate::select('course_name', DB::raw('count(*) as count'))
                               ->groupBy('course_name')
                               ->get(),
        ]);
    }

    // app/Http/Controllers/Admin/CertificateController.php

/**
 * Show the form for creating a new certificate.
 */
public function create()
{
    $students = Student::with(['enrollments.course'])->get();
    return view('admin.certificate', compact('students'));
}
}