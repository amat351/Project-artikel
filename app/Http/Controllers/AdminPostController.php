<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $authors = User::whereIn('role', ['author', 'admin','superadmin'])->get();
        $categories = Category::all();
        return view('posts.create', compact('authors','categories'));
    }

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:posts,slug,' . $post->id,
            'body' => 'required|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('posts', 'public');
    }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $authors = User::all();
        $categories = Category::all();
        return view('posts.edit', compact('post', 'authors', 'categories'));
    }

    public function update(Request $request, Post $post)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|unique:posts,slug,' . $post->id,
        'body' => 'required|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'author_id' => 'required|exists:users,id',
        'category_id' => 'required|exists:categories,id',
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
        unset($validated['photo']);
    }

    // generate slug dari title
$validated['slug'] = \Str::slug($request->title);


    $post->update($validated);

    return redirect()->route('admin.posts.index')->with('success', 'Post updated!');
}


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }
}
