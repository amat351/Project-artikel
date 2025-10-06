@props(['comment'])

<div class="ml-{{ $comment->parent_id ? '6' : '0' }} mt-3 border-l pl-3">
    <p>
        <strong>{{ $comment->user->name }}</strong> 
        <span class="text-gray-600">{{ $comment->body }}</span>
    </p>

    <!-- Tombol balas -->
    <button 
        class="text-blue-500 text-sm mt-1"
        @click="$refs.replyForm{{ $comment->id }}.classList.toggle('hidden')">
        Balas
    </button>

    <!-- Form balas -->
    <form 
        x-ref="replyForm{{ $comment->id }}" 
        action="{{ route('comments.store', $comment->post) }}" 
        method="POST" 
        class="hidden mt-2 flex gap-2">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <input type="text" name="body" class="flex-1 border rounded p-1 text-sm" placeholder="Tulis balasan...">
        <button class="bg-green-600 text-white px-2 rounded text-sm">Kirim</button>
    </form>

    <!-- Nested replies -->
    @if($comment->replies->count())
        <div class="mt-2 space-y-2">
            @foreach($comment->replies as $reply)
                <x-comment :comment="$reply" />
            @endforeach
        </div>
    @endif
</div>
