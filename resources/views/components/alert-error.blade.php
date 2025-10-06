@if (session('error'))
    <div 
    id="flash-message"
    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
    role="alert">
        <strong class="font-bold">Oops! </strong>
        <span class="block sm:inline">{{ session('error') }}</span>
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
