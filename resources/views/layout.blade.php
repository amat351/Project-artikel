<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 240px;
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #ddd;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #000;
            margin-bottom: 5px;
            border-radius: 5px;
            font-weight: 500;
        }
        .sidebar a.active, .sidebar a:hover {
            background-color: #0d6efd;
            color: white;
        }
        .content {
            flex: 1;
            padding: 20px;
            background: #f5f6fa;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <h4 class="mb-4">Menu</h4>
        <a href="/home" class="{{ request()->is('home') ? 'active' : '' }}">Home</a>
        <a href="/posts" class="{{ request()->is('posts') ? 'active' : '' }}">Blog</a>
        <a href="/about" class="{{ request()->is('about') ? 'active' : '' }}">About</a>
        <a href="/contact" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
        <a href="/admin/posts" class="{{ request()->is('admin/posts*') ? 'active' : '' }}">Manage Posts</a>
        <form action="/logout" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    {{-- Content --}}
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
