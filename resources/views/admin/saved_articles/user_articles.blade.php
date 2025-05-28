@extends('layouts.admin')

@section('content')
    <h2 class="text-center text-gray-500 text-base mb-6">
        Artikel Disimpan oleh {{ $user->name }}
    </h2>

    <table class="w-full border border-gray-700 rounded-lg overflow-hidden shadow-sm text-white">
        <thead class="bg-gray-800 text-gray-400">
            <tr>
                <th class="px-4 py-2 border-b border-gray-700 text-left">Judul</th>
                <th class="px-4 py-2 border-b border-gray-700 text-left">Seksi</th>
                <th class="px-4 py-2 border-b border-gray-700 text-left">Ringkasan</th>
                <th class="px-4 py-2 border-b border-gray-700 text-left">Link</th>
                <th class="px-4 py-2 border-b border-gray-700 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr class="hover:bg-gray-700">
                    <td class="px-4 py-3 border-b border-gray-700">{{ $article->title }}</td>
                    <td class="px-4 py-3 border-b border-gray-700">{{ $article->section }}</td>
                    <td class="px-4 py-3 border-b border-gray-700">
                        {{ \Illuminate\Support\Str::limit($article->summary, 50) }}
                    </td>
                    <td class="px-4 py-3 border-b border-gray-700">
                        <a href="{{ $article->url }}" target="_blank" 
                           class="text-red-500 hover:text-red-400" 
                           aria-label="Lihat Artikel">
                            <!-- Icon Eye (Lihat) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                    </td>
                    <td class="px-4 py-3 border-b border-gray-700 space-x-2">
                        <form action="{{ route('admin.saved_articles.destroy', $article->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Hapus artikel ini?')" 
                                    class="bg-red-700 hover:bg-red-800 text-white px-3 py-1 rounded text-sm flex items-center"
                                    aria-label="Hapus Artikel">
                                <!-- Icon Trash (Hapus) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


        <div class="mt-6">
        <a href="{{ route('admin.saved_articles.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded inline-block">
           Kembali ke daftar artikel pengguna
        </a>
    </div>
@endsection
