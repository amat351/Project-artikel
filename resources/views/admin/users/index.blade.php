@extends('layouts.admin')

@section('content') 
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header Navbar -->
    <div class="top-0 left-0 mb-8 w-full bg-gray-100 text-white shadow z-50">
        <div class="max-w-xl text-center mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Brand / Title -->
                <div class="text-lg font-semibold w-full">
                    <a href="{{ url('/admin/users') }} "
                       class="px-3 py-2 rounded no-underline text-dark hover:text-primary-600 {{ request()->routeIs('users.*') ? 'bg-gray-100' : '' }}">
                         Users
                    </a>
                    <a href="{{ url('/admin/categories') }}" 
                       class="px-3 py-2 rounded no-underline text-dark hover:text-primary-600 {{ request()->routeIs('categories.*') ? 'bg-gray-100' : '' }}">
                         Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
    <h1 class="text-3xl font-bold mb-4">Manage Users</h1>

    <div class="max-w-6xl mx-auto mt-6">
        <x-alert-success />

        <!-- Filter & Search -->
        <form method="GET" action="{{ route('users.index') }}" 
              class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
            <div class="flex items-center space-x-2">
                <label for="role" class="font-medium text-gray-700">Filter by Role:</label>
                <select name="role" id="role" class="border rounded p-2">
                    <option value="">All</option>
                    @foreach($allowedRoles as $role)
                        <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Search name, username, email..." 
                       value="{{ request('search') }}" 
                       class="border rounded p-2 w-full md:w-64">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Search
                </button>
            </div>
        </form>

        <!-- Table Users (desktop) -->
        <div class="hidden md:block overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border-collapse text-sm md:text-base">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-center">User </th>
                        <th class="px-4 py-2 text-center">Username</th>
                        <th class="px-4 py-2 text-center">Email</th>
                        <th class="px-4 py-2 text-center">Role</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <!-- Foto + Nama digabung -->
                            <td class="px-4 py-2">
                                <div class="flex items-center space-x-3" x-data="{ open: false }">
                                    <img 
                                        src="{{ $user->profile_photo 
                                                ? asset('storage/' . $user->profile_photo) 
                                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff' }}" 
                                        alt="{{ $user->name }}" 
                                        class="w-10 h-10 rounded-full cursor-pointer border"
                                        @click="open = true">
                                    <span class="font-medium">{{ $user->name }}</span>

                                    <!-- Modal Hapus Foto -->
                                    <div x-show="open" x-transition 
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 relative">
                                            <div class="flex flex-col items-center">
                                                <img 
                                                    src="{{ $user->profile_photo 
                                                            ? asset('storage/' . $user->profile_photo) 
                                                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff' }}" 
                                                    alt="{{ $user->name }}" 
                                                    class="max-w-full max-h-[50vh] object-contain rounded-lg border shadow mb-4">
                                                <p class="text-lg font-semibold mb-4">{{ $user->name }}</p>

                                                @if($user->profile_photo && in_array($user->role, $allowedRoles))
                                                    <form action="{{ route('admin.users.removeAvatar', $user) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Yakin ingin menghapus foto profil user ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 mr-2">
                                                            Hapus Foto
                                                        </button>
                                                    </form>
                                                @endif

                                                <button @click="open = false" 
                                                        class="mt-2 bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">{{ $user->username }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                            <td class="px-4 py-2 text-center">
                                @if(in_array($user->role, $allowedRoles))
                                    <div class="flex justify-center gap-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('users.edit', $user) }}" 
                                           class="px-3 py-1 bg-blue-600 text-white rounded no-underline hover:bg-blue-700 text-sm">
                                            Edit
                                        </a>

                                        <!-- Delete Button (hanya jika bukan self) -->
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user) }}" 
                                                  method="POST" class="inline" 
                                                  onsubmit="return confirm('Yakin hapus akun ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-500 text-sm">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="grid gap-4 md:hidden">
            @forelse ($users as $user)
                <div class="bg-white shadow rounded-lg p-4 space-y-2">
                    <!-- Foto + Nama digabung -->
                    <div class="flex items-center space-x-3" x-data="{ open: false }">
                        <img 
                            src="{{ $user->profile_photo 
                                    ? asset('storage/' . $user->profile_photo) 
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff' }}"
                            alt="{{ $user->name }}"
                            class="w-10 h-10 rounded-full cursor-pointer border"
                            @click="open = true"
                        >
                        <span class="font-medium">{{ $user->name }}</span>

                        <!-- Modal Hapus Foto (Mobile) -->
                        <div x-show="open" x-transition 
                             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-xs p-6 relative">
                                <div class="flex flex-col items-center">
                                    <img 
                                        src="{{ $user->profile_photo 
                                                ? asset('storage/' . $user->profile_photo) 
                                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff' }}" 
                                        alt="{{ $user->name }}" 
                                        class="max-w-full max-h-[50vh] object-contain rounded-lg border shadow mb-4">
                                    <p class="text-lg font-semibold mb-4">{{ $user->name }}</p>

                                    @if($user->profile_photo && in_array($user->role, $allowedRoles))
                                        <form action="{{ route('admin.users.removeAvatar', $user) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus foto profil user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 mb-2">
                                                Hapus Foto
                                            </button>
                                        </form>
                                    @endif

                                    <button @click="open = false" 
                                            class="w-full bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div><span class="font-semibold">Username:</span> {{ $user->username }}</div>
                    <div><span class="font-semibold">Email:</span> {{ $user->email }}</div>
                    <div><span class="font-semibold">Role:</span> <span class="capitalize">{{ $user->role }}</span></div>

                    <!-- Actions di Mobile (sejajar dengan gap) -->
                    @if(in_array($user->role, $allowedRoles))
                        <div class="flex flex-row justify-end gap-2 pt-2 border-t">
                            <!-- Edit Button -->
                            <a href="{{ route('users.edit', $user) }}" 
                               class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm flex-1 text-center">
                                Edit
                            </a>

                            <!-- Delete Button (hanya jika bukan self) -->
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('users.destroy', $user) }}" 
                                      method="POST" class="inline flex-1" 
                                      onsubmit="return confirm('Yakin hapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center">No users found.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection