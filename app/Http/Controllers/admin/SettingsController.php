<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $defaults = [
            'site_name' => config('site.name'),
            'site_full_name' => config('site.full_name'),
            'site_logo' => config('site.logo'),
            'site_phone' => config('site.phone'),
            'site_email' => config('site.email'),
            'site_address_line_1' => config('site.address_line_1'),
            'site_address_line_2' => config('site.address_line_2'),
            'site_description' => config('site.description'),
            'pagination_default' => config('site.pagination.default'),
            'pagination_search' => config('site.pagination.search'),
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
            'site_name' => 'required|string|max:255',
            'site_full_name' => 'required|string|max:255',
            'site_logo' => 'nullable|string|max:255',
            'site_phone' => 'required|string|max:50',
            'site_email' => 'required|email|max:255',
            'site_address_line_1' => 'required|string|max:255',
            'site_address_line_2' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'pagination_default' => 'required|integer|min:1|max:100',
            'pagination_search' => 'required|integer|min:1|max:100',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Site settings updated successfully.');
    }
}
