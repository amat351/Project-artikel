<div x-data="{ open: false }" class="flex min-h-screen">
  <!-- Sidebar -->
  <div 
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg  transform transition-transform duration-300
           md:translate-x-0 md:flex-shrink-0"
    :class="open ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <!-- Header Sidebar -->
    <div class="d-flex justify-between items-center p-3 border-b bg-light shadow-sm bg-black text-white">
      <h4 class="mb-0 text-primary fw-bold">Admin Panel</h4>
      <!-- Tombol Close (hanya di mobile) -->
      <button @click="open = false" 
              class="text-gray-600 hover:text-red-600 text-2xl font-bold leading-none md:hidden">
        &times;
      </button>
    </div>

    <!-- Bagian isi + scroll -->
    <div class="flex-1 overflow-y-auto">
      <ul class="nav nav-pills flex-column gap-1 p-3 mb-auto">
        <li class="nav-item">
          <a href="{{ url('/admin/posts') }}" class="nav-link {{ Request::is('admin/posts') ? 'active' : 'text-dark' }}">
            Manage Posts
          </a>
        </li>
        <li>
          <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : 'text-dark' }}">
            Home
          </a>
        </li>
        <li>
          <a href="{{ url('/posts') }}" class="nav-link {{ Request::is('posts') ? 'active' : 'text-dark' }}">
            Blog
          </a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="{{ url('/admin/messages') }}">
    Pesan 
    @php $unread = \App\Models\Message::where('is_read', false)->count(); @endphp
    @if($unread > 0)
      <span class="badge bg-danger">{{ $unread }}</span>
    @endif
  </a>
        </li>
        <li>
          <a href="{{ url('/admin/users') }}" class="nav-link {{ Request::is('admin/users*') ? 'active' : 'text-dark' }}">
            Setting
          </a>
        </li>
      </ul>
    </div>

    <!-- Logout selalu fix di bawah -->
    <div class="p-3 border-t mt-90">
      <form action="{{ route('logout') }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-danger w-100">
          Logout
        </button>
      </form>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">
    <!-- Top Navbar -->
    <nav class="bg-black shadow py px-1 flex items-center justify-between md:justify-end">
      <!-- Hamburger hanya muncul di mobile -->
      <button @click="open = !open" class="text-gray-500 text-2xl md:hidden">☰</button>
    </nav>

  </div>
</div>
