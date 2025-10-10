<x-layout>
  <x-slot:title>Tentang Kami</x-slot:title>

  <div class="bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">

      <!-- Judul & Pembuka -->
      <section class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-white mb-6">
          Selamat Datang di <span class="text-blue-600">Platform Kami</span>
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
          Kami membangun ruang digital tempat membaca, menulis, dan berbagi pengetahuan dapat menyatukan banyak orang.
          Di sini, ide-ide berkembang, cerita dibagikan, dan wawasan baru lahir setiap hari.
        </p>
      </section>

      <!-- Tentang Platform -->
      <section class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-20">
        <div data-aos="fade-right">
          <img src="https://cdn-icons-png.flaticon.com/512/2972/2972350.png" alt="Reading Illustration" class="w-3/4 mx-auto md:w-full">
        </div>
        <div data-aos="fade-left">
          <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-4">Mengenal Platform Kami</h2>
          <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-3">
            Platform ini hadir untuk mempertemukan para pembaca dan penulis di satu tempat.
            Kami percaya bahwa setiap orang memiliki kisah dan wawasan yang berharga untuk dibagikan.
          </p>
          <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
            Temukan artikel menarik, tulis pengalamanmu, dan jadilah bagian dari komunitas yang terus tumbuh bersama.
          </p>
        </div>
      </section>

      <!-- Tentang Pembaca -->
      <section class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-20">
        <div data-aos="fade-right" class="order-2 md:order-1">
          <h2 class="text-3xl font-bold text-indigo-700 dark:text-indigo-400 mb-4">Untuk Kamu, Sang Pembaca</h2>
          <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-3">
            Sebagai <span class="font-semibold text-indigo-600">Pembaca</span>, kamu dapat:
          </p>
          <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
            <li>Mengakses artikel-artikel terbaru dari berbagai penulis berbakat.</li>
            <li>Mendapatkan inspirasi dan wawasan baru dari beragam topik.</li>
            <li>Menyimpan bacaan favoritmu untuk dibaca kembali kapan saja.</li>
          </ul>
        </div>
        <div data-aos="fade-left" class="order-1 md:order-2">
          <img src="https://cdn-icons-png.flaticon.com/512/3062/3062634.png" alt="User Reading" class="w-3/4 mx-auto md:w-full">
        </div>
      </section>

      <!-- Tentang Penulis -->
      <section class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-20">
        <div data-aos="fade-right">
          <img src="https://cdn-icons-png.flaticon.com/512/685/685655.png" alt="Author Writing" class="w-3/4 mx-auto md:w-full">
        </div>
        <div data-aos="fade-left">
          <h2 class="text-3xl font-bold text-green-700 dark:text-green-400 mb-4">Untuk Kamu, Sang Penulis</h2>
          <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-3">
            Sebagai <span class="font-semibold text-green-600">Penulis</span>, kamu dapat:
          </p>
          <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
            <li>Membuat dan mempublikasikan artikel orisinalmu sendiri.</li>
            <li>Berbagi pengalaman, ide, dan pengetahuan kepada banyak orang.</li>
            <li>Membangun reputasi sebagai penulis yang berpengaruh dan inspiratif.</li>
          </ul>
          <p class="mt-3 text-gray-700 dark:text-gray-300 leading-relaxed">
            Kami juga memiliki <span class="font-semibold text-gray-800 dark:text-white">Admin</span> yang membantu menjaga kenyamanan serta memastikan konten tetap berkualitas.
          </p>
        </div>
      </section>

      <!-- Penutup -->
      <section class="text-center mt-20">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Bergabunglah Bersama Kami</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-8">
          Mari jadi bagian dari komunitas pembaca dan penulis yang saling menginspirasi satu sama lain.
        </p>
        <a href="/register" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-300">
          Daftar Sekarang
        </a>
      </section>

    </div>
  </div>
</x-layout>
