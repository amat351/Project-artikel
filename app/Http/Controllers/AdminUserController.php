<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        $authUser  = auth()->user();
        $allowedRoles = [];

        // Tentukan role yang boleh dilihat berdasarkan role auth user
        if ($authUser ->role === 'superadmin') {
            // Superadmin bisa lihat semua
            $allowedRoles = ['user', 'author', 'admin', 'superadmin'];
        } elseif ($authUser ->role === 'admin') {
            // Admin biasa hanya lihat user dan author
            $allowedRoles = ['user', 'author'];
        } else {
            // Role lain tidak boleh akses
            abort(403, 'Unauthorized');
        }

        $query->whereIn('role', $allowedRoles);

        // Filter berdasarkan role (hanya role yang allowed)
        if ($request->filled('role') && in_array($request->role, $allowedRoles)) {
            $query->where('role', $request->role);
        }

        // Search name / username / email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('username', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'allowedRoles'));
    }

    public function edit(User $user)
    {
        $authUser  = auth()->user();
        $allowedEditRoles = [];

        // Tentukan role yang boleh diedit
        if ($authUser ->role === 'superadmin') {
            $allowedEditRoles = ['user', 'author', 'admin', 'superadmin'];
        } elseif ($authUser ->role === 'admin') {
            $allowedEditRoles = ['user', 'author'];
        } else {
            abort(403, 'Unauthorized');
        }

        // Cek apakah user ini boleh diedit
        if (!in_array($user->role, $allowedEditRoles)) {
            abort(403, 'Unauthorized to edit this user.');
        }

        // Untuk superadmin edit dirinya sendiri, role disabled
        $isSelfEdit = ($authUser ->id === $user->id);
        $canChangeRole = ($authUser ->role === 'superadmin' && !$isSelfEdit);

        return view('admin.users.edit', compact('user', 'isSelfEdit', 'canChangeRole'));
    }

    public function update(Request $request, User $user)
    {
        $authUser  = auth()->user();
        $allowedEditRoles = [];

        // Tentukan role yang boleh diedit (sama seperti edit)
        if ($authUser ->role === 'superadmin') {
            $allowedEditRoles = ['user', 'author', 'admin', 'superadmin'];
        } elseif ($authUser ->role === 'admin') {
            $allowedEditRoles = ['user', 'author'];
        } else {
            abort(403, 'Unauthorized');
        }

        // Cek apakah user ini boleh diedit
        if (!in_array($user->role, $allowedEditRoles)) {
            abort(403, 'Unauthorized to edit this user.');
        }

        // Validasi
        $rules = [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ];

        // Role validation: Hanya jika boleh ubah role
        $isSelfEdit = ($authUser ->id === $user->id);
        if ($authUser ->role === 'superadmin' && !$isSelfEdit) {
            $rules['role'] = 'required|in:user,author,admin,superadmin';
        } elseif ($authUser ->role === 'admin') {
            $rules['role'] = 'required|in:user,author';
        }

        $validated = $request->validate($rules);

        // Untuk superadmin edit dirinya sendiri, jangan ubah role
        if ($isSelfEdit && $authUser ->role === 'superadmin') {
            $validated['role'] = 'superadmin'; // Paksa tetap superadmin
        }

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User  updated successfully!');
    }

    public function removeAvatar(User $user)
    {
        $authUser  = auth()->user();
        $allowedRemoveRoles = [];

        // Tentukan role yang boleh dihapus avatar-nya
        if ($authUser ->role === 'superadmin') {
            $allowedRemoveRoles = ['user', 'author', 'admin', 'superadmin'];
        } elseif ($authUser ->role === 'admin') {
            $allowedRemoveRoles = ['user', 'author'];
        } else {
            abort(403, 'Unauthorized');
        }

        // Cek apakah user ini boleh dihapus avatar-nya
        if (!in_array($user->role, $allowedRemoveRoles)) {
            abort(403, 'Unauthorized to remove avatar for this user.');
        }

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->profile_photo = null;
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Foto profil user berhasil dihapus!');
    }

    public function destroy(User $user)
    {
        $authUser  = auth()->user();
        $allowedDeleteRoles = [];

        // Tentukan role yang boleh dihapus
        if ($authUser ->role === 'superadmin') {
            $allowedDeleteRoles = ['user', 'author', 'admin', 'superadmin'];
        } elseif ($authUser ->role === 'admin') {
            $allowedDeleteRoles = ['user', 'author'];
        } else {
            abort(403, 'Unauthorized');
        }

        // Cek apakah user ini boleh dihapus
        if (!in_array($user->role, $allowedDeleteRoles)) {
            abort(403, 'Unauthorized to delete this user.');
        }

        // Superadmin tidak bisa hapus dirinya sendiri
        if ($authUser ->role === 'superadmin' && auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        // Admin tidak bisa hapus dirinya sendiri (umum)
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User  deleted successfully!');
    }
}