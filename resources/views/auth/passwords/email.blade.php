@extends('layouts.app')

@section('title', 'Lupa Password') {{-- Judul halaman --}}

@section('content')
<div class="flex flex-col items-center justify-center min-h-full px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            {{-- Ganti dengan logo jika ada, atau tambahkan ikon di sini --}}
            {{-- Contoh ikon (membutuhkan Font Awesome jika tidak diganti SVG):
            <div class="flex justify-center mb-4">
                <i class="fas fa-key fa-3x text-indigo-600"></i>
            </div>
            --}}
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Lupa Password Anda?
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Jangan khawatir! Masukkan alamat email Anda di bawah ini dan kami akan mengirimkan link untuk mereset password Anda.
            </p>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-lg p-8 space-y-6">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Alamat Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               value="{{ old('email') }}"
                               class="appearance-none block w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="contoh@email.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{-- Contoh ikon: <i class="fas fa-paper-plane mr-2"></i> --}}
                        Kirim Link Reset Password
                    </button>
                </div>
            </form>

            <div class="text-sm text-center">
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection