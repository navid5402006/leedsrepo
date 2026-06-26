<?php
// app/Http/Controllers/Admin/StudentCardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentCard;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentCardController extends Controller
{
    /**
     * Display a listing of student cards.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cards = StudentCard::with('student')->orderBy('id', 'desc')->get();
            return response()->json(['data' => $cards]);
        }
        
        $students = Student::all();
        return view('admin.student-card', compact('students'));
    }

    /**
     * Show the form for creating a new student card.
     */
    public function create()
    {
        $students = Student::all();
        return view('admin.student-card', compact('students'));
    }

    /**
     * Store a newly created student card in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id|unique:student_cards,student_id',
            'issue_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $student = Student::findOrFail($request->student_id);

        // Get the next available card number
        $cardNo = $this->getNextCardNumber();
        $regNo = $this->getNextRegNumber();

        $card = StudentCard::create([
            'student_id' => $request->student_id,
            'card_no' => $cardNo,
            'reg_no' => $regNo,
            'issue_date' => $request->issue_date,
            'status' => 'issued',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student card issued successfully!',
            'data' => $card
        ]);
    }

    /**
     * Display the specified student card.
     */
    public function show($id)
    {
        $card = StudentCard::with('student')->findOrFail($id);
        return response()->json(['data' => $card]);
    }

    /**
     * Show the form for editing the specified student card.
     */
    public function edit($id)
    {
        $card = StudentCard::with('student')->findOrFail($id);
        $students = Student::all();
        
        return response()->json([
            'success' => true,
            'data' => $card,
            'students' => $students
        ]);
    }

    /**
     * Update the specified student card in storage.
     */
    public function update(Request $request, $id)
    {
        $card = StudentCard::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id|unique:student_cards,student_id,' . $id,
            'issue_date' => 'required|date',
            'status' => 'required|in:issued,pending,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $card->update([
            'student_id' => $request->student_id,
            'issue_date' => $request->issue_date,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student card updated successfully!',
            'data' => $card
        ]);
    }

    /**
     * Remove the specified student card from storage.
     */
    public function destroy($id)
    {
        $card = StudentCard::findOrFail($id);
        $card->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student card deleted successfully!'
        ]);
    }

    /**
     * Get the next available card number.
     */
    private function getNextCardNumber()
    {
        // Get the highest card number from the database
        $lastCard = StudentCard::withTrashed()
            ->where('card_no', 'LIKE', 'CARD-%')
            ->orderByRaw('CAST(SUBSTRING(card_no, 6) AS UNSIGNED) DESC')
            ->first();
        
        if ($lastCard) {
            $lastNumber = intval(substr($lastCard->card_no, 5));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        return 'CARD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the next available registration number.
     */
    private function getNextRegNumber()
    {
        // Get the highest registration number from the database
        $lastCard = StudentCard::withTrashed()
            ->where('reg_no', 'LIKE', 'REG-%')
            ->orderByRaw('CAST(SUBSTRING(reg_no, 5) AS UNSIGNED) DESC')
            ->first();
        
        if ($lastCard) {
            $lastNumber = intval(substr($lastCard->reg_no, 4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        return 'REG-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Issue cards for selected students.
     */
    public function issueCards(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $issued = 0;
        $skipped = 0;
        $errors = [];

        // Get the next available numbers ONCE before the loop
        // Get highest card number
        $lastCard = StudentCard::withTrashed()
            ->where('card_no', 'LIKE', 'CARD-%')
            ->orderByRaw('CAST(SUBSTRING(card_no, 6) AS UNSIGNED) DESC')
            ->first();
        
        $nextCardNumber = $lastCard ? intval(substr($lastCard->card_no, 5)) + 1 : 1;
        
        // Get highest registration number
        $lastReg = StudentCard::withTrashed()
            ->where('reg_no', 'LIKE', 'REG-%')
            ->orderByRaw('CAST(SUBSTRING(reg_no, 5) AS UNSIGNED) DESC')
            ->first();
        
        $nextRegNumber = $lastReg ? intval(substr($lastReg->reg_no, 4)) + 1 : 1;

        foreach ($request->student_ids as $studentId) {
            // Check if card already exists
            if (StudentCard::where('student_id', $studentId)->exists()) {
                $skipped++;
                continue;
            }

            try {
                $cardNo = 'CARD-' . str_pad($nextCardNumber, 4, '0', STR_PAD_LEFT);
                $regNo = 'REG-' . str_pad($nextRegNumber, 4, '0', STR_PAD_LEFT);

                StudentCard::create([
                    'student_id' => $studentId,
                    'card_no' => $cardNo,
                    'reg_no' => $regNo,
                    'issue_date' => now(),
                    'status' => 'issued',
                ]);
                
                $issued++;
                $nextCardNumber++;
                $nextRegNumber++;
            } catch (\Exception $e) {
                $errors[] = 'Error for student ID ' . $studentId . ': ' . $e->getMessage();
                // If there's an error, try to get the next available number again
                $lastCard = StudentCard::withTrashed()
                    ->where('card_no', 'LIKE', 'CARD-%')
                    ->orderByRaw('CAST(SUBSTRING(card_no, 6) AS UNSIGNED) DESC')
                    ->first();
                $nextCardNumber = $lastCard ? intval(substr($lastCard->card_no, 5)) + 1 : 1;
            }
        }

        $message = $issued . ' card(s) issued successfully!';
        if ($skipped > 0) {
            $message .= ' ' . $skipped . ' student(s) already had cards.';
        }
        if (!empty($errors)) {
            $message .= ' Errors: ' . implode(' ', $errors);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'issued' => $issued,
            'skipped' => $skipped,
            'errors' => $errors
        ]);
    }

    /**
     * Get statistics.
     */
    public function stats()
    {
        $total = StudentCard::count();
        $issued = StudentCard::where('status', 'issued')->count();
        $pending = StudentCard::where('status', 'pending')->count();
        $cancelled = StudentCard::where('status', 'cancelled')->count();

        return response()->json([
            'total' => $total,
            'issued' => $issued,
            'pending' => $pending,
            'cancelled' => $cancelled
        ]);
    }
}