<nav class="bg-gray-800 fixed top-0 w-full z-50" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="shrink-0">
            <!-- <img class="size-8" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" /> -->
            <span class="text-white font-bold">MY WEBSITE</span>
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <x-navlink href="/" :active="request()->is('/')">Home</x-navlink>
                <x-navlink href="/posts" :active="request()->is('posts')">Blog</x-navlink>
                <x-navlink href="/about" :active="request()->is('about')">About</x-navlink>
                @auth
    @if(Auth::user()->role === 'user' || Auth::user()->role === 'author')
        <x-navlink href="/contact" :active="request()->is('contact')">Contact</x-navlink>
    @endif
@endauth

@guest
    {{-- kalau mau contact juga muncul untuk pengunjung yang belum login --}}
    <x-navlink href="/contact" :active="request()->is('contact')">Contact</x-navlink>
@endguest

            </div>
          </div>
        </div>
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">

          @guest
            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-white">Log in</a>
          @endguest
         

            <!-- Profile dropdown -->
            @auth
<div class="relative ml-3" x-data="{ isOpen: false }">
  <div>
    <button type="button" @click="isOpen = !isOpen"
            class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none"
            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
      <span class="sr-only">Open user menu</span>
      <img class="size-8 rounded-full object-cover"
     src="{{ !empty(Auth::user()->profile_photo) && Storage::disk('public')->exists(Auth::user()->profile_photo) 
                ? asset('storage/' . Auth::user()->profile_photo) 
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
     alt="{{ Auth::user()->name }}" />
    </button>
  </div>

  <div x-show="isOpen"
       x-transition:enter="transition ease-out duration-100 transform"
       x-transition:enter-start="opacity-0 scale-95"
       x-transition:enter-end="opacity-100 scale-100"
       x-transition:leave="transition ease-in duration-75 transform"
       x-transition:leave-start="opacity-100 scale-100"
       x-transition:leave-end="opacity-0 scale-95"
       class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5"
       role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
    
    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem">Your profile</a>
    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem">Sign out</a>
  </div>
</div>
@endauth

          </div>
        </div>
        <div class="-mr-2 flex md:hidden">
          <!-- Mobile menu button -->
          <button type="button" @click="isOpen = !isOpen" href="/posts" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!-- Menu open: "hidden", Menu closed: "block" -->
            <svg :class="{'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Menu open: "block", Menu closed: "hidden" -->
            <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
<div x-show="isOpen" class="md:hidden" id="mobile-menu">
  <div class="flex items-center justify-between px-2 pb-3 pt-2 sm:px-3">
    <!-- Left Menu -->
    <div class="flex space-x-4">
      <x-navlink href="/" :active="request()->is('/')">Home</x-navlink>
      <x-navlink href="/posts" :active="request()->is('posts')">Blog</x-navlink>
      <x-navlink href="/about" :active="request()->is('about')">About</x-navlink>
      @auth
    @if(Auth::user()->role === 'user' || Auth::user()->role === 'author')
        <x-navlink href="/contact" :active="request()->is('contact')">Contact</x-navlink>
    @endif
@endauth

@guest
    {{-- kalau mau contact juga muncul untuk pengunjung yang belum login --}}
    <x-navlink href="/contact" :active="request()->is('contact')">Contact</x-navlink>
@endguest

    </div>

    <!-- Right Side (Login button if guest) -->
    @guest
      <a href="{{ route('login') }}" 
         class="px-3 py-2 rounded-md text-sm font-medium text-white">
        Log in
      </a>
    @endguest
  </div>

  <!-- Profile section (only when logged in) -->
  @auth
  <div class="border-t border-gray-700 pb-3 pt-4">
    <a href="{{ route('profile.edit') }}">
      <div class="flex items-center px-5">
        <div class="shrink-0">
          <img class="size-10 rounded-full object-cover"
               src="{{ !empty(Auth::user()->profile_photo) && Storage::disk('public')->exists(Auth::user()->profile_photo) 
                      ? asset('storage/' . Auth::user()->profile_photo) 
                      : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
               alt="{{ Auth::user()->name }}" />
        </div>
        <div class="ml-3">
          <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
          <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
        </div>
      </div>
    </a>

    <div class="mt-3 space-y-1 px-2">
      <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-100">Your profile</a>
      <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-100">Sign out</a>
    </div>
  </div>
  @endauth
</div>


  </nav>