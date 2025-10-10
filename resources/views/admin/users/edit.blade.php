@extends('layouts.admin')

@section('content')
    <x-slot:title>Edit User</x-slot:title>

    <div class="max-w-lg mx-auto bg-white p-6 mt-6 shadow rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Edit User</h1>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full border rounded p-2">
                @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Password <small class="text-gray-500">(Kosongkan jika tidak ingin ubah)</small></label>
                <input type="password" name="password" class="w-full border rounded p-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            @if(!(auth()->user()->role === 'superadmin' && auth()->id() === $user->id))
            <div class="mb-4">
                <label class="block mb-1">Role</label>
                <select name="role" class="w-full border rounded p-2">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            @endif

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Changes</button>
        </form>
    </div>
@endsection
