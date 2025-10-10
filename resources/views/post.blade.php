<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 dark:bg-gray-900 antialiased">
    <div class="px-4 mx-auto max-w-screen-xl grid grid-cols-1 lg:grid-cols-3 gap-8">  
      
  <!-- Artikel Utama -->
<article class="lg:col-span-2 w-full format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
    <header class="mb-4 lg:mb-6 not-format">
       <address class="flex items-center my-6 not-italic">
          <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
            @php
              $author = $post->author;
              $authorName = $author->name ?? 'User';
              $authorPhoto = $author->profile_photo ?? null;
            @endphp

            <div class="mr-4">
              <img class="w-20 h-20 rounded-full object-cover"
                src="{{ $authorPhoto && Storage::disk('public')->exists($authorPhoto) 
                        ? asset('storage/' . $authorPhoto) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($authorName) . '&background=random&color=fff' }}"
                alt="{{ $authorName }}" />
            </div>  
              <div>
                <a href="/posts?author={{ $post->author->username }}" 
                   rel="author" 
                   class="text-xl font-bold text-gray-900 dark:text-white">
                  {{ $post->author->name }}
                </a>
                
                <p class="text-base text-gray-500 dark:text-gray-400 mb-1">
                  {{ $post->created_at->diffForHumans() }}
                </p>
                <a href="/posts?category={{ $post->category->slug }}">
                  @php
                    $bg = $post->category->color ?? '#999999';
                    $textColor = (hexdec(substr($bg,1,2)) + hexdec(substr($bg,3,2)) + hexdec(substr($bg,5,2)) > 382) 
                        ? '#000000' : '#ffffff'; 
                  @endphp

                <span class="px-3 py-1 text-xs font-semibold rounded-full"
                      style="background-color: {{ $bg }}; color: {{ $textColor }}">
                    {{ $post->category->name }}
                </span>
                </a>
            </div>
          </div>
        </address>
          <img src="{{ $post->photo_url }}" 
            alt="{{ $post->title }}" 
            class="w-full h-full object-cover rounded-lg mb-4">
          <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
            {{ $post->title }}
          </h1>
    </header>
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
          {!! nl2br(e($post->body)) !!}
        </p>
        <div class="flex justify-between items-center mt-8">
          <a href="/posts" class="px-4 py-2 bg-blue-600 no-underline text-white rounded hover:bg-blue-700">
            ← Back to Posts
          </a>
    <div x-data="{ open: false }" class="relative">
      <!-- Button Icon Komentar -->
      <button @click="open = true" class="p-2 rounded hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-label="Buka komentar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.9L3 20l1.9-4.745A7.969 7.969 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <span class="text-xs text-gray-600 mt-1">
  {{ $post->allComments()->count() }}
