@extends('layouts.admin')

@section('content')
    <h2 class="text-center text-gray-500 text-base mb-6">Daftar Pengguna yang Menyimpan Artikel</h2>

    <table class="w-full border-collapse border border-gray-700 text-white">
        <thead class="bg-gray-800 text-gray-400">
            <tr>
                <th class="border border-gray-700 px-4 py-2 text-left">Nama</th>
                <th class="border border-gray-700 px-4 py-2 text-left">Username</th>
                <th class="border border-gray-700 px-4 py-2 text-left">Email</th>
                <th class="border border-gray-700 px-4 py-2 text-center">Jumlah Artikel</th>
                <th class="border border-gray-700 px-4 py-2 text-center">Aksi</th> <!-- Center header -->
            </tr>
        </thead>
        <tbody>
            @foreach ($savedArticles->groupBy('user_id') as $userId => $userArticles)
                @php $user = $userArticles->first()->user; @endphp
                <tr class="hover:bg-gray-800">
                    <td class="border border-gray-700 px-4 py-2">{{ $user->name }}</td>
                    <td class="border border-gray-700 px-4 py-2">{{ $user->username }}</td>
                    <td class="border border-gray-700 px-4 py-2">{{ $user->email }}</td>
                    <td class="border border-gray-700 px-4 py-2 text-center">{{ count($userArticles) }}</td>
                    <td class="border border-gray-700 px-4 py-2 text-center">
                        <a href="{{ route('admin.saved_articles.user', $user->id) }}"
                           class="inline-flex items-center justify-center bg-blue-600 text-white font-semibold p-2 rounded"
                           title="Kelola Artikel">
                            <!-- Icon edit (pensil) SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5m-7-7l6 6m0 0l-6 6m6-6H9" />
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        <a href="{{ route('admin.dashboard') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded inline-block">
           Kembali ke Dashboard
        </a>
    </div>
@endsection
