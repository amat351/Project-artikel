<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bg_color' => 'required|string',
            'font_size' => 'required|string',
            'dark_mode' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $user->bg_color = $request->bg_color;
        $user->font_size = $request->font_size;
        $user->dark_mode = $request->has('dark_mode');
        $user->save();

        return redirect()->route('settings.edit')->with('success', 'Settings updated successfully!');
    }
}
