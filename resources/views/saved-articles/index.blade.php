@extends('layouts.app')

@section('title', 'Saved Articles - GlobalNews')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <h1 class="text-4xl font-bold mb-8 text-center">Saved Articles</h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    @if($savedArticles->isEmpty())
        <p class="text-center text-gray-600">You have no saved articles yet.</p>
    @else
        <div class="space-y-6">
            @foreach($savedArticles as $article)
                <article class="flex bg-white rounded-lg shadow p-4 gap-4 items-center hover:shadow-lg transition">
                    <img src="{{ $article->image_url ?? asset('images/default_image.jpg') }}"
                         alt="Article Thumbnail"
                         class="w-32 h-20 object-cover rounded-md flex-shrink-0">

                    <div class="flex flex-col flex-grow">
                        <a href="{{ $article->url }}" target="_blank" class="text-xl font-semibold text-blue-700 hover:underline line-clamp-2">
                            {{ $article->title }}
                        </a>

                        <p class="text-gray-700 mt-1 line-clamp-3">{{ $article->summary }}</p>

                        <small class="text-gray-500 mt-2">{{ $article->section }} &middot; {{ $article->created_at->diffForHumans() }}</small>
                    </div>

                    <form action="{{ route('saved-articles.destroy', $article->id) }}" method="POST" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-600 hover:text-red-800 font-semibold px-3 py-1 border border-red-600 rounded hover:bg-red-600 hover:text-white transition"
                            onclick="return confirm('Are you sure you want to remove this article?')">
                            Remove
                        </button>
                    </form>
                </article>
            @endforeach
        </div>
    @endif

    {{-- Forum Section --}}
    <section class="mt-16">
        <h2 class="text-3xl font-bold mb-6">Forum Discussions</h2>

        {{-- List discussions --}}
        @if($discussions->isEmpty())
            <p class="text-gray-600">No discussions yet. Be the first to start one!</p>
        @else
            <div class="space-y-8">
                @foreach($discussions as $discussion)
                    <div class="border border-gray-300 rounded p-4 shadow-sm bg-white">
                        <h3 class="text-xl font-semibold mb-2">{{ $discussion->title }}</h3>
                        <p class="text-gray-700 mb-4">{{ $discussion->content }}</p>
                        <small class="text-gray-400">Started by {{ $discussion->user->name }} &middot; {{ $discussion->created_at->diffForHumans() }}</small>

                        {{-- Comments --}}
                        <div class="mt-4 pl-6 border-l border-gray-200 space-y-4">
                            @foreach($discussion->comments as $comment)
                                <div>
                                    <p class="text-gray-800"><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                                    <small class="text-gray-400">{{ $comment->created_at->diffForHumans() }}</small>

                                    {{-- Replies --}}
                                    <div class="mt-2 ml-6 pl-4 border-l border-gray-300 space-y-2">
                                        @foreach($comment->replies as $reply)
                                            <p class="text-gray-700"><strong>{{ $reply->user->name }}:</strong> {{ $reply->content }}</p>
                                            <small class="text-gray-400">{{ $reply->created_at->diffForHumans() }}</small>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
