<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() { return view('admin.settings'); }
    public function general() { return view('admin.settings', ['settingType' => 'general']); }
    public function website() { return view('admin.settings', ['settingType' => 'website']); }
    public function academic() { return view('admin.settings', ['settingType' => 'academic']); }
    public function fees() { return view('admin.settings', ['settingType' => 'fees']); }
    public function email() { return view('admin.settings', ['settingType' => 'email']); }
    public function backup() { return view('admin.settings', ['settingType' => 'backup']); }
    public function update(Request $request) { return redirect()->route('admin.settings.index')->with('success', 'Settings updated!'); }
    public function updateWebsite(Request $request) { return redirect()->route('admin.settings.website')->with('success', 'Website settings updated!'); }
}