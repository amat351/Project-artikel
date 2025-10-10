<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AuthorPostController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\IsAdminOrSuperAdmin;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use App\Http\Middleware\AuthorMiddleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Karnel;


Route::get('/test-role', function () {
    return "You are logged in as: " . Auth::user()->role;
})->middleware(['auth', 'role:admin']);

//==============================
// Halaman Home
//==============================
Route::get('/', function () {
    return view('home', [
        'title' => 'Home',
        'users' => User::all(),
        'authors' => User::whereIn('role', ['author', 'admin','superadmin'])->get(),
        'recentPosts'  => Post::latest()->take(2)->get(),
        'post_count' => Post::count(),
        'author_count' => User::whereIn('role', ['author', 'admin','superadmin'])->count(),
        'user_count' => User::count(),
    ]);
});

Route::get('/posts', function () {
    $posts = Post::filter(request(['search', 'category', 'author', 'body']))
                ->latest()
                ->paginate(12)
                ->withQueryString();

    $title = 'Blog';
    $author = null;

    if (request('author')) {
        $author = User::where('username', request('author'))->first();
        if ($author) {
            $title = "Articles by " . $author->name;
        }
    }

    return view('posts', [
        'title' => $title,
        'posts' => $posts,
        'author' => $author
    ]);
});


// Blog - Single Post
Route::get('/posts/{post:slug}', function (Post $post) {
    if (Auth::check()) {
        return view('post', [
            'title' => $post->title,
            'post' => $post,
            'other' => Post::where('id', '!=', $post->id)->inRandomOrder()->take(3)->get()
        ]);
    } else {
        return redirect()->route('login')->with('error', 'Please log in to view this page.');
    }
});

// Blog - Berdasarkan Penulis
Route::get('/authors/{user:username}', function (User $user) { 
    return view('posts', [
        'title' => count($user->posts) . ' Articles by ' . $user->name,
        'posts' => $user->posts
    ]);
});

// Blog - Berdasarkan Kategori
Route::get('/categories/{category:slug}', function (Category $category) {  
    return view('posts', [
        'title' => 'Articles in: ' . $category->name,
        'posts' => $category->posts
    ]);
});

// Halaman About
Route::get('/about', function () {
    return view('about', []);
});


//==============================================
// CRUD untuk Admin
//==============================================
Route::prefix('admin',)->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::get('/posts/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
    Route::post('/posts', [AdminPostController::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::get('/posts/{post:slug}', [AdminPostController::class, 'show'])->name('admin.posts.show');
    Route::get('/dashboard', [AdminPostController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/messages/{message}', [AdminMessageController::class, 'show'])->name('admin.messages.show');
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('admin.messages.index');
    Route::post('/messages', [AdminMessageController::class, 'store'])->name('messages.store');
    Route::delete('/messages/{message}', [AdminMessageController::class, 'destroy'])->name('admin.messages.destroy');
    Route::post('messages/{message}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');
    Route::resource('/users', AdminUserController::class)->except(['create', 'store', 'show',]);
    Route::delete('/users/{user}/remove-avatar', [AdminUserController::class, 'removeAvatar'])
            ->name('admin.users.removeAvatar');
});

//==============================================
// CRUD Post untuk Author
//==============================================
Route::prefix('author')->middleware(['auth', 'role:author'])->group(function () {
    Route::get('/posts', [AuthorPostController::class, 'index'])->name('author.posts.index');
    Route::get('/posts/create', [AuthorPostController::class, 'create'])->name('author.posts.create');
    Route::post('/posts', [AuthorPostController::class, 'store'])->name('author.posts.store');
    Route::get('/posts/{post}/edit', [AuthorPostController::class, 'edit'])->name('author.posts.edit');
    Route::put('/posts/{post}', [AuthorPostController::class, 'update'])->name('author.posts.update');
    Route::delete('/posts/{post}', [AuthorPostController::class, 'destroy'])->name('author.posts.destroy');
    Route::get('/posts/{post}', [AuthorPostController::class, 'show'])->name('author.posts.show');
    Route::get('/dashboard', [AuthorPostController::class, 'dashboard'])->name('author.dashboard');
});

//==============================================
// Contact untuk users/authors
//==============================================
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index')->middleware('auth');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('auth');
Route::delete('/user/messages/{message}', [ContactController::class, 'destroy'])->name('user.messages.destroy')->middleware('auth');



//===============================
// Login & Logout
//===============================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//===============================
//register
//===============================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

//===============================
//profil
//===============================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
});

//===============================
//crud superadmin
//===============================
Route::middleware(['auth', 'isAdminOrSuperAdmin'])->group(function () {
    Route::get('admin/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::get('admin/posts/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
    Route::post('admin/posts', [AdminPostController::class, 'store'])->name('admin.posts.store');
    Route::get('admin/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('admin/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
    Route::delete('admin/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::get('admin/posts/{post:slug}', [AdminPostController::class, 'show'])->name('admin.posts.show');
    Route::get('admin/dashboard', [AdminPostController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/messages/{message}', [AdminMessageController::class, 'show'])->name('admin.messages.show');
    Route::get('/admin/messages', [AdminMessageController::class, 'index'])->name('admin.messages.index');
    Route::delete('/admin/messages/{message}', [AdminMessageController::class, 'destroy'])->name('admin.messages.destroy');
    Route::post('/admin/messages/{message}/reply', [AdminMessageController::class, 'reply'])->name('admin.messages.reply');
    Route::delete('/admin/messages/{reply}/delete-reply', [AdminMessageController::class, 'deleteReply'])->name('admin.messages.deleteReply');
    Route::resource('admin/users', AdminUserController::class)->except(['create', 'store', 'show',]);
    Route::delete('admin/users/{user}/remove-avatar', [AdminUserController::class, 'removeAvatar'])
            ->name('admin.users.removeAvatar');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
});

Route::get('/admin/categories/check-slug', [CategoryController::class, 'checkSlug'])
    ->name('categories.checkSlug');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/posts/{post}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');

Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::resource('messages', MessageController::class)->only(['index', 'show']);
});