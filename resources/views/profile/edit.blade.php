<x-layout>
    <x-slot:title>Profil Saya</x-slot:title>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow"
         x-data="{ 
            showModal: false, 
            preview: '{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}',
            removePhoto: 0,
            hasPhoto: {{ $user->profile_photo ? 'true' : 'false' }}
         }">
         
        <div>
            <x-alert-success></x-alert-success>
            <x-alert-error></x-alert-error>
        </div>

        <!-- Form utama -->
        <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Foto Profil -->
            <div class="flex flex-col items-center mb-6">
                <div class="relative">
                    <img :src="preview"
                         alt="{{ $user->name }}"
                         class="w-24 h-24 rounded-full object-cover border">
                </div>

                <!-- Tombol Ganti Foto -->
                <div class="flex space-x-4 mt-3">
                    <button type="button"
                            @click="showModal = true"
                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                        Edit foto profil
                    </button>
                </div>
            </div>

            <!-- Nama -->
            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border rounded p-2 w-full">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border rounded p-2 w-full">
            </div>

            <!-- Password Lama -->
<div class="mb-4">
    <label class="block mb-1">Masukan Password</label>
    <input type="password" 
           name="current_password" 
           class="border rounded p-2 w-full"
           autocomplete="off"
           placeholder="Masukkan password lama">
</div>

<!-- Password Baru -->
<div class="mb-4">
    <label class="block mb-1">Password Baru</label>
    <input type="password" 
           name="password" 
           class="border rounded p-2 w-full"
           autocomplete="new-password">
    <input type="password" 
           name="password_confirmation" 
           class="border rounded p-2 w-full mt-2"
           autocomplete="new-password"
           placeholder="Konfirmasi password baru">
</div>
            <!-- Hidden input -->
            <input type="hidden" name="remove_photo" id="remove_photo" x-model="removePhoto">
            <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*">

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- Modal -->
        <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96" @click.away="showModal = false">
                <h2 class="text-lg font-bold mb-4">Edit Foto Profil</h2>

                <!-- Preview -->
                <div class="flex justify-center mb-4">
                    <img :src="preview"
                         alt="Preview Foto"
                         class="w-32 h-32 rounded-full object-cover border">
                </div>

                <div class="flex justify-center space-x-2 mb-4">
                    <!-- Pilih Foto -->
                    <button type="button"
                            @click="$refs.fileInput.click()"
                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        Ganti Foto
                    </button>
                    <input type="file" x-ref="fileInput" class="hidden" accept="image/*"
                           @change="
                                preview = URL.createObjectURL($event.target.files[0]);
                                removePhoto = 0;
                                hasPhoto = true;
                                document.getElementById('profile_photo').files = $event.target.files;">
                    <!-- Hapus Foto -->
                    <template x-if="hasPhoto">
                        <button type="button"
                                @click="
                                    preview = 'https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff';
                                    removePhoto = 1;
                                    hasPhoto = false;
                                    document.getElementById('profile_photo').value = '';
                                "
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                            Hapus Foto
                        </button>
                    </template>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between items-center mt-4">
                    <button type="button" 
                        @click="showModal = false" 
                        class="px-3 py-1 rounded border hover:bg-gray-100">
                            Batal
                    </button>
                    <button type="button" 
                        @click="showModal = false; document.getElementById('profileForm').submit()" 
                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                            OK
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
