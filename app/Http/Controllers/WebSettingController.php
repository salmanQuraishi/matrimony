<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebSetting;

class WebSettingController extends Controller
{
    public function index()
    {
        $setting = WebSetting::first();
        return view('websetting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'logo_dark' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        $setting = WebSetting::first();
        if (!$setting) {
            return redirect()->back()->with('error', 'Setting not found!');
        }

        if ($request->hasFile('logo')) {
            
            $oldLogoPath = public_path($setting->logo);
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }

            $logoFilename = 'setting/' . rand(99999, 9999999) . time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('setting/'), basename($logoFilename));
            $validated['logo'] = $logoFilename;
        }

        if ($request->hasFile('logo_dark')) {
            
            $oldDarkLogoPath = public_path($setting->logo_dark);
            if (file_exists($oldDarkLogoPath)) {
                unlink($oldDarkLogoPath);
            }

            $DarklogoFilename = 'setting/' . rand(99999, 9999999) . time() . '.' . $request->logo_dark->extension();
            $request->logo_dark->move(public_path('setting/'), basename($DarklogoFilename));
            $validated['logo_dark'] = $DarklogoFilename;
        }

        if ($request->hasFile('favicon')) {
            
            $oldFaviconPath = public_path($setting->favicon);
            if (file_exists($oldFaviconPath)) {
                unlink($oldFaviconPath);
            }

            $faviconFilename = 'setting/' . rand(99999, 9999999) . time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('setting/'), basename($faviconFilename));
            $validated['favicon'] = $faviconFilename;
        }


        $setting->update($validated);

        return redirect()->route('websetting.index')->with('success', 'Web Setting updated successfully!');
    }
}