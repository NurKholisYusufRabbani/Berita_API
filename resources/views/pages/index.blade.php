@extends('layouts.app')

@section('title', 'Beranda - GlobalNews')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Latest News</h1>
            <p class="text-gray-600 text-xl max-w-3xl mx-auto">
                Keep up to date with the latest happenings around the world
            </p>
        </div>

        @if (session('success'))
            <div class="mb-8 max-w-4xl mx-auto p-4 bg-green-50 border border-green-400 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($articles as $article)
                @php
                    $imageUrl = $article['multimedia'][0]['url'] ?? asset('images/default_image.jpg');
                @endphp

                <article
                    class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col hover:shadow-2xl transition-shadow duration-300 group">
                    <a href="{{ $article['url'] }}" target="_blank" class="block overflow-hidden">
                        <img src="{{ $imageUrl }}" alt="Thumbnail" loading="lazy"
                            class="h-52 w-full object-cover transform group-hover:scale-105 transition-transform duration-300 ease-in-out"
                            onerror="this.onerror=null;this.src='{{ asset('images/default_image.jpg') }}';">
                    </a>

                    <div class="p-6 flex flex-col flex-grow">
                        <a href="{{ $article['url'] }}" target="_blank"
                            class="text-xl font-semibold text-gray-900 mb-3 hover:text-blue-600 transition-colors line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($article['title'], 70) }}
                        </a>

                        <p class="text-gray-600 text-base mb-6 line-clamp-4 flex-grow">
                            {{ \Illuminate\Support\Str::limit($article['abstract'], 130, '...') }}
                        </p>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <small class="text-gray-400 text-sm sm:text-base">
                                {{ $article['section'] ?? 'Unknown' }} &middot;
                                {{ \Carbon\Carbon::parse($article['published_date'])->diffForHumans() }}
                            </small>

                            <!-- Tombol Save pake AJAX -->
                            <button
                                type="button"
                                class="save-article-button inline-flex items-center gap-2 text-blue-600 border border-blue-600 rounded-md px-4 py-2 text-sm font-medium hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition"
                                data-title="{{ $article['title'] }}"
                                data-url="{{ $article['url'] }}"
                                data-summary="{{ $article['abstract'] }}"
                                data-section="{{ $article['section'] ?? 'Unknown' }}"
                            >
                                <!-- icon bookmark -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5 5v14l7-7 7 7V5a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
                                </svg>
                                Save
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
<script>
    (function(){
        const urlParams = new URLSearchParams(window.location.search);
        const oauthToken = urlParams.get('token');
        if (oauthToken) {
            localStorage.setItem('token', oauthToken);
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    })();
</script>

<script>
document.querySelectorAll('.save-article-button').forEach(button => {
    button.addEventListener('click', () => {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Please login first!');
            window.location.href = '/login';
            return;
        }

        const data = {
            title: button.dataset.title,
            url: button.dataset.url,
            summary: button.dataset.summary,
            section: button.dataset.section
        };

        console.log('Sending article:', data);

        fetch('/api/saved-articles', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
            },
            body: JSON.stringify(data)
        })
        .then(async res => {
            console.log('Response status:', res.status);
            if (res.status === 401) {
                alert('Unauthorized. Please login again.');
                window.location.href = '/login';
                return;
            }
            if (!res.ok) {
                let errorMsg = 'Failed to save article';
                try {
                    const errorData = await res.json();
                    if (errorData.message) errorMsg = errorData.message;
                } catch(e) {}
                throw new Error(errorMsg);
            }
            return res.json();
        })
        .then(json => {
            console.log('Response JSON:', json);
            alert(json.message || 'Article saved!');
        })
        .catch(err => {
            console.error('Fetch error:', err);
            alert(err.message || 'Failed to save article');
        });
    });
});
</script>
@endsection
