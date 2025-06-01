@extends('layouts.app')

@section('title', 'Atur Ulang Password')

@section('content')
<div class="flex flex-col items-center justify-center min-h-full px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            {{-- Ganti dengan logo jika ada, atau tambahkan ikon di sini --}}
            {{-- Contoh ikon:
            <div class="flex justify-center mb-4">
                <i class="fas fa-shield-alt fa-3x text-indigo-600"></i>
            </div>
            --}}
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Atur Ulang Password Anda
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Silakan masukkan alamat email Anda, password baru, dan konfirmasi password baru untuk melanjutkan.
            </p>
        </div>

        <div class="bg-white shadow-xl rounded-lg p-8 space-y-6">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Alamat Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               value="{{ $email ?? old('email') }}"
                               class="appearance-none block w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="contoh@email.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password Baru
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                               class="appearance-none block w-full px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="Masukkan password baru">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700">
                        Konfirmasi Password Baru
                    </label>
                    <div class="mt-1">
                        <input id="password-confirm" name="password_confirmation" type="password" autocomplete="new-password" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="Ulangi password baru">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{-- Contoh ikon: <i class="fas fa-save mr-2"></i> --}}
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection