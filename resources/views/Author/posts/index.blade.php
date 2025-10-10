<x-layout>
    <x-slot:title>{{ $title ?? 'Artikel Saya' }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-10">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">📚 Artikel Saya</h1>
            <p class="text-gray-500 text-sm sm:text-base">Kelola semua artikel yang telah kamu tulis di sini</p>
        </div>

        <!-- Alert -->
        <x-alert-success></x-alert-success>
        <x-alert-error></x-alert-error>

        <!-- Tombol Buat Artikel -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('author.posts.create') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-5 py-2 rounded-xl font-medium shadow hover:shadow-lg hover:scale-105 transform transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Artikel Baru
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden transition duration-300 hover:shadow-2xl">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm sm:text-base text-gray-700">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <tr class="text-gray-700 uppercase tracking-wider">
                            <th class="px-4 py-3 text-center font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Judul</th>
                            <th class="px-4 py-3 text-center font-semibold">Kategori</th>
                            <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="text-center py-3 px-4">
                                    {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900">
                                    {{ $post->title }}
                                </td>
                                <td class="text-center px-4 py-3 text-gray-600">
                                    {{ $post->category->name }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('author.posts.show', $post) }}"
                                           class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs sm:text-sm font-semibold shadow-sm transition">
                                            Show
                                        </a>
                                        <a href="{{ route('author.posts.edit', $post) }}"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs sm:text-sm font-semibold shadow-sm transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('author.posts.destroy', $post) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus artikel ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs sm:text-sm font-semibold shadow-sm transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500 italic">Belum ada artikel yang kamu tulis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $posts->links() }}
        </div>
    </div>
</x-layout>
