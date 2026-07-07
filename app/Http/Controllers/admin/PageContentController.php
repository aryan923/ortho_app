<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    private array $pages = [
        'home' => 'Home Page',
        'about' => 'About Page',
        'services' => 'Services Page',
        'doctors' => 'Doctors Page',
        'blog' => 'Blog Page',
        'book_appointment' => 'Book Appointment Page',
    ];

    private array $fields = [
        'hero_label' => 'Hero label',
        'hero_title' => 'Hero title',
        'hero_subtitle' => 'Hero subtitle',
        'hero_cta_text' => 'CTA button text',
        'hero_cta_link' => 'CTA button link',
        'hero_image' => 'Hero image URL',
    ];

    public function index()
    {
        return redirect()->route('admin.cms.edit', ['page' => array_key_first($this->pages)]);
    }

    public function edit(string $pageKey)
    {
        if (! isset($this->pages[$pageKey])) {
            abort(404);
        }

        $defaults = [];

        foreach (array_keys($this->fields) as $fieldKey) {
            $defaults["page_{$pageKey}_{$fieldKey}"] = config("page.{$pageKey}.{$fieldKey}");
        }

        $settings = Setting::whereIn('key', array_keys($defaults))
            ->pluck('value', 'key')
            ->all();

        $values = array_merge($defaults, $settings);

        return view('admin.cms.' . $pageKey, [
            'pages' => $this->pages,
            'fields' => $this->fields,
            'currentPageKey' => $pageKey,
            'currentPageLabel' => $this->pages[$pageKey],
            'values' => $values,
        ]);
    }

    public function update(Request $request, string $pageKey)
    {
        if (! isset($this->pages[$pageKey])) {
            abort(404);
        }

        $rules = [];

        foreach ($this->fields as $fieldKey => $fieldLabel) {
            if ($fieldKey === 'hero_subtitle') {
                $rules["page_{$pageKey}_{$fieldKey}"] = 'nullable|string|max:1000';
            } else {
                $rules["page_{$pageKey}_{$fieldKey}"] = 'nullable|string|max:255';
            }
        }

        $validated = $request->validate($rules);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Page content updated successfully.');
    }
}
