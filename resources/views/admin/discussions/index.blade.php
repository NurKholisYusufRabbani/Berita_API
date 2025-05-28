@extends('layouts.admin')

@section('content')
    <h2 class="text-center text-gray-500 text-base mb-6">
        Daftar Diskusi
    </h2>

    <table class="w-full border border-gray-700 rounded-lg overflow-hidden shadow-sm text-white">
        <thead class="bg-gray-800 text-gray-400">
            <tr>
                <th class="px-4 py-2 border-b border-gray-700 text-left">Judul Diskusi</th>
                <th class="px-4 py-2 border-b border-gray-700 text-center">Jumlah Komentar</th>
                <th class="px-4 py-2 border-b border-gray-700 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($discussions as $discussion)
                <tr class="hover:bg-gray-700">
                    <td class="px-4 py-3 border-b border-gray-700">
                        {{ $discussion->title ?? 'Tidak ada judul' }}
                    </td>
                    <td class="px-4 py-3 border-b border-gray-700 text-center">
                        {{ $discussion->comments()->count() }}
                    </td>
                    <td class="px-4 py-3 border-b border-gray-700">
                        <a href="{{ route('admin.discussions.show', $discussion->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                            Kelola
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-400">Belum ada diskusi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('admin.dashboard') }}" 
       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded inline-block mt-6 text-center">
        Kembali ke Dashboard
    </a>
@endsection
