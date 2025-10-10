@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header Navbar -->
    <div class="mb-8 w-full bg-gray-100 text-white shadow z-50">
        <div class="max-w-xl text-center mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Brand / Title -->
                <div class="text-lg font-semibold w-full">
                    <a href="{{ url('/admin/users') }}"
                       class="px-3 py-2 no-underline text-black {{ request()->routeIs('users.') }}">
                        Users
                    </a>
                    <a href="{{ url('/admin/categories') }}" 
                       class="px-3 py-2 no-underline text-black {{ request()->routeIs('categories.')}}">
                         Categories
                    </a>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-2xl font-bold mb-4">Manage Categories</h1>

    <x-alert-success />
    <x-alert-error />

    <!-- Search + Add button -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-2 mb-4"> 
        <form action="{{ route('categories.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto order-2 sm:order-1">
            <input type="text" name="search" placeholder="Search categories..."
                   value="{{ request('search') }}"
                   class="border px-3 py-2 rounded w-full sm:w-64">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto"> 
                Search
            </button>
        </form>

        <a href="{{ route('categories.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-auto max-w-xs">
            + Add Category
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Slug</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-t">
                        <td class="px-4 py-2 flex items-center gap-2">
                            <!-- Tampilkan warna -->
                            <span class="inline-block w-4 h-4 rounded-full" 
                                style="background-color: {{ $category->color ?? '#999' }}"></span>
                            {{ $category->name }}
                        </td>
                        <td class="px-4 py-2">{{ $category->slug }}</td>
                        <td class="px-4 py-2 text-center flex flex-col sm:flex-row justify-center gap-2">
                            <a href="{{ route('categories.edit', $category) }}" 
                               class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 w-full sm:w-auto"> 
                                Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" 
                                  method="POST" class="inline w-full sm:w-auto"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 w-full">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-2 text-center text-gray-500">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection