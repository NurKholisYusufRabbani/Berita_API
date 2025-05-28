@extends('layouts.app')

@section('title', 'About Us - Global News')

@section('content')
<div class="min-h-screen py-16 px-6 sm:px-12 lg:px-24 flex items-center justify-center">
    <div class="max-w-4xl bg-gray-800 rounded-3xl shadow-xl p-12 text-gray-200">
        <h1 class="text-4xl font-extrabold mb-6 text-white tracking-tight">
            About Global News
        </h1>

        <p class="text-lg leading-relaxed mb-8">
            Global News adalah platform berita terpercaya yang menyajikan informasi terkini dari seluruh penjuru dunia.
            Kami berdedikasi untuk memberikan berita yang akurat, objektif, dan cepat kepada para pembaca kami.
        </p>

        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-semibold mb-2 text-blue-400">Our Mission</h2>
                <p class="text-gray-300">
                    Menyediakan berita berkualitas tinggi yang menginformasikan dan menginspirasi masyarakat secara global,
                    dengan standar jurnalistik yang tinggi dan teknologi mutakhir.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2 text-blue-400">What We Offer</h2>
                <ul class="list-disc list-inside space-y-1 text-gray-300">
                    <li>Berita real-time dari berbagai kategori: politik, ekonomi, teknologi, hiburan, dan lainnya.</li>
                    <li>Analisis mendalam dan opini dari pakar terpercaya.</li>
                    <li>Antarmuka yang mudah digunakan dengan dukungan mode gelap untuk kenyamanan membaca.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2 text-blue-400">Our Values</h2>
                <p class="text-gray-300">
                    Integritas, kecepatan, dan transparansi adalah pilar utama kami dalam menyajikan berita kepada masyarakat luas.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
