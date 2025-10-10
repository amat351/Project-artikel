@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Add Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" id="name"
                   class="w-full border rounded p-2"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Slug</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" 
                class="w-full border rounded p-2 bg-gray-100" readonly>
        </div>

        <div class="mb-4">
    <label class="block mb-1">Color</label>
    <div class="flex items-center gap-3">
        <input type="color" name="color" id="colorPicker"
               class="w-16 h-10 cursor-pointer border rounded"
               value="{{ old('color', '#999999') }}">
    </div>
</div>
<div>
        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Category
        </button>
    </div>
    </form>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.getElementById("name");
    const slugInput = document.getElementById("slug");

    function slugify(text) {
        return text.toString().toLowerCase()
            .trim()
            .replace(/\s+/g, '-')      // ganti spasi dengan -
            .replace(/[^\w\-]+/g, '')  // hapus karakter non-word
            .replace(/\-\-+/g, '-');   // hapus multiple -
    }

    nameInput.addEventListener("input", function () {
        slugInput.value = slugify(nameInput.value);
    });
});
</script>
@endsection
