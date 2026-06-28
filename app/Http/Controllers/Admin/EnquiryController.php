<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnquiryController extends Controller
{
    /**
     * Display a listing of enquiries.
     */
    public function index(Request $request)
    {
        $query = Enquiry::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('interested_course', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by course
        if ($request->has('course') && !empty($request->course)) {
            $query->where('interested_course', $request->course);
        }

        // Filter by date range
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $enquiries = $query->orderBy('created_at', 'desc')->paginate(20);

        // Stats
        $stats = [
            'total' => Enquiry::count(),
            'new' => Enquiry::where('status', 'new')->count(),
            'contacted' => Enquiry::where('status', 'contacted')->count(),
            'interested' => Enquiry::where('status', 'interested')->count(),
            'converted' => Enquiry::where('status', 'converted')->count(),
            'closed' => Enquiry::where('status', 'closed')->count(),
        ];

        // Get unique courses for filter dropdown
        $courses = Enquiry::whereNotNull('interested_course')
            ->distinct()
            ->pluck('interested_course')
            ->toArray();

        return view('admin.enquiry', compact('enquiries', 'stats', 'courses'));
    }

    /**
     * Display the specified enquiry.
     */
    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        
        // Mark as read if status is new
        if ($enquiry->status === 'new') {
            $enquiry->markAsRead();
        }

        return response()->json([
            'success' => true,
            'data' => $enquiry
        ]);
    }

    /**
     * Update the specified enquiry.
     */
    public function update(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        
        $validated = $request->validate([
            'full_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'interested_course' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'status' => 'sometimes|in:new,contacted,interested,converted,closed',
            'admin_notes' => 'nullable|string',
        ]);

        $enquiry->update($validated);

        // Add timeline entry
        $timeline = $enquiry->timeline ?? [];
        $timeline[] = [
            'time' => now()->format('d M Y, h:i A'),
            'desc' => 'Enquiry updated by Admin',
            'dot' => 'purple'
        ];
        $enquiry->timeline = $timeline;
        $enquiry->save();

        return response()->json([
            'success' => true,
            'message' => 'Enquiry updated successfully',
            'data' => $enquiry
        ]);
    }

    /**
     * Remove the specified enquiry.
     */
    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enquiry deleted successfully'
        ]);
    }

    /**
     * Convert enquiry to student.
     */
    public function convertToStudent($id)
    {
        try {
            $enquiry = Enquiry::findOrFail($id);

            // Check if student already exists with this email
            $existingStudent = Student::where('email', $enquiry->email)->first();
            if ($existingStudent) {
                return response()->json([
                    'success' => false,
                    'message' => 'A student with this email already exists.',
                    'student_id' => $existingStudent->id
                ], 409);
            }

            // Create student from enquiry
            $student = Student::create([
                'name' => $enquiry->full_name,
                'email' => $enquiry->email,
                'phone' => $enquiry->phone_number,
                'source' => 'enquiry',
                'enquiry_id' => $enquiry->id,
                'status' => 'active',
            ]);

            // Update enquiry status
            $enquiry->markAsConverted();

            // Add timeline entry
            $timeline = $enquiry->timeline ?? [];
            $timeline[] = [
                'time' => now()->format('d M Y, h:i A'),
                'desc' => 'Converted to Student (ID: ' . $student->id . ')',
                'dot' => 'green'
            ];
            $enquiry->timeline = $timeline;
            $enquiry->save();

            return response()->json([
                'success' => true,
                'message' => 'Enquiry converted to student successfully!',
                'student_id' => $student->id,
                'student' => $student
            ]);

        } catch (\Exception $e) {
            Log::error('Convert to student error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error converting to student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update enquiry status.
     */
    /**
 * Update enquiry status.
 */
public function updateStatus(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,interested,converted,closed'
        ]);

        $enquiry = Enquiry::findOrFail($id);
        
        // Update status
        $enquiry->status = $validated['status'];
        
        // Update timestamps based on status
        if ($validated['status'] === 'contacted') {
            $enquiry->contacted_at = now();
        }
        
        $enquiry->save();

        // Add timeline entry
        $statusLabels = [
            'contacted' => 'Contacted by Admin',
            'interested' => 'Marked as Interested',
            'converted' => 'Converted to Student',
            'closed' => 'Enquiry Closed',
            'new' => 'Status reset to New'
        ];
        $dotColors = [
            'contacted' => 'yellow',
            'interested' => 'purple',
            'converted' => 'green',
            'closed' => 'gray',
            'new' => 'blue'
        ];
        
        $enquiry->addTimelineEntry(
            $statusLabels[$validated['status']] ?? 'Status updated to ' . $validated['status'],
            $dotColors[$validated['status']] ?? 'blue'
        );

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $enquiry
        ]);

    } catch (\Exception $e) {
        \Log::error('Status update error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error updating status: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Bulk delete enquiries.
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No enquiries selected'
                ], 400);
            }

            Enquiry::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' enquiries deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting enquiries: ' . $e->getMessage()
            ], 500);
        }
    }
}