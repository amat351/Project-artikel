<x-layout>
    <x-slot:title>{{ $post->title }}</x-slot:title>

    <img class="py-6" src="{{ $post->photo }}" alt="{{ $post->title }}"/>
    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">{{$post->title}}</h1>
    <p class="text-gray-600 mb-2">
        Author: {{ $post->author->name }} |
        Category: {{ $post->category->name }}
    </p>
    <div class="prose">
        {!! nl2br(e($post->body)) !!}
    </div>

    <a href="{{ route('posts.index') }}" class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded">
        Back to Posts
    </a>
</x-layout>
