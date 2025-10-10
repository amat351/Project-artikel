<x-layout>
  <x-slot:title>{{ $title ?? 'Home' }}</x-slot:title>

  @php
      $user = Auth::user();
      $bg   = $user->bg_color ?? 'bg-white';
      $font = $user->font_size ?? 'text-base';
      $dark = $user->dark_mode ?? false;
  @endphp

  <div x-data="{ activeTab: 'dashboard' }" class="{{ $dark ? 'dark' : '' }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 {{ $bg }} {{ $font }}">

      <!-- Navigation Tabs -->
      <div class="flex justify-center mb-8 space-x-4">
        <button @click="activeTab = 'dashboard'"
          :class="{ 'bg-blue-500 text-white': activeTab === 'dashboard', 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200': activeTab !== 'dashboard' }"
          class="px-4 py-2 rounded-lg transition duration-200">
          Dashboard
        </button>
        <button @click="activeTab = 'team'"
          :class="{ 'bg-blue-500 text-white': activeTab === 'team', 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200': activeTab !== 'team' }"
          class="px-4 py-2 rounded-lg transition duration-200">
          User
        </button>
      </div>

      <!-- Dashboard Content -->
      <div 
        x-show="activeTab === 'dashboard'" 
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-400"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
      >
        <!-- Statistik -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Total Statistik</h2>
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <span class="text-gray-600 dark:text-gray-300">Total Authors</span>
              <span class="text-blue-500 font-bold text-lg">{{$author_count}}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-gray-600 dark:text-gray-300">Total Users</span>
              <span class="text-blue-500 font-bold text-lg">{{$user_count}}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-gray-600 dark:text-gray-300">Total Articles</span>
              <span class="text-green-500 font-bold text-lg">{{$post_count}}</span>
            </div>
          </div>
        </div>

        <!-- Aktivitas -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Recent Activities</h2>
          <ul class="space-y-3">
            @forelse($recentPosts as $post)
              <li class="flex items-center space-x-3">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                <span class="text-gray-600 dark:text-gray-300">
                  @auth
                    <a href="/posts/{{ $post->slug }}" class="hover:underline font-semibold">
                      {{ $post->title }}
                    </a>
                  @else
                    <a href="{{ route('login') }}" class="hover:underline text-gray-400 font-semibold" title="Login to view this artikel">
                      {{ $post->title }}
                    </a>
                  @endauth
                  <span class="text-xs text-gray-400">({{ $post->created_at->diffForHumans() }})</span>
                </span>
              </li>
            @empty
              <li class="text-gray-500 dark:text-gray-400 text-center">No recent activities yet.</li>
            @endforelse
          </ul>
        </div>

        <!-- Panel berdasarkan role -->
        @auth
          @if(Auth::user()->role === 'superadmin')
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center justify-center">
              <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Super Admin Panel</h2>
              <a href="/admin/posts" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-300">
                Go to Super Admin Panel
              </a>
            </div>
          @endif

          @if(Auth::user()->role === 'admin')
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center justify-center">
              <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Quick Actions</h2>
              <a href="/admin/posts" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                Go to Admin Panel
              </a>
            </div>
          @endif

          @if(Auth::user()->role === 'author')
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center justify-center">
              <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Quick Actions</h2>
              <a href="{{ route('author.posts.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                + Create New Artikel
              </a>
            </div>
          @endif
        @endauth
      </div>

      <!-- Team Content -->
      <div 
        x-show="activeTab === 'team'"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-400"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="mt-10"
      >
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Author List</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @forelse ($authors as $author)
            @auth
              <a href="/posts?author={{$author->username}}" class="flex flex-col items-start p-5 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow hover:shadow-xl transition duration-300">
                <div class="space-y-1">
                  <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $author->name }}</h3>
                  <p class="text-sm text-gray-600 dark:text-gray-300">{{ $author->email }}</p>
                </div>
              </a>
            @else
              <a href="{{ route('login') }}" title="Login to view this artikel author"
                 class="flex flex-col items-start p-5 bg-gray-100 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 opacity-70 hover:shadow-xl transition duration-300">
                <div class="space-y-1">
                  <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $author->name }}</h3>
                  <p class="text-sm text-gray-600 dark:text-gray-300">{{ $author->email }}</p>
                </div>
              </a>
            @endauth
          @empty
            <p class="text-center text-gray-600 dark:text-gray-400 col-span-full">No authors found.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-layout>
