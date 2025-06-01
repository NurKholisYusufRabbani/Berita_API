@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">
            Halo, Admin <span class="text-red-500">{{ auth()->user()->name }}</span> 
        </h1>

        <p class="text-gray-400 mt-1">Selamat datang di dashboard admin!</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Tombol Kelola Pengguna -->
        <a href="{{ route('admin.users.index') }}"
            class="bg-gray-800 hover:bg-red-600 border border-gray-700 hover:border-red-500 transition-all duration-200 text-white font-medium py-3 px-5 rounded-lg text-center">
            Kelola Pengguna
        </a>

        <!-- Tombol Kelola Saved Articles -->
        <a href="{{ route('admin.saved_articles.index') }}"
            class="bg-gray-800 hover:bg-red-600 border border-gray-700 hover:border-red-500 transition-all duration-200 text-white font-medium py-3 px-5 rounded-lg text-center">
            Kelola Saved Articles
        </a>

        <!-- Tombol Kelola Diskusi -->
        <a href="{{ route('admin.discussions.index') }}"
            class="bg-gray-800 hover:bg-red-600 border border-gray-700 hover:border-red-500 transition-all duration-200 text-white font-medium py-3 px-5 rounded-lg text-center">
            Kelola Diskusi
        </a>
    </div>
@endsection
