<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthorPostController extends Controller
{
    public function index()
    {
        // Tampilkan hanya post milik author yang login
        $posts = Post::where('author_id', Auth::id())
            ->latest()
            ->paginate(7);

        return view('author.posts.index', compact('posts'));
    }

    public function create()
    {
        // Tidak perlu ambil semua author, cukup category saja
        $categories = Category::all();
        return view('author.posts.create', compact('categories'));
    }

    public function store(Request $request, Post $post)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'slug' => 'required|unique:posts,slug,' . $post->id,
        'body' => 'required',
        'category_id' => 'required|exists:categories,id',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Auto generate slug kalau kosong
    if (empty($validated['slug'])) {
        $validated['slug'] = \Str::slug($validated['title']) . '-' . uniqid();
    }

    $validated['author_id'] = auth()->id();

    // Handle photo upload
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('post_photos', 'public');
        $validated['photo'] = $path;
    }

    Post::create($validated);

    return redirect()->route('author.posts.index')->with('success', 'Artikel berhasil ditambahkan!');
}

    public function show(Post $post)
    {
        // Cegah akses post milik author lain
        if ($post->author_id !== Auth::id()) {
            abort(403);
        }

        return view('author.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Cegah akses edit post milik author lain
        if ($post->author_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('author.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        // Cegah update post milik author lain
        if ($post->author_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|unique:posts,slug,' . $post->id,
            'body'        => 'required',
            'category_id' => 'required|exists:categories,id',
            'photo'       => 'nullabe|image|mimes:jpg,jpeg,png|max:2048',
        ]);

            // kalau upload file baru
        if ($request->hasFile('photo')) {
            // hapus foto lama kalau ada
            if ($post->photo && Storage::disk('public')->exists($post->photo)) {
                Storage::disk('public')->delete($post->photo);
            }

            $path = $request->file('photo')->store('post_photos', 'public');
            $validated['photo'] = $path;
        } else {
            unset($validated['photo']); // jangan overwrite kalau tidak upload
        }

        // slug selalu regenerate dari title
        $validated['slug'] = \Str::slug($validated['title']);

        $post->update($validated);

        return redirect()->route('author.posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Cegah delete post milik author lain
        if ($post->author_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('author.posts.index')->with('success', 'Post deleted successfully!');
    }
}
