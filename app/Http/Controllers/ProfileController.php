<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Validasi dengan custom pesan error
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'current_password'=> 'nullable|required_with:password|string',
            'password'        => 'nullable|string|min:6|confirmed',
            'profile_photo'   => 'nullable|image|max:2048',
            'remove_photo'    => 'nullable|in:0,1',
        ], [
            // Custom pesan validasi
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan, silakan pakai email lain.',

            'current_password.required_with' => 'Silakan masukkan password lama untuk mengubah password.',
            'password.min' => 'Password baru minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',

            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // CEK PASSWORD LAMA JIKA DIISI (bahkan jika password baru kosong)
        if (!empty($request->current_password)) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Password yang Anda masukkan salah.'
                ])->withInput();
            }
            // Jika benar, lanjut (tidak ada masalah)
        }

        // Update data basic
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password kalau diisi (sudah dicek current_password sukses di atas jika diperlukan)
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Hapus foto lama jika diminta remove
        if ($request->remove_photo == 1) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = null;
        }

        // Upload foto baru jika ada file (hanya sekali, setelah handle remove)
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada (kecuali jika baru di-set null)
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan foto baru
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        // ✅ Simpan perubahan
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}