@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mt-5 mb-4">Manage Messages</h1>

    <x-alert-success />
    <x-alert-error />

    {{-- Desktop: Table Layout --}}
    <div class="hidden md:block">
        <div class="bg-white shadow rounded-lg">
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2 text-center">Name</th>
                            <th class="border p-2 text-center">Username</th>
                            <th class="border p-2 text-center">Email</th>
                            <th class="border p-2 text-center">Message</th>
                            <th class="border p-2 text-center">Date</th>
                            <th class="border p-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="border p-2">{{ $message->name }}</td>
                                <td class="border p-2">{{ $message->username }}</td>
                                <td class="border p-2">{{ $message->email }}</td>
                                <td class="border p-2 truncate max-w-xs">{{ Str::limit($message->body, 50) }}</td>
                                <td class="px-4 py-2 border">
                                    {{ $message->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-2 border">
                                    <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                        <a href="{{ route('admin.messages.show', $message) }}"
                                           class="bg-green-600 text-white px-4 py-1 rounded text-xs text-center no-underline hover:bg-green-700 transition-colors">
                                            Show
                                        </a>
                                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                                              onsubmit="return confirm('Yakin mau hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 text-white px-4 py-1 rounded text-xs w-full sm:w-auto hover:bg-red-700 transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">No messages</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Mobile: Card Layout --}}
    <div class="md:hidden space-y-4">
        @forelse($messages as $message)
            <div class="bg-white shadow rounded-lg p-4 border border-gray-200">
                {{-- Header: Name & Date --}}
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-lg">{{ $message->name }}</h3>
                    <span class="text-sm text-gray-500 ml-2">
                        {{ $message->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                    </span>
                </div>

                {{-- Body: Details --}}
                <div class="space-y-2 mb-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Username:</span>
                        <span class="ml-1">{{ $message->username }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Email:</span>
                        <span class="ml-1">{{ $message->email }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Message:</span>
                        <span class="ml-1 block">{{ Str::limit($message->body, 100) }}</span> {{-- Lebih panjang di mobile untuk readability --}}
                        @if(strlen($message->body) > 100)
                            <button onclick="toggleMessage({{ $message->id }})" class="text-blue-500 text-xs underline mt-1">Read more</button>
                            <div id="message-{{ $message->id }}" class="hidden mt-1 text-sm text-gray-600">{{ $message->body }}</div>
                        @endif
                    </div>
                </div>

                {{-- Footer: Actions (Stacked di mobile kecil, horizontal di sm+) --}}
                <div class="flex flex-col sm:flex-row gap-2 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.messages.show', $message) }}"
                       class="bg-green-600 text-white px-4 py-2 rounded text-sm text-center no-underline hover:bg-green-700 transition-colors flex-1 sm:flex-none">
                        Show
                    </a>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                          onsubmit="return confirm('Yakin mau hapus?')" class="flex-1 sm:flex-none">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-4 py-2 rounded text-sm w-full hover:bg-red-700 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white shadow rounded-lg p-8 text-center text-gray-500">
                No messages
            </div>
        @endforelse
    </div>

    {{-- Pagination (Visible di semua ukuran) --}}
    <div class="mt-6">
        {{ $messages->links() }}
    </div>
@endsection

{{-- Optional: JS untuk Expandable Message di Mobile (jika message panjang) --}}
@push('scripts')
<script>
function toggleMessage(id) {
    const messageDiv = document.getElementById('message-' + id);
    const button = event.target;
    
    if (messageDiv.classList.contains('hidden')) {
        messageDiv.classList.remove('hidden');
        button.textContent = 'Read less';
    } else {
        messageDiv.classList.add('hidden');
        button.textContent = 'Read more';
    }
}
</script>
@endpush