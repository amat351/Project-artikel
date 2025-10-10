@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-5 mt-5 text-center">Admin Articel</h1>

    <x-alert-success />
    <x-alert-error />

    <a href="{{ route('admin.posts.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block mb-4">
        + Add New Post
    </a>

    <!--Table tetap sama untuk desktop & mobile -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full border-collapse border border-gray-300 text-xs sm:text-sm md:text-base">
            <thead>
                <tr class="bg-gray-100 text-center">
                    <th class="border border-gray-300 px-2 sm:px-4 py-2">No</th>
                    <th class="border border-gray-300 px-2 sm:px-4 py-2">Title</th>
                    <th class="border border-gray-300 px-2 sm:px-4 py-2">Author</th>
                    <th class="border border-gray-300 px-2 sm:px-4 py-2">Category</th>
                    <th class="border border-gray-300 px-2 sm:px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-2 sm:px-4 py-2 text-center">
                            {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}
                        </td>
                        <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $post->title }}</td>
                        <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $post->author->name }}</td>
                        <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $post->category->name }}</td>
                        <td class="border border-gray-300 px-2 sm:px-4 py-2">
                           <div class="flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('admin.posts.show', $post) }}" 
                                    class="bg-green-500 text-white px-3 py-1 rounded no-underline text-sm text-center">
                                        Show
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                    class="bg-yellow-500 text-white px-3 py-1 rounded no-underline text-sm text-center">
                                        Edit
                                </a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" 
                                onsubmit="return confirm('Are you sure?')" class="inline">
                            @csrf
                            @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded text-sm w-full sm:w-auto text-center">
                                        Delete
                                    </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No posts available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection
