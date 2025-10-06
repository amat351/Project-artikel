<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // ✅ Validasi (hanya authenticated user)
        $validated = $request->validate([
            'body' => 'required|string|max:1000|min:3', // Isi komentar wajib, max 1000 char
        ], [
            'body.required' => 'Komentar tidak boleh kosong.',
            'body.min' => 'Komentar minimal 3 karakter.',
            'body.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        // ✅ Buat komentar utama (parent_id null)
        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $validated['body'],
            'parent_id' => null, // Komentar utama
        ]);

        // ✅ Load ulang post dengan comments untuk redirect
        $post->load('comments.replies.user'); // Eager load untuk tampilan

        return back()->with('success', 'Komentar berhasil dikirim!')->with('post', $post);
    }

    public function reply(Request $request, Post $post, Comment $comment)
    {
        // ✅ Pastikan comment belongs to post yang sama (keamanan)
        if ($comment->post_id !== $request->route('post')->id ?? $comment->post_id) {
            abort(404);
        }

        // ✅ Validasi
        $validated = $request->validate([
            'body' => 'required|string|max:1000|min:3',
        ], [
            'body.required' => 'Balasan tidak boleh kosong.',
            'body.min' => 'Balasan minimal 3 karakter.',
            'body.max' => 'Balasan maksimal 1000 karakter.',
        ]);

        // ✅ Buat reply (parent_id = comment id)
        $reply = $comment->replies()->create([
            'user_id' => Auth::id(),
            'body' => $validated['body'],
            'parent_id' => $comment->id,
            'post_id' => $post->id,
        ]);

        // ✅ Load ulang untuk tampilan
        $comment->load('replies.user');

        return back()->with('success', 'Balasan berhasil dikirim!')->with('comment', $comment);
    }
}