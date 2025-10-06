<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Pengaturan Website</h2>

        @if(session('success'))
            <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}">
            @csrf

            <!-- Background Color -->
            <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                Pilih Warna Background:
            </label>
            <select name="bg_color" class="border rounded p-2 w-full">
                <option value="bg-white" {{ $user->bg_color == 'bg-white' ? 'selected' : '' }}>Putih</option>
                <option value="bg-gray-100" {{ $user->bg_color == 'bg-gray-100' ? 'selected' : '' }}>Abu-abu</option>
                <option value="bg-blue-100" {{ $user->bg_color == 'bg-blue-100' ? 'selected' : '' }}>Biru</option>
                <option value="bg-green-100" {{ $user->bg_color == 'bg-green-100' ? 'selected' : '' }}>Hijau</option>
                <option value="bg-yellow-100" {{ $user->bg_color == 'bg-yellow-100' ? 'selected' : '' }}>Kuning</option>
                <option value="bg-black text-white" {{ $user->bg_color == 'bg-black text-white' ? 'selected' : '' }}>Hitam</option>
            </select>

            <!-- Font Size -->
            <label class="block mt-4 mb-2 font-semibold text-gray-700 dark:text-gray-200">
                Ukuran Font:
            </label>
            <select name="font_size" class="border rounded p-2 w-full">
                <option value="text-sm" {{ $user->font_size == 'text-sm' ? 'selected' : '' }}>Kecil</option>
                <option value="text-base" {{ $user->font_size == 'text-base' ? 'selected' : '' }}>Normal</option>
                <option value="text-lg" {{ $user->font_size == 'text-lg' ? 'selected' : '' }}>Besar</option>
                <option value="text-xl" {{ $user->font_size == 'text-xl' ? 'selected' : '' }}>Sangat Besar</option>
            </select>

            <!-- Dark Mode -->
            <div class="flex items-center mt-4">
                <input type="checkbox" name="dark_mode" id="darkMode" {{ $user->dark_mode ? 'checked' : '' }}>
                <label for="darkMode" class="ml-2 text-gray-700 dark:text-gray-200">Aktifkan Dark Mode</label>
            </div>

            <button type="submit" class="mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Simpan
            </button>
        </form>
    </div>
</x-layout>
