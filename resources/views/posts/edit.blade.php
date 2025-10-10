@extends('layouts.admin')

@section('content')
<div class="bg-white shadow rounded-lg overflow-x-auto p-6">

    <h1 class="text-3xl font-bold mb-5">Edit Post</h1>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
    <label class="block mb-1">Title</label>
    <input type="text" name="title" class="w-full border rounded p-2"
           value="{{ old('title', $post->title) }}">
    @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block mb-1">Slug</label>
    <input type="text" name="slug" class="w-full border rounded p-2 bg-gray-100"
           value="{{ old('slug', $post->slug) }}" readonly>
    @error('slug') <p class="text-red-500">{{ $message }}</p> @enderror
</div>
        <!-- Body -->
        <div class="mb-4">
            <label class="block mb-1">Body</label>
            <textarea name="body" class="w-full border rounded p-2" rows="6">{{ old('body', $post->body) }}</textarea>
            @error('body') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <!-- Photo -->
<div class="mb-4">
    <label class="block mb-1 font-semibold">Photo</label>
    
    {{-- Preview foto (awalnya foto lama, akan update otomatis saat pilih file baru) --}}
    <div class="mb-2">
        <img id="photoPreview"
             src="{{ $post->photo 
                 ? asset('storage/' . $post->photo) 
                 : 'https://picsum.photos/600/400?random=' . ($post->id ?? rand(1,1000)) }}"
             alt="Preview Foto Post"
             class="w-full max-w-md h-64 object-cover rounded-lg shadow">
    </div>
    
    {{-- Upload foto baru --}}
    <input type="file" 
           name="photo" 
           id="photoInput" 
           class="w-full border rounded p-2"
           accept="image/*">
    
    @error('photo') 
        <p class="text-red-500 text-sm">{{ $message }}</p> 
    @enderror
</div>

        <!-- Author -->
        <div class="mb-4">
            <label class="block mb-1">Author</label>
            <select name="author_id" class="w-full border rounded p-2">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id', $post->author_id) == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            @error('author_id') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label class="block mb-1">Category</label>
            <select name="category_id" class="w-full border rounded p-2">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <!-- Submit -->
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Post</button>
    </form>
</div>
@endsection

<script>
// ✅ JavaScript untuk Live Preview Foto (update otomatis saat pilih file)
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    
    photoInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        
        if (file) {
            // Cek apakah file adalah gambar
            if (file.type.startsWith('image/')) {
                // Buat URL sementara untuk preview (tidak perlu upload dulu)
                const previewUrl = URL.createObjectURL(file);
                
                // Update src preview ke foto baru
                photoPreview.src = previewUrl;
                photoPreview.alt = 'Preview Foto Baru';
                
                // Optional: Tambah loading indicator atau class untuk smooth transition
                photoPreview.classList.add('opacity-50');
                setTimeout(() => {
                    photoPreview.classList.remove('opacity-50');
                }, 300);
                
                // Cleanup URL lama saat ganti file (hindari memory leak)
                if (photoPreview.dataset.oldSrc) {
                    URL.revokeObjectURL(photoPreview.dataset.oldSrc);
                }
                photoPreview.dataset.oldSrc = previewUrl;
            } else {
                // Jika bukan gambar, kembalikan ke preview lama
                alert('Silakan pilih file gambar saja (JPG, PNG, dll).');
                photoInput.value = ''; // Reset input
            }
        } else {
            // Jika tidak ada file (user cancel), kembalikan ke foto lama
            const originalSrc = photoPreview.dataset.originalSrc || '{{ $post->photo ? asset("storage/" . $post->photo) : "https://picsum.photos/600/400?random=" . ($post->id ?? rand(1,1000)) }}';
            photoPreview.src = originalSrc;
            photoPreview.alt = 'Preview Foto Lama';
        }
    });
});
</script>

