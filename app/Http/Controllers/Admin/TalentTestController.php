<?php
// app/Http/Controllers/Admin/TalentTestController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TalentTestStudent;
use App\Models\TalentTestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TalentTestController extends Controller
{
    /**
     * Display the talent test management page.
     */
    public function index()
    {
        return view('admin.talent-test');
    }

    /**
     * Get all candidates with their stats.
     */
    public function getCandidates()
    {
        $candidates = TalentTestStudent::with('attempts')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function($candidate) {
                return [
                    'id' => $candidate->id,
                    'name' => $candidate->candidate_name,
                    'father' => $candidate->father_name,
                    'phone' => $candidate->contact_number,
                    'email' => $candidate->email,
                    'address' => $candidate->address,
                    'regDate' => $candidate->registration_date->format('Y-m-d'),
                    'attempts' => $candidate->attempts->count(),
                    'lastTest' => $candidate->last_test_date ? $candidate->last_test_date->format('Y-m-d') : '-',
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $candidates
        ]);
    }

    /**
     * Get all test attempts.
     */
    public function getAttempts()
    {
        $attempts = TalentTestAttempt::with('candidate')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function($attempt) {
                return [
                    'id' => $attempt->id,
                    'candidateId' => $attempt->candidate_id,
                    'rollNo' => $attempt->roll_number,
                    'testDate' => $attempt->test_date->format('Y-m-d'),
                    'obtainedMarks' => $attempt->obtained_marks,
                    'percentage' => $attempt->percentage,
                    'status' => $attempt->status,
                    'candidateName' => $attempt->candidate?->candidate_name,
                    'fatherName' => $attempt->candidate?->father_name,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $attempts
        ]);
    }

    /**
     * Get dashboard stats.
     */
    public function getStats()
    {
        $totalCandidates = TalentTestStudent::count();
        $totalAttempts = TalentTestAttempt::count();
        $pendingResults = TalentTestAttempt::where('status', 'pending')->count();
        $publishedResults = TalentTestAttempt::whereIn('status', ['pass', 'fail'])->count();
        
        $avgPercentage = TalentTestAttempt::whereNotNull('percentage')->avg('percentage') ?? 0;

        return response()->json([
            'success' => true,
            'data' => [
                'totalCandidates' => $totalCandidates,
                'totalAttempts' => $totalAttempts,
                'pendingResults' => $pendingResults,
                'publishedResults' => $publishedResults,
                'avgPercentage' => round($avgPercentage, 1),
            ]
        ]);
    }

    /**
     * Generate a unique roll number.
     * Format: Numeric only, starting from 1100
     * If all records are deleted, reset to 1100
     * Otherwise continue from the highest number
     */
    private function generateRollNumber()
    {
        // Check if there are ANY attempts in the database (including soft deleted)
        $totalAttempts = TalentTestAttempt::withTrashed()->count();
        
        // If no attempts exist at all, start from 1100
        if ($totalAttempts === 0) {
            return '1100';
        }
        
        // Get the highest roll number from all attempts (including soft deleted)
        $lastAttempt = TalentTestAttempt::withTrashed()
            ->orderByRaw('CAST(roll_number AS UNSIGNED) DESC')
            ->first();
        
        if ($lastAttempt && $lastAttempt->roll_number) {
            // Extract the numeric part and increment
            $lastNumber = (int) $lastAttempt->roll_number;
            $newNumber = $lastNumber + 1;
        } else {
            // Fallback to 1100 if no valid roll number found
            $newNumber = 1100;
        }
        
        // Ensure we don't have duplicates by checking if the number exists
        $attempt = 0;
        $maxAttempts = 100;
        while ($attempt < $maxAttempts) {
            $attempt++;
            $rollNumber = (string) $newNumber;
            
            $exists = TalentTestAttempt::withTrashed()
                ->where('roll_number', $rollNumber)
                ->exists();
            
            if (!$exists) {
                return $rollNumber;
            }
            $newNumber++;
        }
        
        // Fallback: use timestamp if all attempts fail
        return (string) (time() % 100000);
    }

    /**
     * Register a new candidate.
     */
    public function storeCandidate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'candidate_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $candidate = TalentTestStudent::create([
            'candidate_name' => $request->candidate_name,
            'father_name' => $request->father_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'address' => $request->address,
            'registration_date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Candidate registered successfully!',
            'data' => $candidate
        ]);
    }

    /**
     * Create a new test attempt with unique roll number.
     */
    public function storeAttempt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'candidate_id' => 'required|exists:talent_test_students,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Generate unique roll number
            $rollNumber = $this->generateRollNumber();

            $attempt = TalentTestAttempt::create([
                'candidate_id' => $request->candidate_id,
                'roll_number' => $rollNumber,
                'test_date' => now(),
                'status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Test attempt {$rollNumber} created successfully!",
                'data' => $attempt
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create attempt: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update attempt result.
     */
    public function updateResult(Request $request, $id)
    {
        $attempt = TalentTestAttempt::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'obtained_marks' => 'required|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $percentage = ($request->obtained_marks / 100) * 100;
        $status = $percentage >= 50 ? 'pass' : 'fail';

        $attempt->update([
            'obtained_marks' => $request->obtained_marks,
            'percentage' => $percentage,
            'status' => $status,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Result saved! {$attempt->roll_number} - " . strtoupper($status),
            'data' => $attempt
        ]);
    }

    /**
     * Delete a candidate (soft delete).
     */
    public function deleteCandidate($id)
    {
        $candidate = TalentTestStudent::findOrFail($id);
        
        // Get all attempt IDs before deleting
        $attemptIds = $candidate->attempts()->pluck('id')->toArray();
        
        // Soft delete attempts
        $candidate->attempts()->delete();
        
        // Soft delete candidate
        $candidate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Candidate deleted successfully!'
        ]);
    }

    /**
     * Delete an attempt (soft delete).
     */
    public function deleteAttempt($id)
    {
        $attempt = TalentTestAttempt::findOrFail($id);
        $attempt->delete();

        return response()->json([
            'success' => true,
            'message' => 'Test attempt deleted successfully!'
        ]);
    }

    /**
     * Permanently delete a candidate and all related data.
     */
    public function forceDeleteCandidate($id)
    {
        $candidate = TalentTestStudent::withTrashed()->findOrFail($id);
        
        // Get all attempt IDs
        $attemptIds = $candidate->attempts()->withTrashed()->pluck('id')->toArray();
        
        // Permanently delete attempts
        $candidate->attempts()->withTrashed()->forceDelete();
        
        // Permanently delete candidate
        $candidate->forceDelete();

        // Check if any attempts remain in the system
        $remainingAttempts = TalentTestAttempt::withTrashed()->count();
        
        $message = 'Candidate permanently deleted successfully!';
        if ($remainingAttempts === 0) {
            $message .= ' Next roll number will start from 1100.';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Permanently delete an attempt.
     */
    public function forceDeleteAttempt($id)
    {
        $attempt = TalentTestAttempt::withTrashed()->findOrFail($id);
        $attempt->forceDelete();

        // Check if any attempts remain
        $remainingAttempts = TalentTestAttempt::withTrashed()->count();
        
        $message = 'Test attempt permanently deleted successfully!';
        if ($remainingAttempts === 0) {
            $message .= ' Next roll number will start from 1100.';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Reset all roll numbers to start from 1100.
     * This will permanently delete ALL attempts and candidates.
     * Use with caution!
     */
    public function resetRollNumbers()
    {
        DB::beginTransaction();
        try {
            // Delete all candidates (which will cascade delete attempts)
            TalentTestStudent::withTrashed()->forceDelete();
            
            // Reset the auto-increment counter
            DB::statement('ALTER TABLE talent_test_attempts AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE talent_test_students AUTO_INCREMENT = 1');
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'All data deleted. Next roll number will start from 1100.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search candidates for dropdown.
     */
    public function searchCandidates(Request $request)
    {
        $query = $request->get('q', '');
        $candidates = TalentTestStudent::where('candidate_name', 'LIKE', "%{$query}%")
            ->orWhere('contact_number', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function($candidate) {
                return [
                    'id' => $candidate->id,
                    'name' => $candidate->candidate_name,
                    'father' => $candidate->father_name,
                    'phone' => $candidate->contact_number,
                    'attempts' => $candidate->attempts()->count(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $candidates
        ]);
    }

    /**
     * Get the current next roll number (for display purposes).
     */
    public function getNextRollNumber()
    {
        $totalAttempts = TalentTestAttempt::withTrashed()->count();
        
        if ($totalAttempts === 0) {
            $nextNumber = 1100;
        } else {
            $lastAttempt = TalentTestAttempt::withTrashed()
                ->orderByRaw('CAST(roll_number AS UNSIGNED) DESC')
                ->first();
            
            $nextNumber = $lastAttempt ? ((int) $lastAttempt->roll_number + 1) : 1100;
        }
        
        return response()->json([
            'success' => true,
            'next_roll_number' => (string) $nextNumber
        ]);
    }
}