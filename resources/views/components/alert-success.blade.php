@if (session('success'))
<div
    id="flash-message"
    class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative mb-4"
    role="alert">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
  </div>

  <script>
    setTimeout(() => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.style.display = 'none';
        }
    }, 5000); // 5 detik

  </script>
@endif