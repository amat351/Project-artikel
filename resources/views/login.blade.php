<!DOCTYPE html>
<html lang="en" x-data="{ showPassword: false }" class="bg-gray-100 min-h-screen flex items-center justify-center">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body>

    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8 transform transition-all duration-500 hover:scale-[1.02]">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300"
                    placeholder="you@example.com">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300"
                        placeholder="">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065
                                  7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                                  0-8.268-2.943-9.542-7a9.956 
                                  9.956 0 012.111-3.592M6.23 
                                  6.229A9.953 9.953 0 0112 5c4.477 0 
                                  8.268 2.943 9.542 7a9.953 9.953 
                                  0 01-4.042 5.411M15 12a3 3 0 
                                  11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- ✅ reCAPTCHA -->
    <div class="mt-4">
        <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
        @error('g-recaptcha-response')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105">
                Login
            </button>

            <!-- Script Google reCAPTCHA -->
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            
            <!-- Register Link -->
            <p class="text-center text-gray-600 text-sm mt-4">
                Don’t have an account? 
                <a href="{{ route('register') }}" 
                class="font-medium text-blue-600 hover:text-blue-800 transition">
                Create one now
                </a>
            </p>

            <!-- Link ke Halaman Home -->
            <a href="{{ url ('/') }}"
                class="block text-center text-blue-600 mt-4 hover:underline">
                Enter without account
            </a>
        </form>
    </div>

</body>
</html>