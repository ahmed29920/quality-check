<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->only(['app_name']);

        if ($request->hasFile('app_logo')) {
            $oldLogo = Setting::where('key', 'app_logo')->value('value');

            $data['app_logo'] = $request->file('app_logo')->store('settings', 'public');

            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
        }

        if ($request->hasFile('app_icon')) {
            $oldIcon = Setting::where('key', 'app_icon')->value('value');

            $data['app_icon'] = $request->file('app_icon')->store('settings', 'public');

            if ($oldIcon && Storage::disk('public')->exists($oldIcon)) {
                Storage::disk('public')->delete($oldIcon);
            }
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        cache()->forget('settings.all');

        return back()->with('success', 'Settings updated successfully!');
    }
}
