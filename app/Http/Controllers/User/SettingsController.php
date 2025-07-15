<?php

namespace App\Http\Controllers\User;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function viewSettings()
    {
        $settings = Setting::first();
        return view('user.settings.settings', compact('settings'));
    }

    public function postSettings(Request $request)
    {
        $validated = $request->validate([
            'long_name' => 'nullable|string|max:100',
            'short_name' => 'nullable|string|max:50',
            'support_email' => 'nullable|string|email|max:100',
            'billing_email' => 'nullable|string|email|max:100',
            'phone_number' => 'nullable|string|max:20',
            'dark_logo' => 'nullable|image|max:2048',     // max 2MB
            'light_logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:2048',
            'general_support_charge' => 'nullable|numeric',
            'call_center_charge' => 'nullable|numeric',
            'virtual_support_charge' => 'nullable|numeric',
            'citizen_desk_plan_amount' => 'nullable|numeric',
            'startup_up_amount' => 'nullable|numeric',
            'team_amount' => 'nullable|numeric',
            'enterprise_amount' => 'nullable|numeric',
            'premium_amount' => 'nullable|numeric',
        ]);

        $settings = Setting::first();

        // Handle file uploads (optional)
        if ($request->hasFile('dark_logo')) {
            $validated['dark_logo'] = $request->file('dark_logo')->store('logos', 'public');
        }
        
        if ($request->hasFile('light_logo')) {
            $validated['light_logo'] = $request->file('light_logo')->store('logos', 'public');
        }

        if ($request->hasFile('light_logo_sm')) {
            $validated['light_logo_sm'] = $request->file('light_logo_sm')->store('logos', 'public');
        }

        if ($request->hasFile('dark_logo_sm')) {
            $validated['dark_logo_sm'] = $request->file('dark_logo_sm')->store('logos', 'public');
        }

        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store('logos', 'public');
        }

        if ($settings) {
            $settings->update($validated);
            Cache::forget('site_settings');
        } else {
            Setting::create($validated);
            Cache::forget('site_settings');
        }
        return back()->with('success', 'Settings updated successfully.');

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Settings saved successfully',
        // ]);
    }

}
