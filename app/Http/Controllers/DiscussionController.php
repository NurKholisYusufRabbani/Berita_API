<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    // Tampilkan semua diskusi milik user
    public function index()
    {
        $discussions = Discussion::with(['user', 'savedArticle'])->latest()->get();
        return response()->json($discussions);
    }

    // Simpan diskusi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'saved_article_id' => 'required|exists:saved_articles,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $discussion = Auth::user()->discussions()->create($validated);

        return response()->json($discussion, 201);
    }

    // Tampilkan satu diskusi
    public function show(Discussion $discussion)
    {
        return response()->json($discussion->load(['user', 'savedArticle']));
    }

    // Hapus diskusi (dengan cek user)
    public function destroy(Discussion $discussion)
    {
        if ($discussion->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $discussion->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
