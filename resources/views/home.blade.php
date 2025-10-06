<x-layout>
  <x-slot:title>{{ $title ?? 'Home' }}</x-slot:title>
  
  @php
      $user = Auth::user();
      $bg   = $user->bg_color ?? 'bg-white';
      $font = $user->font_size ?? 'text-base';
      $dark = $user->dark_mode ?? false;
  @endphp

  <div x-data="{ activeTab: 'dashboard' }" class="{{ $dark ? 'dark' : '' }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 {{ $bg }} {{ $font }}">
      
      <!-- Navigation Tabs -->
      <div class="flex space-x-4 mb-6">
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
      <div x-show="activeTab === 'dashboard'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Total Articel</h2>
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <span class="text-gray-600 dark:text-gray-300">Total Authors</span>
              <span class="text-blue-500 font-semibold">{{$author_count}}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-gray-600 dark:text-gray-300">Total Users</span>
              <span class="text-blue-500 font-semibold">{{$user_count}}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-gray-600 dark:text-gray-300">Total Articles</span>
              <span class="text-green-500 font-semibold">{{$post_count}}</span>
            </div>
          </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Recent Activities</h2>
          <ul class="space-y-3">
            @forelse($recentPosts as $post)
              <li class="flex items-center space-x-3">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                <span class="text-gray-600 dark:text-gray-300">
                  @auth
                    <a href="/posts/{{ $post->slug }}" class="hover:underline">
                      <strong>{{ $post->title }}</strong>
                    </a>
                  @else
                    <a href="{{ route('login') }}" class="hover:underline text-gray-400" title="Login to view this artikel">
                      <strong>{{ $post->title }}</strong>
                    </a>
                  @endauth
                  <span class="text-xs text-gray-400">({{ $post->created_at->diffForHumans() }})</span>
                </span>
              </li>
            @empty
              <li class="text-gray-500 dark:text-gray-400">No recent activities yet.</li>
            @endforelse
          </ul>
        </div>  

        @auth
          {{-- Super Admin --}}
          @if(Auth::user()->role === 'superadmin')
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
              <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Super Admin Panel</h2>
              <div class="text-center mt-6">
                <a href="/admin/posts" class="bg-purple-600 text-white px-4 py-2 rounded hover:shadow-lg hover:text-gray-200 transition duration-200">
                  Go to Super Admin Panel
                </a>
              </div>
            </div>
          @endif

          @if(Auth::user()->role === 'admin')
          <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h2>
            <div class="text-center mt-6">
              <a href="/admin/posts" class="bg-blue-500 text-white px-4 py-2 rounded hover:shadow-lg hover:text-gray-200 transition duration-200">
                Go to Admin Panel
              </a>
            </div>
          </div>
          @endif

          @if(Auth::user()->role === 'author')
          <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h2>
            <div class="text-center mt-6">
              <a href="{{ route('author.posts.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg transition duration-200">
                + create new artikel
              </a>
            </div>
          </div>
          @endif

          @if(Auth::user()->role === 'user')
          <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h2>
            <div class="text-center mt-6">
              <a href="{{ route('author.posts.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:shadow-lg hover:text-gray-200 transition duration-200">
               + create new artikel
              </a>
            </div>
          </div>
          @endif
        @endauth
      </div>

      <!-- Team Content -->
      <div x-show="activeTab === 'team'" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Author</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          @forelse ($authors as $author)
            @auth
              <a href="/posts?author={{$author->username}}" class="flex-shrink-0">
                <div class="flex items-center space-x-4 p-4 border rounded-lg shadow-md hover:shadow-xl transition duration-200 dark:border-gray-700">
                  <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">{{$author->name}}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{$author->email}}</p>
                  </div>
                </div>
              </a>
            @else
              <a href="{{ route('login') }}" class="flex-shrink-0" title="Login to view this artikel author">
                <div class="flex items-center space-x-4 p-4 border rounded-lg shadow-md hover:shadow-xl transition duration-200 opacity-70 dark:border-gray-700">
                  <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">{{$author->name}}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{$author->email}}</p>
                  </div>
                </div>
              </a>
            @endauth
          @empty
            <p class="text-gray-600 dark:text-gray-400">No team members found.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-layout>
