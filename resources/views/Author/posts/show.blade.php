<x-layout>
    <x-slot:title>{{ $post->author->name }}</x-slot:title>
<img src="{{ $post->photo_url }}" 
     alt="{{ $post->title }}" 
     class="w-full h-300px object-cover rounded-lg">
    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">{{$post->title}}</h1>
    <p class="text-gray-600 mb-4 text-xl taxt-bold">
        Author: {{ $post->author->name }} |
        @php
            $bg = $post->category->color ?? '#999999';
            $textColor = (hexdec(substr($bg,1,2)) + hexdec(substr($bg,3,2)) + hexdec(substr($bg,5,2)) > 382) 
                ? '#000000' : '#ffffff'; 
        @endphp

        <span class="px-3 py-1 text-xs font-semibold rounded-full"
              style="background-color: {{ $bg }}; color: {{ $textColor }}">
            {{ $post->category->name }}
        </span>
    </p>
    <div class="prose">
        {!! nl2br(e($post->body)) !!}
    </div>
    <div class="flex justify-start mt-8">
          <a href="/author/posts" class="px-4 py-2 bg-blue-600 no-underline text-white rounded hover:bg-blue-700">
            ← Back
          </a>
        </div>
</x-layout>
