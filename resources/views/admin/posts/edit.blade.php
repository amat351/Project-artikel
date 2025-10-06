<x-layout>
    <x-slot:title>Edit Post</x-slot:title>

    <h1 class="text-2xl font-bold mb-4">Edit Post</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2" value="{{ old('title', $post->title) }}">
            @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Slug</label>
            <input type="text" name="slug" class="w-full border rounded p-2" value="{{ old('slug', $post->slug) }}">
            @error('slug') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Body</label>
            <textarea name="body" class="w-full border rounded p-2" rows="6">{{ old('body', $post->body) }}</textarea>
            @error('body') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Photo</label>
            <input type="text" name="photo" class="w-full border rounded p-2" value="{{ old('photo', $post->photo) }}">
            @error('photo') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Author</label>
            <select name="author_id" class="w-full border rounded p-2">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id', $post->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
            @error('author_id') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Category</label>
            <select name="category_id" class="w-full border rounded p-2">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Post</button>
    </form>
</x-layout>
