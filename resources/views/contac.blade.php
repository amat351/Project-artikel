<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
<div class="max-w-xl mx-auto mt-10 bg-white rounded-xl shadow-md overflow-hidden">
  <div class="p-8">
    <div class="flex items-center space-x-4 mb-6">
      <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/>
      </svg>
      <div>
        <div class="text-lg font-semibold text-gray-700">Alamat</div>
      <a href="https://www.google.com/maps?q=Jalan+Manggis+Kampung+Tengah+Mempura+Riau" target="_blank" class="text-gray-500 hover:underline">Jalan Manggis, Kampung Tengah, Mempura, Riau</a>
      </div>
    </div>
    <div class="flex items-center space-x-4 mb-6">
      <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M3 8l9 6 9-6" />
        <rect x="3" y="6" width="18" height="12" rx="2" ry="2" />
      </svg>
      <div>
        <div class="text-lg font-semibold text-gray-700">Email</div>
       <a href="https://mail.google.com/mail/u/0/ekaka418@gmail.com" target="_blank" class="text-gray-500 hover:underline">ekaka418@gmail.com</a>
        <div class="text-gray-500">
      </div>
    </div>
    <div class="flex items-center space-x-4">
      <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M22 16.92V19a2 2 0 0 1-2.18 2A19.72 19.72 0 0 1 3 5.18 2 2 0 0 1 5 3h2.09a2 2 0 0 1 2 1.72c.13 1.05.37 2.07.72 3.06a2 2 0 0 1-.45 2.11l-1.27 1.27a16 16 0 0 0 6.29 6.29l1.27-1.27a2 2 0 0 1 2.11-.45c.99.35 2.01.59 3.06.72A2 2 0 0 1 22 16.92z"></path>
      </svg>
      <div>
        <div class="text-lg font-semibold text-gray-700">No. Telepon</div>
        <div class="text-gray-500">+62 813-7113-9471</div>
      </div>
    </div>
  </div>
</div>
</x-layout>