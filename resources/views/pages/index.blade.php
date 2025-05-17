@extends('layouts.app')

@section('title', 'Beranda - GlobalNews')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Latest News</h1>
        <p class="text-gray-600 text-lg">Keep up to date with the latest happenings around the world</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded max-w-4xl mx-auto">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 max-w-7xl mx-auto px-4">
        @foreach ($articles as $article)
            <div class="bg-white rounded-lg shadow-md flex flex-col overflow-hidden hover:shadow-xl transition-shadow duration-300">
                @php
                    $imageUrl = $article['multimedia'][0]['url'] ?? null;
                @endphp
                <img 
                    src="{{ $imageUrl ?: asset('images/default_image.jpg') }}" 
                    alt="Thumbnail" 
                    class="h-48 w-full object-cover"
                    onerror="this.onerror=null;this.src='{{ asset('images/default_image.jpg') }}';"
                >
                <div class="p-4 flex flex-col flex-grow">
                    <h5 class="text-lg font-semibold mb-2 line-clamp-2">
                        <a href="{{ $article['url'] }}" target="_blank" class="text-gray-900 hover:text-blue-600 transition-colors">
                            {{ \Illuminate\Support\Str::limit($article['title'], 70) }}
                        </a>
                    </h5>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ \Illuminate\Support\Str::limit($article['abstract'], 100, '...') }}
                    </p>

                    <div class="mt-auto flex flex-col">
                        <small class="text-gray-500 mb-2">
                            {{ $article['section'] ?? 'Tidak diketahui' }} &middot; 
                            {{ \Carbon\Carbon::parse($article['published_date'])->diffForHumans() }}
                        </small>

                        
                        <form action="{{ url('/saved-articles') }}" method="POST" class="self-start">
                            @csrf
                            <input type="hidden" name="title" value="{{ $article['title'] }}">
                            <input type="hidden" name="url" value="{{ $article['url'] }}">
                            <input type="hidden" name="summary" value="{{ $article['abstract'] }}">
                            <input type="hidden" name="section" value="{{ $article['section'] ?? 'Unknown' }}">
                            <button type="submit" class="text-blue-600 border border-blue-600 px-3 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
