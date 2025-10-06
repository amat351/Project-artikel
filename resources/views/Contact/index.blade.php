<x-layout>
    <x-slot:title>Contact Admin</x-slot:title>

    <div class="max-w-5xl mx-auto shadow rounded-xl p-6 mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Info Admin (Kolom Kiri) -->
            <div class="p-6 rounded-lg shadow-inner">
                <h2 class="text-xl font-semibold mb-4">Admin Information</h2>
                <ul class="space-y-3">
                    <li>
                        <span class="font-medium">Name:</span> {{ $admin->name ?? 'muhammadekanur@gmail.com' }}
                    </li>
                    <li>
                        <span class="font-medium">Phone:</span> {{ $admin->phone ?? '+62 853 1487 8024' }}
                    </li>
                    <li>
                        <span class="font-medium">Email:</span>
                        <a href="mailto:{{ $admin->email ?? 'muhammadekanur@gmail.com' }}" class="text-blue-500 hover:underline">
                            {{ $admin->email ?? 'muhammadekanur@gmail.com' }}
                        </a>
                    </li>
                    <li>
                        <span class="font-medium">Social:</span>
                        <div class="flex space-x-3 mt-1">
                            <a href="https://facebook.com/admin" target="_blank" class="text-blue-600 hover:underline">Facebook</a>
                            <a href="https://twitter.com/admin" target="_blank" class="text-sky-500 hover:underline">Twitter</a>
                            <a href="https://instagram.com/AMAT_KPT_2008" target="_blank" class="text-pink-500 hover:underline">Instagram</a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Form Contact (Kolom Kanan) -->
            <div>
                <x-alert-success />
                <x-alert-error />
            <div>
            </div>
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Message</label>
                        <textarea name="body" 
                                  class="w-full border rounded p-2" 
                                  rows="5" 
                                  placeholder="Ketik pesan Anda...">{{ old('body') }}</textarea>
                        @error('body') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors w-full md:w-auto">
                        Send Message
                    </button>
                </form>
            </div>
        </div>  

        {{--  Riwayat Pesan (Di Bawah Grid/Form, dengan Icon untuk Buka Modal) --}}
        @if(Auth::check())
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">Riwayat Pesan Anda</h2>
                <div class="space-y-4">
                    @forelse($threads as $thread)
                        <div class="bg-white   'bg-gray-800 border-gray-600' : 'shadow-md border' }} rounded-lg p-4 border transition-colors">
                            {{-- Header: Pesan User + Icon untuk Buka Modal --}}
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h3 class="font-semibold   'text-gray-200' : 'text-gray-800' }}">
                                        {{ $thread->name ?? 'Pesan dari ' . $thread->email }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-1">{{ $thread->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                                    <p class="text-gray-700   'text-gray-300' : '' }}">
                                        {{ \Illuminate\Support\Str::limit($thread->body, 100) }}
                                    </p>
                                </div>
                                
                                {{-- ✅ Icon Eye untuk Buka Modal --}}
                            <div class="flex space-x-2">
                                <!-- Eye Icon -->
                                <button onclick="openModal({{ $thread->id }})" 
                                        class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-blue-100 hover:text-blue-600 transition-colors"
                                        title="Lihat Balasan">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="sr-only">Lihat Balasan</span>
                                </button>

                                <!-- Trash Icon -->
                                <form action="{{ route('user.messages.destroy', $thread->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-full bg-gray-100 text-red-500 hover:bg-red-100 hover:text-red-700 transition-colors" title="Hapus Pesan">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span class="sr-only">Hapus Pesan</span>
                                    </button>
                                </form>
                            </div>
                            </div>

                            {{-- Info Replies (Preview Singkat) --}}
                            @if($thread->replies->count() > 0)
                                <div class="flex items-center justify-between pt-2 border-t   'border-gray-600' : 'border-gray-200' }}">
                                    <span class="text-green-600 font-medium text-sm">Ada {{ $thread->replies->count() }} balasan dari admin</span>
                                    <span class="text-xs text-gray-500">
                                        {{ $thread->replies->last()->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-500 text-sm">Belum ada balasan</span>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p>Tidak ada riwayat pesan. Mulai dengan mengirim pesan di atas!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{--  Modal HTML (Global, Hidden Awal) --}}
            <div id="repliesModal" class="fixed inset-0 z-50 hidden overflow-y-auto backdrop-blur-sm transition-opacity duration-300">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="rounded-lg shadow-xl max-w-md w-full max-h-[80vh] overflow-y-auto transform transition-all duration-300 scale-100">
                        {{-- Header Modal --}}
                        <div class="flex justify-between items-center p-4 border-b   'border-gray-600' : 'border-gray-200' }}">
                            <h3 id="modalTitle" class="font-semibold text-lg">Detail Pesan</h3>
                            <button onclick="closeModal()" 
                                    class="text-gray-500 hover:text-gray-700   'hover:text-gray-300' : '' }} 
                                        text-2xl font-bold rounded-full p-1 hover:bg-gray-200 
                                          'hover:bg-gray-700' : '' }} transition-colors">
                                &times;
                            </button>
                        </div>

                        {{-- Body Modal --}}
                        <div id="modalBody" class="p-4 space-y-4">
                            {{-- Konten akan di-populate via JS --}}
                        </div>

                        {{-- Footer Modal --}}
                        <div class="flex justify-end p-4 border-t   'border-gray-600' : 'border-gray-200' }}">
                            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-8 text-center   'text-gray-400' : 'text-gray-500' }}">
                <p>Silakan login untuk melihat riwayat pesan.</p>
            </div>
        @endif
    </div> 

    {{-- JS untuk Modal (Open/Close & Populate Content) --}}
    <script>
        // Data threads disimpan di JS (dari Blade, untuk akses mudah)
        const threadsData = @json($threads ?? []);  // Fallback empty array jika $threads null

        function openModal(threadId) {
            const modal = document.getElementById('repliesModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');
            
            // Cari thread berdasarkan ID
            const thread = threadsData.find(t => t.id === threadId);
            if (!thread) {
                alert('Data pesan tidak ditemukan.');  // Fallback error
                return;
            }

            // Update Title
            modalTitle.textContent = thread.name || `Pesan dari ${thread.email}`;

            // Populate Body: Pesan User + Replies
            let bodyHtml = `
            <div class="bg-blue-50   'bg-blue-900/20 border-blue-500' : 'bg-blue-50 border-blue-200' }} p-3 rounded mb-4 border">
                <div class="flex justify-between mb-1">
                    <span class="font-medium">Pesan Anda:</span>
                    <span class="text-sm text-gray-500">${new Date(thread.created_at).toLocaleString('id-ID', { 
                        day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', 
                        timeZone: 'Asia/Jakarta' 
                    })}</span>
                </div>
                <p class="text-sm whitespace-pre-wrap">${thread.body}</p> 
            </div>
            `;

            if (thread.replies && thread.replies.length > 0) {
                bodyHtml += `
                    <h4 class="font-medium mb-2   'text-gray-200' : 'text-gray-800' }}">Balasan dari Admin:</h4>
                `;
                thread.replies.forEach(reply => {
                    const senderName = reply.sender ? reply.sender.name : 'Admin';
                    const replyDate = new Date(reply.created_at).toLocaleString('id-ID', { 
                        day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', 
                        timeZone: 'Asia/Jakarta' 
                    });
                    bodyHtml += `
                        <div class="p-3 border-l-4   'border-green-400 bg-gray-700' : 'border-green-500 bg-green-50' }} rounded-r mb-2">
                            <div class="flex justify-between mb-1">
                                <span class="font-medium text-sm">${senderName}</span>
                                <span class="text-xs text-gray-500">${replyDate}</span>
                            </div>
                            <p class="text-sm   'text-gray-300' : 'text-gray-700' }} whitespace-pre-wrap">${reply.body}</p>
                        </div>
                    `;
                });
            } else {
                bodyHtml += `
                    <div class="text-center py-4   'text-gray-400 bg-gray-700' : 'text-gray-500 bg-gray-100' }} rounded p-3">
                        <p class="text-sm">Belum ada balasan dari admin. Pesan Anda sedang diproses.</p>
                    </div>
                `;
            }

            modalBody.innerHTML = bodyHtml;
            
            // Show modal dengan animasi
            modal.classList.remove('hidden');
            modal.querySelector('.scale-100').style.transform = 'scale(0.95)';  // Mulai kecil
            setTimeout(() => {
                modal.querySelector('.scale-100').style.transform = 'scale(1)';
            }, 10);
            document.body.style.overflow = 'hidden';  // Prevent scroll body
        }

        function closeModal() {
            const modal = document.getElementById('repliesModal');
            const modalContent = modal.querySelector('.scale-100');
            
            // Animasi keluar
            modalContent.style.transform = 'scale(0.95)';
            setTimeout(() => {
                modal.classList.add('hidden');
                modalContent.style.transform = 'scale(1)';  // Reset
                document.body.style.overflow = '';  // Restore scroll
            }, 150);
        }

        // Event Listeners: Tutup modal saat klik outside atau ESC
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('repliesModal');
            
            // Klik outside modal
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            // ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
</x-layout>