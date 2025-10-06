<x-layout>
    <x-slot:title>Create New Post</x-slot:title>

    <h1 class="text-2xl font-bold mb-4">Add New Post</h1>

    <form action="{{ route('author.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Title</label>
            <input type="text" id="title" name="title" 
                class="w-full border rounded p-2" 
                value="{{ old('title') }}">
            @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Slug</label>
            <input type="text" id="slug" name="slug" 
                class="w-full border rounded p-2 bg-gray-100" 
                value="{{ old('slug') }}" readonly>
            @error('slug') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Body</label>
            <textarea name="body" class="w-full border rounded p-2" rows="6">{{ old('body') }}</textarea>
            @error('body') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <!-- Foto Artikel -->
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Foto Artikel</label>
            <input type="file" name="photo" id="photo" accept="image/*" 
                class="border p-2 w-full mb-3 required">

            <!-- Preview -->
            <div class="mt-3">
                <img id="photo-preview" 
                    class="max-h-64 rounded shadow hidden" 
                    alt="Preview Foto Artikel">
            </div>

            @error('photo') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const titleInput = document.getElementById("title");
        const slugInput = document.getElementById("slug");

        function slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')      // ganti spasi dengan -
                .replace(/[^\w\-]+/g, '')  // hapus karakter non-word
                .replace(/\-\-+/g, '-');   // hapus multiple -
        }

        titleInput.addEventListener("input", function () {
            const value = titleInput.value;
            slugInput.value = value ? slugify(value) : "";
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const photoInput = document.getElementById("photo");
        const previewImg = document.getElementById("photo-preview");

        photoInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove("hidden");
                };

                reader.readAsDataURL(file);
            } else {
                previewImg.src = "";
                previewImg.classList.add("hidden");
            }
        });
    });
</script>

