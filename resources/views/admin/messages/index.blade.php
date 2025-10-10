@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-10 px-4 sm:px-6 lg:px-8 animate-fadeInUp">

    <!-- Title -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight animate-slideInLeft">
            📩 Kelola Pesan
        </h1>
        <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded animate-growLine"></div>
    </div>

    <x-alert-success />
    <x-alert-error />

    {{-- Desktop: Table Layout --}}
    <div class="hidden md:block animate-fadeInUp delay-150">
        <div class="bg-white/90 backdrop-blur-sm shadow-lg rounded-xl border border-gray-200 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-gray-700">
                    <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white uppercase text-xs">
                        <tr>
                            <th class="p-3 text-center">Name</th>
                            <th class="p-3 text-center">Username</th>
                            <th class="p-3 text-center">Email</th>
                            <th class="p-3 text-center">Message</th>
                            <th class="p-3 text-center">Date</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr class="hover:bg-blue-50/70 transition-all duration-300 ease-in-out">
                                <td class="border-t p-3 text-center font-medium">{{ $message->name }}</td>
                                <td class="border-t p-3 text-center">{{ $message->username }}</td>
                                <td class="border-t p-3 text-center text-blue-600">{{ $message->email }}</td>
                                <td class="border-t p-3 text-center truncate max-w-xs">{{ Str::limit($message->body, 50) }}</td>
                                <td class="border-t p-3 text-center">
                                    {{ $message->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                </td>
                                <td class="border-t p-3 text-center">
                                    @if($message->is_read)
                                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-semibold animate-pulse">Read</span>
                                    @else
                                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold animate-pulse">Unread</span>
                                    @endif
                                </td>
                                <td class="border-t p-3 text-center space-x-2">
                                    <a href="{{ route('admin.messages.show', $message) }}"
                                       class="inline-block bg-green-600 text-white px-4 py-1 rounded-lg text-xs font-semibold hover:bg-green-700 hover:scale-105 transform transition-all duration-300 shadow-md">
                                       Show
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Yakin mau hapus?')"
                                                class="bg-red-600 text-white px-4 py-1 rounded-lg text-xs font-semibold hover:bg-red-700 hover:scale-105 transform transition-all duration-300 shadow-md">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500 animate-fadeInSlow">No messages</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Mobile: Card Layout --}}
    <div class="md:hidden space-y-5 mt-6 animate-fadeInUp delay-300">
        @forelse($messages as $message)
            <div class="bg-white/90 backdrop-blur-sm shadow-md rounded-xl p-4 border border-gray-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-lg text-gray-800">{{ $message->name }}</h3>
                    <span class="text-sm text-gray-500">
                        {{ $message->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                    </span>
                </div>

                <div class="space-y-2 text-sm text-gray-700">
                    <div><span class="font-medium">Username:</span> {{ $message->username }}</div>
                    <div><span class="font-medium">Email:</span> {{ $message->email }}</div>
                    <div>
                        <span class="font-medium">Status:</span>
                        @if($message->is_read)
                            <span class="text-green-600 font-semibold ml-1">Read</span>
                        @else
                            <span class="text-red-600 font-semibold ml-1">Unread</span>
                        @endif
                    </div>
                    <div>
                        <span class="font-medium">Message:</span>
                        <span class="block mt-1">{{ Str::limit($message->body, 100) }}</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 pt-4 mt-3 border-t border-gray-100">
                    <a href="{{ route('admin.messages.show', $message) }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-md text-sm text-center font-semibold hover:bg-green-700 hover:scale-105 transform transition-all duration-300 shadow-md">
                        Show
                    </a>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                          onsubmit="return confirm('Yakin mau hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-4 py-2 rounded-md text-sm w-full font-semibold hover:bg-red-700 hover:scale-105 transform transition-all duration-300 shadow-md">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white/80 backdrop-blur-md shadow-md rounded-lg p-8 text-center text-gray-500 animate-fadeInSlow">
                No messages
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8 animate-fadeInUp delay-500">
        {{ $messages->links() }}
    </div>
</div>
@endsection
