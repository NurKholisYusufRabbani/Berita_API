@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-center text-gray-500 text-base mb-6 text-center">Daftar Pengguna</h2>

        <a href="{{ route('admin.users.create') }}"
           class="inline-block bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded mb-4">
            + Tambah User
        </a>

        @if (session('success'))
            <div class="bg-green-600 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-700 text-sm">
                <thead class="bg-gray-800 text-gray-300">
                    <tr>
                        <th class="px-4 py-2 border-b border-gray-700">Nama</th>
                        <th class="px-4 py-2 border-b border-gray-700">Email</th>
                        <th class="px-4 py-2 border-b border-gray-700">Username</th>
                        <th class="px-4 py-2 border-b border-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-900 text-gray-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-800">
                            <td class="px-4 py-2 border-b border-gray-800">{{ $user->name }}</td>
                            <td class="px-4 py-2 border-b border-gray-800">{{ $user->email }}</td>
                            <td class="px-4 py-2 border-b border-gray-800">{{ $user->username }}</td>
                            <td class="px-4 py-2 border-b border-gray-800 space-x-3 flex">
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="text-blue-500" title="Edit">
                                    <!-- Icon Pensil -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5m-7-7l6 6m0 0l-6 6m6-6H9" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                      onsubmit="return confirm('Yakin ingin hapus?')" >
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                        <!-- Icon Tempat Sampah -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-block mt-6 bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            Kembali ke Dashboard
        </a>
    </div>
@endsection
