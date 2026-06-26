<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index() { return view('admin.enquiry'); }
    public function create() { return view('admin.enquiry'); }
    public function store(Request $request) { return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry created!'); }
    public function show($id) { return view('admin.enquiry', ['enquiryId' => $id]); }
    public function edit($id) { return view('admin.enquiry', ['editId' => $id]); }
    public function update(Request $request, $id) { return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry updated!'); }
    public function destroy($id) { return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted!'); }
    public function convertToStudent($id) { return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry converted to student!'); }
    public function updateStatus($id) { return redirect()->route('admin.enquiries.index')->with('success', 'Status updated!'); }
}