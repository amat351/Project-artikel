@extends('layouts.admin')

@section('content')

    <x-slot:title>Message Details</x-slot:title>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Message from {{ $message->name }}</h1>

        <p><strong>Name:</strong> {{ $message->name }}</p>
        <p><strong>Username:</strong> {{ $message->username }}</p>
        <p><strong>Email:</strong> {{ $message->email }}</p>
        <div class="mb-4">
            <p class="text-sm text-gray-500">Message</p>
            <div class="p-3 border rounded bg-gray-50 text-gray-700 whitespace-pre-line">
                {{ $message->body }}
            </div>
        </div>

        <div class="mb-4">
            <p class="text-sm text-gray-500">Sent at</p>
            <p class="text-gray-600">{{ $message->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
        </div>
        {{-- Replies --}}
        @if($thread->replies->count())
            <h4 class="font-semibold mb-3">Balasan:</h4>
            @foreach($thread->replies as $reply)
                <div class="mb-4 p-4 border-l-4 {{ $reply->sender_type == 'admin' ? 'border-green-500 bg-green-50' : 'border-blue-500 bg-blue-50' }} rounded">
                    <div class="flex justify-between mb-2">
                        <h4 class="font-semibold">{{ $reply->sender->name ?? 'User ' }}</h4>
                        <span class="text-gray-500">{{ $reply->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</span>
                    </div>
                    <p>{{ $reply->body }}</p>
                    @if($reply->sender_type == 'admin' && $reply->sender_id == auth()->id())
                        <form action="{{ route('admin.messages.destroy', $reply) }}" method="POST" class="mt-2 inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus balasan?')" class="text-red-500 underline">Hapus</button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif

        {{-- Form Reply (hanya untuk pesan user) --}}
        @if($message->sender_type == 'user')
            <div class="mt-6 border-t pt-4">
            <h4 class="font-semibold mb-3">Balas Pesan</h4>
            <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
                @csrf
                <textarea name="body" rows="4" class="w-full border rounded p-2" required>{{ old('body') }}</textarea>
                @error('body') <span class="text-red-500">{{ $message }}</span> @enderror
                
                <div class="flex justify-end mt-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>
        @endif

        <div class="flex gap-3">
            <a href="{{ route('admin.messages.index') }}"
               class="bg-gray-500 text-white px-3 py-2 rounded no-underline hover:bg-gray-600">
                ← Back
            </a>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
            onsubmit="return confirm('Yakin mau hapus?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white px-3 py-2 rounded">Delete</button>
            </form>

        </div>
    </div>
@endsection
