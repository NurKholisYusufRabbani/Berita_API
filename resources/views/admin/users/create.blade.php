@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto">
        <h2 class="text-center text-gray-500 text-base mb-6 text-center">Tambah Pengguna Baru</h2>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm text-gray-300">Nama</label>
                <input name="name" id="name" required
                       class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" />
            </div>
            
            <div>
                <label for="username" class="block text-sm text-gray-300">Username</label>
                <input name="username" id="username" required
                       class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" />
            </div>

            <div>
                <label for="email" class="block text-sm text-gray-300">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" />
            </div>


            <div>
                <label for="password" class="block text-sm text-gray-300">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
                    Simpan
                </button>

                <a href="{{ route('admin.users.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                    Kembali ke Kelola Pengguna
                </a>
            </div>
        </form>
    </div>
@endsection
