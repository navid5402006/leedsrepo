<?php
// app/Http/Controllers/Admin/FeePaymentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Mail\PaymentReceiptMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FeePaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $payments = Payment::with(['enrollment.student', 'enrollment.course'])
                ->orderBy('id', 'desc')
                ->get();
            return response()->json(['data' => $payments]);
        }
        
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return view('admin.fee-payment', compact('enrollments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return view('admin.fee-payment', compact('enrollments'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enrollment_id' => 'required|exists:enrollments,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:Cash,Bank Transfer,JazzCash,EasyPaisa',
            'remarks' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $enrollment = Enrollment::with(['student', 'course'])->findOrFail($request->enrollment_id);
            $student = $enrollment->student;
            
            // Calculate total paid for this enrollment
            $totalPaid = Payment::where('enrollment_id', $request->enrollment_id)->sum('amount');
            $remaining = $enrollment->final_fee - $totalPaid;
            
            // Check if amount exceeds remaining
            if ($request->amount > $remaining) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amount exceeds remaining balance (PKR ' . number_format($remaining, 0) . ')'
                ], 422);
            }

            // Generate receipt number with retry logic
            $receiptNo = $this->generateReceiptNumber();
            
            $payment = Payment::create([
                'enrollment_id' => $request->enrollment_id,
                'receipt_no' => $receiptNo,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'remarks' => $request->remarks,
            ]);

            // Get all payments history for this enrollment
                    $paymentsHistory = Payment::where('enrollment_id', $request->enrollment_id)
            ->orderBy('payment_date', 'desc')
            ->get();

        // Get settings for dynamic footer
        $settings = \App\Models\Setting::getAllSettings();

        // Send email with settings
        if ($student->email) {
            try {
                Mail::to($student->email)->send(new \App\Mail\PaymentReceiptMail(
                    $payment,
                    $student,
                    $enrollment,
                    $paymentsHistory,
                    $settings // Pass settings to email
                ));
            } catch (\Exception $e) {
                \Log::error('Failed to send payment receipt email: ' . $e->getMessage());
            }
        }

            DB::commit();

            $emailStatus = $student->email ? ' Email sent to ' . $student->email : ' (No email on file)';

            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully! Receipt #' . $receiptNo . $emailStatus,
                'data' => $payment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to record payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique receipt number.
     */
    private function generateReceiptNumber()
    {
        $maxAttempts = 10;
        for ($i = 0; $i < $maxAttempts; $i++) {
            $year = date('Y');
            $lastPayment = Payment::orderBy('id', 'desc')->first();
            $nextId = $lastPayment ? intval(substr($lastPayment->receipt_no, 4)) + 1 : 1;
            $receiptNo = 'REC-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            
            // Check if receipt number exists
            if (!Payment::where('receipt_no', $receiptNo)->exists()) {
                return $receiptNo;
            }
        }
        // Fallback: use timestamp
        return 'REC-' . date('YmdHis');
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $payment = Payment::with(['enrollment.student', 'enrollment.course'])->findOrFail($id);
        return response()->json(['data' => $payment]);
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit($id)
    {
        $payment = Payment::with(['enrollment.student', 'enrollment.course'])->findOrFail($id);
        $enrollments = Enrollment::with(['student', 'course'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $payment,
            'enrollments' => $enrollments
        ]);
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'enrollment_id' => 'required|exists:enrollments,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:Cash,Bank Transfer,JazzCash,EasyPaisa',
            'remarks' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Check if amount exceeds remaining (excluding current payment)
            $totalPaid = Payment::where('enrollment_id', $request->enrollment_id)
                ->where('id', '!=', $id)
                ->sum('amount');
            $enrollment = Enrollment::findOrFail($request->enrollment_id);
            $remaining = $enrollment->final_fee - $totalPaid;
            
            if ($request->amount > $remaining) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amount exceeds remaining balance (PKR ' . number_format($remaining, 0) . ')'
                ], 422);
            }

            $payment->update([
                'enrollment_id' => $request->enrollment_id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'remarks' => $request->remarks,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment updated successfully!',
                'data' => $payment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * PERMANENTLY DELETE the specified payment.
     * No soft delete - completely removes from database.
     */
    public function destroy($id)
    {
        try {
            // Find the payment without soft delete scope
            $payment = Payment::findOrFail($id);
            $receiptNo = $payment->receipt_no;
            
            // Permanently delete the payment
            $payment->forceDelete();

            return response()->json([
                'success' => true,
                'message' => "Payment #{$receiptNo} permanently deleted successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * PERMANENTLY DELETE multiple payments.
     * No soft delete - completely removes from database.
     */
    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:payments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $count = Payment::whereIn('id', $request->ids)->forceDelete();

            return response()->json([
                'success' => true,
                'message' => "{$count} payment(s) permanently deleted successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payments: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get enrollment details for AJAX.
     */
    public function getEnrollmentDetails($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])
            ->findOrFail($id);
        
        $totalPaid = Payment::where('enrollment_id', $id)->sum('amount');
        $remaining = $enrollment->final_fee - $totalPaid;
        
        $payments = Payment::where('enrollment_id', $id)
            ->orderBy('payment_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'enrollment' => $enrollment,
                'total_paid' => $totalPaid,
                'remaining' => $remaining,
                'payments' => $payments
            ]
        ]);
    }

    /**
     * Get statistics.
     */
    public function stats()
    {
        $totalPayments = Payment::count();
        $totalAmount = Payment::sum('amount');
        $totalStudents = Payment::distinct('enrollment_id')->count();

        return response()->json([
            'total_payments' => $totalPayments,
            'total_amount' => $totalAmount,
            'total_students' => $totalStudents
        ]);
    }

    /**
     * Get all enrollments for a student (for multiple enrollments).
     */
    public function getStudentEnrollments($studentId)
    {
        $enrollments = Enrollment::with(['student', 'course'])
            ->where('student_id', $studentId)
            ->get()
            ->map(function($enrollment) {
                $totalPaid = Payment::where('enrollment_id', $enrollment->id)->sum('amount');
                $remaining = $enrollment->final_fee - $totalPaid;
                
                return [
                    'id' => $enrollment->id,
                    'student_name' => $enrollment->student->name,
                    'course_name' => $enrollment->course->name,
                    'final_fee' => $enrollment->final_fee,
                    'total_paid' => $totalPaid,
                    'remaining' => $remaining,
                    'enrollment_date' => $enrollment->enrollment_date,
                    'status' => $enrollment->status,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $enrollments
        ]);
    }

    /**
     * Get all payments for a student across all enrollments.
     */
    public function getStudentPayments($studentId)
    {
        $payments = Payment::with(['enrollment.student', 'enrollment.course'])
            ->whereHas('enrollment', function($query) use ($studentId) {
                $query->where('student_id', $studentId);
            })
            ->orderBy('payment_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    /**
     * Resend payment receipt email.
     */
    public function resendReceipt($id)
    {
        try {
            $payment = Payment::with(['enrollment.student', 'enrollment.course'])->findOrFail($id);
            $student = $payment->enrollment->student;
            $enrollment = $payment->enrollment;
            
            // Get all payments history
            $paymentsHistory = Payment::where('enrollment_id', $enrollment->id)
                ->orderBy('payment_date', 'desc')
                ->get();

            if (!$student->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student has no email address on file.'
                ], 422);
            }

            Mail::to($student->email)->send(new PaymentReceiptMail(
                $payment,
                $student,
                $enrollment,
                $paymentsHistory
            ));

            return response()->json([
                'success' => true,
                'message' => 'Receipt email resent successfully to ' . $student->email
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend receipt: ' . $e->getMessage()
            ], 500);
        }
    }
}