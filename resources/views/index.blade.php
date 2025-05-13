@extends('layouts.app')

@section('title', 'Beranda - GlobalNews')

@section('content')
    <div class="text-center mb-5">
        <h1 class="fw-bold">Latest News</h1>
        <p class="text-muted">Keep up to date with the latest happenings around the world</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($articles as $article)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    @if(isset($article['multimedia'][0]['url']) && !empty($article['multimedia'][0]['url']))
                        @php
                            $imageUrl = $article['multimedia'][0]['url'];  // Gunakan URL yang sudah lengkap
                        @endphp
                        <img src="{{ $imageUrl }}" class="card-img-top rounded-top" alt="Thumbnail" onerror="this.onerror=null;this.src='{{ asset('images/default_image.jpg') }}';">
                    @else
                        <img src="{{ asset('images/default_image.jpg') }}" class="card-img-top rounded-top" alt="Default Thumbnail">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2" style="font-size: 1rem;">
                            <a href="{{ $article['url'] }}" target="_blank" class="text-decoration-none text-dark">
                                {{ Str::limit($article['title'], 70) }}
                            </a>
                        </h5>
                        <p class="card-text text-muted" style="font-size: 0.9rem;">
                            {{ Str::limit($article['abstract'], 100, '...') }}
                        </p>
                        <div class="mt-auto">
                            <small class="text-secondary">
                                {{ $article['section'] ?? 'Tidak diketahui' }} ·
                                {{ \Carbon\Carbon::parse($article['published_date'])->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
