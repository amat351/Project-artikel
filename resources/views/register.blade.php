<!DOCTYPE html>
<html lang="en" x-data class="bg-gray-100 min-h-screen flex items-center justify-center">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body>

<div class="w-full max-w-md bg-white shadow-lg rounded-xl p-10 transform transition-all duration-500 hover:scale-[1.02]">
    <h1 class="text-gray-900 text-2xl mb-6 font-semibold text-center">Register Akun</h1>

  <form action="{{ route('register') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Nama Lengkap -->
      <div>
        <label for="name" class="block text-gray-700 mb-1 font-medium">Nama Lengkap</label>
        <input type="text" id="name" name="name" autocomplete="name" required
          class="w-full rounded-md p-3 bg-white text-black border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" />
        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Username -->
      <div>
        <label for="username" class="block text-gray-700 mb-1 font-medium">Username</label>
        <input type="text" id="username" name="username" autocomplete="username" required
          class="w-full rounded-md p-3 bg-white text-black border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('username') border-red-500 @enderror" />
        @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-gray-700 mb-1 font-medium">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required
          class="w-full rounded-md p-3 bg-white text-black border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror" />
        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Password -->
      <div x-data="{ show: false }" class="relative">
        <label for="password" class="block text-gray-700 mb-1 font-medium">Password</label>
        <input :type="show ? 'text' : 'password'" id="password" name="password" autocomplete="new-password" required
          class="w-full rounded-md p-3 pr-10 bg-white text-black border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror" />
        <button type="button" @click="show = !show" 
          class="absolute right-3 top-9 text-gray-500 hover:text-gray-700 focus:outline-none">
          <!-- Eye Open -->
          <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
          <!-- Eye Off -->
          <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.953 9.953 0 012.293-3.95M6.2 6.2A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.093M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
          </svg>
        </button>
        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Konfirmasi Password -->
      <div x-data="{ show: false }" class="relative">
        <label for="password_confirmation" class="block text-gray-700 mb-1 font-medium">Konfirmasi Password</label>
        <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required
          class="w-full rounded-md p-3 pr-10 bg-white text-black border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
        <button type="button" @click="show = !show" 
          class="absolute right-3 top-9 text-gray-500 hover:text-gray-700 focus:outline-none">
          <!-- Eye Open -->
          <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
          <!-- Eye Off -->
          <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.953 9.953 0 012.293-3.95M6.2 6.2A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.093M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
          </svg>
        </button>
      </div>

      <!-- Tombol Submit -->
    <button type="submit" 
      class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-md font-semibold transition mt-6">
      Daftar
    </button>
    <div class="block text-gray-700 mb-1 font-medium">Sudah memiliki akun? <a href="login">Log in</a> </div>
  </form>
</div>
</body>
</html>
