@extends('layouts.app')

@section('title', 'Contact Us - Global News')

@section('content')
<div class="min-h-screen py-16 px-6 sm:px-12 lg:px-24 flex items-center justify-center">
    <div class="max-w-xl w-full bg-gray-800 rounded-3xl shadow-xl p-10 text-gray-200">
        <h1 class="text-3xl font-extrabold mb-4 text-white tracking-tight text-center">
            Hubungi Kami
        </h1>

        <p class="text-gray-400 mb-8 text-center leading-relaxed">
            Kami siap mendengar masukan, pertanyaan, atau kritik Anda untuk terus meningkatkan layanan Global News. Silakan isi form berikut untuk menghubungi kami secara langsung.
        </p>

        <form action="mailto:m.23085@mhs.unesa.ac.id" method="POST" enctype="text/plain" class="space-y-6">
            <div>
                <label for="name" class="block mb-2 font-semibold">Nama</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 rounded-md bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" />
            </div>

            <div>
                <label for="email" class="block mb-2 font-semibold">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 rounded-md bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" />
            </div>

            <div>
                <label for="message" class="block mb-2 font-semibold">Pesan</label>
                <textarea id="message" name="message" rows="4" required
                    class="w-full px-4 py-2 rounded-md bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white resize-none"></textarea>
            </div>

            <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-full font-semibold transition duration-300">
                Kirim Pesan
            </button>
        </form>
    </div>
</div>
@endsection
