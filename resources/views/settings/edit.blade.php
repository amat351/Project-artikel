<x-layout>
    <x-slot:title>Settings</x-slot:title>

    <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mt-8">
        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">User Settings</h2>

        <x-alert-success></x-alert-success>

        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <!-- Background Color -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Background Color</label>
                <select name="bg_color" class="w-full p-2 border rounded">
                    <option value="bg-white" {{ $user->bg_color == 'bg-white' ? 'selected' : '' }}>White</option>
                    <option value="bg-gray-100" {{ $user->bg_color == 'bg-gray-100' ? 'selected' : '' }}>Gray</option>
                    <option value="bg-blue-100" {{ $user->bg_color == 'bg-blue-100' ? 'selected' : '' }}>Blue</option>
                </select>
            </div>
            <!-- Font Size -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Font Size</label>
                <select name="font_size" class="w-full p-2 border rounded">
                    <option value="text-sm" {{ $user->font_size == 'text-sm' ? 'selected' : '' }}>Small</option>
                    <option value="text-base" {{ $user->font_size == 'text-base' ? 'selected' : '' }}>Normal</option>
                    <option value="text-lg" {{ $user->font_size == 'text-lg' ? 'selected' : '' }}>Large</option>
                </select>
            </div>
            <!-- Dark Mode -->
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="dark_mode" id="dark_mode" value="1"
                       {{ $user->dark_mode ? 'checked' : '' }}
                       class="mr-2">
                <label for="dark_mode" class="text-gray-700 dark:text-gray-300">Enable Dark Mode</label>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Save Settings
            </button>
        </form>
    </div>
</x-layout>
