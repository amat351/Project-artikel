<x-layout>
  <x-slot:title>{{$title}}</x-slot:title>

  <div class="py-4 px-4 mx-auto max-w-screen-xl lg:px-6">
      <div class="mx-auto max-w-screen-md sm:text-center">
          <form>
            @if (request('category'))
              <input type="hidden" name="category" value="{{request('category')}}">
            @endif
            @if (request('author'))
              <input type="hidden" name="author" value="{{request('author')}}">
            @endif
              <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                  <div class="relative w-full">
                      <label for="search" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Search</label>
                      <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
                      </div>
                      <input class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search for article" type="search" id="search" name="search" autocomplete="on">
                  </div>
                  <div>
                      <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Search</button>
                  </div>
              </div>
          </form>
      </div>
  </div>

    <div class="py-4 px-4 mx-auto max-w-screen-xl lg:py-8 lg:px-0">
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
    @forelse ($posts as $post)
    <article class="p-4 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 ease-in-out hover:scale-105 transition-transform duration-200">
      <!-- Gambar Postingan -->
      <img src="{{ $post->photo_url }}" 
          alt="{{ $post->title }}" 
          class="w-full h-64 object-cover rounded-lg mb-2">

    <!-- Kategori & Tanggal -->
    <div class="flex justify-between items-center mb-4 text-gray-500">
        <a href="/posts?category={{$post->category->slug}}" class="hover:text-green-600">
        
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
        <span class="text-sm">{{$post->created_at->diffForHumans()}}</span>
    </div>

    <!-- Judul Artikel -->
    <a href="/posts/{{$post['slug']}}" class="hover:underline">
        <h2 class="mb-2 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white hover:text-primary-600 transition-colors duration-200 ease-in-out">{{$post->title}}</h2>
    </a>

    <!-- Deskripsi Artikel -->
    <p class="mb-5 text-gray-600 dark:text-gray-400 text-base font-light line-clamp-3">{{$post->body}}</p>

    <!-- Penulis dan "Read More" -->
    <div class="flex justify-between items-center mt-5">
        <a href="/posts?author={{$post->author->username}}" class="hover:underline">
            <div class="flex items-center space-x-3">
    @php
        $author = $post->author;
        $authorName = $author->name ?? 'User';
        $authorPhoto = $author->profile_photo ?? null;
    @endphp

    <img class="w-8 h-8 rounded-full object-cover"
         src="{{ $authorPhoto && Storage::disk('public')->exists($authorPhoto) 
                ? asset('storage/' . $authorPhoto) 
                : 'https://ui-avatars.com/api/?name=' . urlencode($authorName) . '&background=random&color=fff' }}"
         alt="{{ $authorName }}" />

    <span class="font-medium text-sm dark:text-white">{{ $authorName }}</span>
    </div>
        </a>
        <a href="/posts/{{$post['slug']}}" class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
            <span>Read more</span>
            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </a>
    </div>
  </article>
  @empty
  <div class="flex items-center justify-center h-64">
    <div>
      <p class="font-bold text-xl my-4 text-center text-red-500">Article not found!</p>
       <a href="/posts" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-200">&laquo; Back to all posts</a>
    </div>
  </div>
  @endforelse
    </div>  
  </div>
  {{ $posts->links()}}
</x-layout>