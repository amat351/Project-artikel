<x-layout>
    <x-slot:title>Create New Post</x-slot:title>

    <h1 class="text-2xl font-bold mb-4">Add New Post</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2" value="{{ old('title') }}">
            @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Slug</label>
            <input type="text" name="slug" class="w-full border rounded p-2" value="{{ old('slug') }}">
            @error('slug') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Body</label>
            <textarea name="body" class="w-full border rounded p-2" rows="6">{{ old('body') }}</textarea>
            @error('body') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Photo</label>
            <input type="url" name="photo" class="w-full border rounded p-2" value="{{ old('photo') }}">
            @error('photo') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Author</label>
            <select name="author_id" class="w-full border rounded p-2">
                <option value="">-- Select Author --</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
            @error('author_id') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Category</label>
            <select name="category_id" class="w-full border rounded p-2">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Post</button>
    </form>
</x-layout>
