<x-layout>
    <x-slot:title>{{ $title ?? 'Buat Artikel Baru' }}</x-slot:title>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Artikel Saya</h1>

    <x-alert-success></x-alert-success>
    <x-alert-error></x-alert-error>

    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('author.posts.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm sm:text-base shadow">
            + Buat Artikel Baru
        </a>
    </div>

    <!-- Responsive Table -->
    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
        <table class="min-w-full text-sm sm:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 sm:px-4 py-2 text-center">No</th>
                    <th class="px-3 sm:px-4 py-2 text-center">Title</th>
                    <th class="px-3 sm:px-4 py-2 text-center">Category</th>
                    <th class="px-3 sm:px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="border border-gray-300 px-2 sm:px-4 py-2 text-center">
                            {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-3 sm:px-4 py-2 font-medium text-gray-800">
                            {{ $post->title }}
                        </td>
                        <td class="px-3 sm:px-4 py-2 text-gray-600">
                            {{ $post->category->name }}
                        </td>
                        <td class="px-3 sm:px-4 py-2">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('author.posts.show', $post) }}"
                                   class="bg-green-500 text-white px-3 py-1 rounded-md text-xs sm:text-sm hover:bg-green-600">
                                    Show
                                </a>
                                <a href="{{ route('author.posts.edit', $post) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded-md text-xs sm:text-sm hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form action="{{ route('author.posts.destroy', $post) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded-md text-xs sm:text-sm hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">No posts available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>
</x-layout>