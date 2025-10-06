@extends('layouts.admin')

@section('content')
    <h1>Manage Posts</h1>
    

    <h1 class="text-2xl font-bold mb-4">Post List</h1>

    <x-alert-success />

    <a href="{{ route('posts.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block mb-4">
        + Add New Post
    </a>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">#</th>
                <th class="border border-gray-300 px-4 py-2">Title</th>
                <th class="border border-gray-300 px-4 py-2">Author</th>
                <th class="border border-gray-300 px-4 py-2">Category</th>
                <th class="border border-gray-300 px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $post->title }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $post->author->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $post->category->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('posts.show', $post) }}" class="bg-green-500 text-white px-3 py-1 rounded">Show</a>
                            <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
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

    <div class="mt-4">
        {{ $posts->links() }}
    </div>



@endsection


