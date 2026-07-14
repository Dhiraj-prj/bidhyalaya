<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Show the settings form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch the first settings record from the database
        $setting = Setting::first();

        // Return the settings view and pass the setting data
        return view('admin.setting.index', compact('setting'));
    }

    /**
     * Handle the settings form submission and update the settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'website_name' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'meta_keyword' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'website_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Fetch the first settings record from the database
        $setting = Setting::first();

        // Update the settings with the validated data
        $setting->website_name = $validated['website_name'];
        $setting->meta_title = $validated['meta_title'];
        $setting->meta_keyword = $validated['meta_keyword'];
        $setting->meta_description = $validated['meta_description'];

        // Handle the website logo upload
        if ($request->hasFile('website_logo')) {
            // Delete the old logo if it exists
            if ($setting->logo && Storage::exists('public/settings/' . $setting->logo)) {
                Storage::delete('public/settings/' . $setting->logo);
            }

            // Store the new logo and update the setting
            $logo = $request->file('website_logo')->store('settings', 'public');
            $setting->logo = $logo;
        }

        // Handle the website favicon upload
        if ($request->hasFile('website_favicon')) {
            // Delete the old favicon if it exists
            if ($setting->fevicon && Storage::exists('public/settings/' . $setting->fevicon)) {
                Storage::delete('public/settings/' . $setting->fevicon);
            }

            // Store the new favicon and update the setting
            $favicon = $request->file('website_favicon')->store('settings', 'public');
            $setting->fevicon = $favicon;
        }

            // Save the updated settings
            $setting->save();

            // Redirect back with a success message and pass the updated setting data
            return view('admin.setting.index', compact('setting'))->with('message', 'Settings updated successfully!');

    }
}
