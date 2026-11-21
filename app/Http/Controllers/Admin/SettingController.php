<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    const KEYS = ['company_name', 'phone', 'whatsapp_number', 'email', 'address', 'working_hours'];

    public function edit()
    {
        $settings = collect(self::KEYS)->mapWithKeys(fn ($key) => [$key => Setting::get($key)]);

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:30',
            'whatsapp_number' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'working_hours' => 'nullable|string|max:100',
        ]);

        foreach (self::KEYS as $key) {
            Setting::set($key, $data[$key] ?? null);
        }

        return back()->with('success', 'Settings updated.');
    }
}
