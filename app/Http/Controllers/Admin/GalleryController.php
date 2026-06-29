<?php
// app/Http/Controllers/Admin/GalleryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $galleries = Gallery::orderBy('order', 'asc')->get();
            return response()->json([
                'success' => true,
                'data' => $galleries
            ]);
        }
        return view('admin.gallery');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('gallery', $filename, 'public');
        }

        $gallery = Gallery::create([
            'title' => $request->title,
            'image' => $imagePath,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status ?? true,
            'order' => Gallery::count() + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery image added successfully!',
            'data' => $gallery
        ]);
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('gallery', $filename, 'public');
            $gallery->image = $imagePath;
        }

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery image updated successfully!',
            'data' => $gallery
        ]);
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Delete image file
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery image deleted successfully!'
        ]);
    }

    public function reorder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $position => $id) {
            Gallery::where('id', $id)->update(['order' => $position + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Gallery reordered successfully!'
        ]);
    }

    public function toggleStatus($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->status = !$gallery->status;
        $gallery->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'data' => $gallery
        ]);
    }
}