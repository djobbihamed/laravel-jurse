<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site_title' => 'nullable|string',
            'favicon' => 'nullable|image|mimes:png|max:2048', // 2MB max and only png
        ]);

        Setting::updateOrCreate(['key' => 'site_title'], ['value' => $request->site_title]);

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('public/favicon');
            Setting::updateOrCreate(['key' => 'favicon'], ['value' => $faviconPath]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
