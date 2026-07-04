<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::orderBy('group')->orderBy('key')->get()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
{
    foreach ($request->input('settings', []) as $key => $value) {

        if ($request->hasFile("settings.$key")) {

            $file = $request->file("settings.$key");

            $oldSetting = SiteSetting::where('key', $key)->first();

            if ($oldSetting && $oldSetting->value) {
                Storage::disk('public')->delete($oldSetting->value);
            }

            $value = $file->store('settings', 'public');
            $type = 'image';

        } else {

            $setting = SiteSetting::where('key', $key)->first();
            $type = $setting ? $setting->type : 'text';
        }

        SiteSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type'  => $type
            ]
        );
    }

    return back()->with('success', 'Settings updated successfully.');
}
}
