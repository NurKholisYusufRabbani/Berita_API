@extends('layouts.admin')

@section('content')
    <h2 class="text-center text-gray-500 text-base mb-6">
        Detail Diskusi: {{ $discussion->title }}
    </h2>

    @foreach ($discussion->comments as $comment)
    <div class="border border-gray-800 rounded p-4 mb-4 bg-gray-900">
        <div class="relative bg-gray-900 text-white rounded p-4 mb-6" style="border-left: 3px solid #374151; padding-left: 1.5rem;">
            <div class="absolute left-0 top-5 w-3 h-0.5 bg-gray-600"></div>
            <strong class="block mb-2 text-gray-300">Komentar oleh {{ $comment->user->name }}:</strong>
            <p class="mb-3 text-gray-200">{{ $comment->content }}</p>

            <form action="{{ route('admin.comments.delete', $comment->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Hapus komentar ini?')" 
                        class="bg-red-700 hover:bg-red-800 text-white px-3 py-1 rounded text-sm">
                    Hapus Komentar
                </button>
            </form>

            @if ($comment->replies->count())
                <div class="mt-6 pl-8 border-l-4 border-gray-700 relative">
                    @foreach ($comment->replies as $reply)
                        <div class="relative mb-4 pl-6" style="border-left: 3px solid #4b5563;">
                            <div class="absolute left-0 top-4 w-3 h-0.5 bg-gray-500"></div>
                            <p class="text-gray-300">
                                <strong>{{ $reply->user->name }}:</strong> {{ $reply->content }}
                            </p>
                            <form action="{{ route('admin.replies.delete', $reply->id) }}" method="POST" class="inline mt-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Hapus balasan ini?')" 
                                        class="bg-red-700 hover:bg-red-800 text-white px-2 py-1 rounded text-xs">
                                    Hapus Balasan
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        </div>
    @endforeach

    <a href="{{ route('admin.discussions.index') }}" 
       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded inline-block">
        Kembali ke daftar diskusi
    </a>
@endsection
