<x-layout>
  <x-slot:title>About Us</x-slot:title>

  <div class="container mx-auto py-12 px-6 md:px-0">
    <!-- About Platform -->
    <section class="mb-16">
      <h1 class="text-4xl font-extrabold text-gray-900 mb-6 text-center md:text-left">
        Selamat datang di website kami!
      </h1>
      <p class="text-lg text-gray-700 leading-relaxed text-center md:text-left">
       Kami sedang membangun platform yang mempertemukan membaca dan menulis untuk memperluas wawasan. 
       Jelajahi beragam konten dari para penulis berbakat dan bagikan ide, pengalaman, dan keahlian Anda kepada dunia.
      </p>
    </section>

    <!-- About User -->
    <section class="mb-16">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
          <h2 class="text-3xl font-semibold text-blue-700 mb-4">Unlock Your Potential as a Reader</h2>
          <p class="text-gray-700 mb-4">
            As a <span class="font-semibold">User</span>, you can:
          </p>
          <ul class="list-disc list-inside text-gray-700 space-y-3">
            <li>Explore the latest articles from a wide range of authors.</li>
            <li>Gain fresh perspectives and insights across various fields.</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- About Author -->
    <section>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
          <h2 class="text-3xl font-semibold text-green-700 mb-4">Share Your Voice as an Author</h2>
          <p class="text-gray-700 mb-4">
            As an <span class="font-semibold">Author</span>, you can:
          </p>
          <ul class="list-disc list-inside text-gray-700 space-y-3">
            <li>Create and publish your own original articles.</li>
            <li>Share your unique experiences, ideas, and knowledge with a global audience.</li>
            <li>Build your reputation as a thought leader in the community.</li>
          </ul>
          <p class="text-gray-700 mt-4">
            Our <span class="font-semibold">Admins</span> also contribute articles and manage the platform, ensuring a vibrant and engaging experience for everyone.
          </p>
        </div>
      </div>
    </section>
  </div>
</x-layout>
