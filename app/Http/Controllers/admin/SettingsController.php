<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        $defaults = [
            'site_full_name' => config('site.full_name'),
            'site_logo' => config('site.logo'),
            'site_phone' => config('site.phone'),
            'site_email' => config('site.email'),
            'site_admin_email' => config('site.admin_email'),
            'site_clinic_hours' => config('site.clinic_hours'),
            'site_address_line_1' => config('site.address_line_1'),
            'site_address_line_2' => config('site.address_line_2'),
            'site_description' => config('site.description'),
            'pagination_default' => config('site.pagination.default'),
        ];

        $settings = Setting::whereIn('key', array_keys($defaults))
            ->pluck('value', 'key')
            ->all();

        $values = array_merge($defaults, $settings);

        return view('admin.settings', ['values' => $values]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_full_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:2048',
            'site_phone' => 'required|string|max:50',
            'site_email' => 'required|email|max:255',
            'site_admin_email' => 'required|email|max:255',
            'site_clinic_hours' => 'nullable|string|max:1000',
            'site_address_line_1' => 'required|string|max:255',
            'site_address_line_2' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'pagination_default' => 'required|integer|min:1|max:100',
        ]);

        if ($request->hasFile('site_logo') && $request->file('site_logo')->isValid()) {
            $image = $request->file('site_logo');
            $directory = 'images/site-logos';
            File::ensureDirectoryExists(public_path($directory), 0755, true);
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->extension();
            $image->move(public_path($directory), $filename);
            $validated['site_logo'] = '/' . $directory . '/' . $filename;
        } else {
            unset($validated['site_logo']);
        }

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Site settings updated successfully.');
    }
}
