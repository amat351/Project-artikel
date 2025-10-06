<div x-data="{ openComments: false }" class="mt-4">
    <div x-show="openComments" class="space-y-4">
        <!-- Form -->
        <form action="{{ route('comments.store', $post) }}" method="POST" class="flex gap-2">
            @csrf
            <textarea name="body" rows="2" placeholder="Tulis komentar..."
                      class="flex-1 border rounded p-2"></textarea>
            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Kirim</button>
        </form>

        <!-- Daftar Komentar -->
        @foreach($post->comments as $comment)
            <div class="border-t pt-2">
                <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->body }}</p>

                <!-- Reply form (hanya author bisa balas) -->
                @if(auth()->id() === $post->author_id)
                <form action="{{ route('comments.store', $post) }}" method="POST" class="ml-4 mt-2 flex gap-2">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <input type="text" name="body" placeholder="Balas komentar..."
                           class="flex-1 border rounded p-1">
                    <button class="bg-green-600 text-white px-2 rounded">Balas</button>
                </form>
                @endif

                <!-- Replies -->
                @foreach($comment->replies as $reply)
                    <div class="ml-6 mt-2 text-sm text-gray-700">
                        <strong>{{ $reply->user->name }}</strong>: {{ $reply->body }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
