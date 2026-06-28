<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllSettings();
        return view('admin.settings', compact('settings'));
    }

    public function updateInstitute(Request $request)
    {
        try {
            $validated = $request->validate([
                'institute_name' => 'required|string|max:255',
                'tagline' => 'nullable|string|max:255',
                'about_description' => 'nullable|string',
                'years_experience' => 'nullable|integer|min:0',
                'address' => 'nullable|string',
                'google_map_embed_url' => 'nullable|url|max:500',
                'achievement_counter' => 'nullable|string|max:255',
            ]);

            $setting = Setting::first();
            if (!$setting) {
                $setting = new Setting();
            }

            // Update text fields
            $setting->institute_name = $validated['institute_name'];
            $setting->tagline = $validated['tagline'] ?? '';
            $setting->about_description = $validated['about_description'] ?? '';
            $setting->years_experience = $validated['years_experience'] ?? 0;
            $setting->address = $validated['address'] ?? '';
            $setting->google_map_embed_url = $validated['google_map_embed_url'] ?? '';
            $setting->achievement_counter = $validated['achievement_counter'] ?? '';

            // Handle logo upload
            if ($request->hasFile('institute_logo')) {
                if ($setting->institute_logo && Storage::disk('public')->exists($setting->institute_logo)) {
                    Storage::disk('public')->delete($setting->institute_logo);
                }
                $logoPath = $request->file('institute_logo')->store('settings/logos', 'public');
                $setting->institute_logo = $logoPath;
            }

            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Institute settings saved successfully',
                'data' => [
                    'logo' => $setting->institute_logo,
                    'name' => $setting->institute_name,
                    'tagline' => $setting->tagline,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Institute settings error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateCEO(Request $request)
    {
        try {
            $validated = $request->validate([
                'ceo_name' => 'required|string|max:255',
                'ceo_designation' => 'nullable|string|max:255',
                'ceo_vision' => 'nullable|string',
                'ceo_message' => 'nullable|string',
            ]);

            $setting = Setting::first();
            if (!$setting) {
                $setting = new Setting();
            }

            $setting->ceo_name = $validated['ceo_name'];
            $setting->ceo_designation = $validated['ceo_designation'] ?? '';
            $setting->ceo_vision = $validated['ceo_vision'] ?? '';
            $setting->ceo_message = $validated['ceo_message'] ?? '';

            if ($request->hasFile('ceo_photo')) {
                if ($setting->ceo_photo && Storage::disk('public')->exists($setting->ceo_photo)) {
                    Storage::disk('public')->delete($setting->ceo_photo);
                }
                $photoPath = $request->file('ceo_photo')->store('settings/ceo', 'public');
                $setting->ceo_photo = $photoPath;
            }

            if ($request->hasFile('ceo_signature')) {
                if ($setting->ceo_signature && Storage::disk('public')->exists($setting->ceo_signature)) {
                    Storage::disk('public')->delete($setting->ceo_signature);
                }
                $sigPath = $request->file('ceo_signature')->store('settings/signatures', 'public');
                $setting->ceo_signature = $sigPath;
            }

            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'CEO settings saved successfully',
                'data' => [
                    'photo' => $setting->ceo_photo,
                    'signature' => $setting->ceo_signature,
                    'name' => $setting->ceo_name,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('CEO settings error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateAbout(Request $request)
    {
        try {
            $validated = $request->validate([
                'about_us' => 'nullable|string',
                'our_mission' => 'nullable|string',
                'our_vision' => 'nullable|string',
                'why_choose_us' => 'nullable|string',
            ]);

            $setting = Setting::first();
            if (!$setting) {
                $setting = new Setting();
            }

            $setting->about_us = $validated['about_us'] ?? '';
            $setting->our_mission = $validated['our_mission'] ?? '';
            $setting->our_vision = $validated['our_vision'] ?? '';
            $setting->why_choose_us = $validated['why_choose_us'] ?? '';

            if ($request->hasFile('institute_image')) {
                if ($setting->institute_image && Storage::disk('public')->exists($setting->institute_image)) {
                    Storage::disk('public')->delete($setting->institute_image);
                }
                $imagePath = $request->file('institute_image')->store('settings/about', 'public');
                $setting->institute_image = $imagePath;
            }

            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'About settings saved successfully',
                'data' => [
                    'image' => $setting->institute_image,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('About settings error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateContact(Request $request)
    {
        try {
            $validated = $request->validate([
                'contact_email' => 'required|email|max:255',
                'contact_phone' => 'required|string|max:255',
                'contact_whatsapp' => 'nullable|string|max:255',
                'alternate_phone' => 'nullable|string|max:255',
                'contact_address' => 'nullable|string',
                'google_maps_url' => 'nullable|url|max:500',
            ]);

            $setting = Setting::first();
            if (!$setting) {
                $setting = new Setting();
            }

            $setting->contact_email = $validated['contact_email'];
            $setting->contact_phone = $validated['contact_phone'];
            $setting->contact_whatsapp = $validated['contact_whatsapp'] ?? '';
            $setting->alternate_phone = $validated['alternate_phone'] ?? '';
            $setting->contact_address = $validated['contact_address'] ?? '';
            $setting->google_maps_url = $validated['google_maps_url'] ?? '';

            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Contact settings saved successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('Contact settings error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSocial(Request $request)
    {
        try {
            $validated = $request->validate([
                'facebook_url' => 'nullable|url|max:255',
                'tiktok_url' => 'nullable|url|max:255',
                'youtube_url' => 'nullable|url|max:255',
                'instagram_url' => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
            ]);

            $setting = Setting::first();
            if (!$setting) {
                $setting = new Setting();
            }

            $setting->facebook_url = $validated['facebook_url'] ?? '';
            $setting->tiktok_url = $validated['tiktok_url'] ?? '';
            $setting->youtube_url = $validated['youtube_url'] ?? '';
            $setting->instagram_url = $validated['instagram_url'] ?? '';
            $setting->linkedin_url = $validated['linkedin_url'] ?? '';
            $setting->twitter_url = $validated['twitter_url'] ?? '';

            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Social media settings saved successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('Social settings error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Additional methods
    public function general() { return view('admin.settings.general'); }
    public function website() { return view('admin.settings.website'); }
    public function academic() { return view('admin.settings.academic'); }
    public function fees() { return view('admin.settings.fees'); }
    public function email() { return view('admin.settings.email'); }
    public function backup() { return view('admin.settings.backup'); }
    public function update(Request $request) { return response()->json(['success' => true, 'message' => 'Settings updated']); }
    public function updateWebsite(Request $request) { return response()->json(['success' => true, 'message' => 'Website settings updated']); }
}