</span>
      </button>

      <!-- Modal Komentar -->
      <div
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-60 flex flex-col justify-end z-50"
        style="display: none;">
        <div @click.away="open = false" class="bg-white dark:bg-gray-900 rounded-t-xl shadow-lg max-h-[80vh] w-full max-w-md mx-auto flex flex-col">

          <!-- Header Modal -->
          <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Komentar</h3>
            <button @click="open = false" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none text-2xl leading-none">&times;</button>
          </div>

          <!-- Daftar komentar (scrollable) -->
          <div class="flex-1 overflow-y-auto p-4 space-y-4 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700" style="max-height: calc(80vh - 160px);">
            @foreach ($post->comments()->whereNull('parent_id')->with('user', 'replies.user')->latest()->get() as $comment)
              <div class="border rounded-lg p-3 bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center gap-2">
                  <img 
                    src="{{ $comment->user && $comment->user->profile_photo && Storage::disk('public')->exists($comment->user->profile_photo) 
                            ? asset('storage/' . $comment->user->profile_photo) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name ?? 'User ') . '&background=random&color=fff' }}" 
                    alt="{{ $comment->user->name ?? 'User ' }}" 
                    class="w-7 h-7 rounded-full object-cover"
                  />
                  <span class="font-semibold text-gray-900 dark:text-white text-sm leading-tight">{{ $comment->user->name ?? 'User ' }}</span>
                  <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700 dark:text-gray-300 text-sm mt-1">{{ $comment->body }}</p>
                <!-- Balasan -->
                @if ($comment->replies->count())
                  <div class="mt-3 ml-4 border-l-2 border-indigo-500 pl-4 space-y-3">
                    @foreach ($comment->replies as $reply)
                      <div>
                        <p class="font-semibold text-sm text-gray-900 dark:text-white flex items-center space-x-2">
                          <img 
                            src="{{ $reply->user && $reply->user->profile_photo && Storage::disk('public')->exists($reply->user->profile_photo) 
                                    ? asset('storage/' . $reply->user->profile_photo) 
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name ?? 'User ') . '&background=random&color=fff' }}" 
                            alt="{{ $reply->user->name ?? 'User ' }}" 
                            class="w-5 h-5 rounded-full object-cover"
                          />
                          <span>{{ $reply->user->name ?? 'User ' }}</span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 ml-auto">{{ $reply->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm whitespace-pre-line mt-0.5">{{ $reply->body }}</p>
                      </div>
                    @endforeach
                  </div>
                @endif

                <!-- Form balas komentar -->
                @auth
                <form action="{{ route('comments.reply', ['post' => $post->id, 'comment' => $comment->id]) }}" method="POST" class="mt-3 flex space-x-2">
                  @csrf
                  <input type="text" name="body" placeholder="Balas komentar..." required minlength="3" maxlength="1000" class="flex-1 border border-gray-300 dark:border-gray-700 rounded-full px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white" />
                  <button type="submit" class="bg-indigo-600 text-white px-4 rounded-full hover:bg-indigo-700 transition text-sm">Balas</button>
                </form>
                @else
                <p class="mt-3 text-sm italic text-gray-500 dark:text-gray-400">Silakan login untuk membalas komentar.</p>
                @endauth
              </div>
            @endforeach
          </div>

          <!-- Form komentar baru fixed bottom -->
          <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 flex items-center space-x-2">
            @auth
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex flex-1 space-x-2" x-data="{ body: '' }" @submit.prevent="
              if(body.trim().length >= 3) $el.submit();
            ">
              @csrf
              <input 
                type="text" 
                name="body" 
                x-model="body"
                placeholder="Tulis komentar..." 
                minlength="3" maxlength="1000" 
                class="flex-1 border border-gray-300 dark:border-gray-700 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white" 
                autocomplete="off"
                required/>
              <button 
                type="submit" 
                :disabled="body.trim().length < 3"
                class="bg-indigo-600 text-white px-5 py-2 rounded-full disabled:opacity-50 disabled:cursor-not-allowed hover:bg-indigo-700 transition text-sm">
                Kirim
              </button>
            </form>
            @else
            <p class="text-center text-gray-500 italic w-full">Silakan login untuk menulis komentar.</p>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </div>
</article>
      <!-- Sidebar Tentang Penulis -->
      <aside class="w-full bg-gradient-to-b from-blue-100 to-blue-200 p-6 rounded-lg shadow-md">
        <div class="space-y-6">
          @foreach ($other as $post)
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
              <h3 class="text-lg font-semibold mb-4">{{ $post->title }}</h3>
              <img src="{{ $post->photo_url }}" 
                alt="{{ $post->title }}" 
                class="w-full h-full object-cover rounded-lg">
              <a href="/posts?author={{ $post->author->username }}" 
                 rel="author" 
                 class="text-xl font-bold text-gray-900 dark:text-white block">
                {{ $post->author->name }}
              </a>
              <p class="text-base text-gray-500 dark:text-gray-400 mb-1">
                {{ $post->created_at->diffForHumans() }}
              </p>
              <p class="text-sm text-gray-600 mt-2">
                {!! nl2br(e($post->body)) !!}
              </p>
            </div>
          @endforeach
        </div>
      </aside>
    </div>
  </main>
</x-layout>
