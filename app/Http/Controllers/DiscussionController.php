<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $savedArticles = $user->savedArticles()->latest()->get();

        // Contoh ambil discussions yang relevan (atau semua)
        $discussions = Discussion::with(['user', 'comments.user', 'comments.replies.user'])->latest()->get();

        return view('saved-articles', compact('savedArticles', 'discussions'));
    }

    public function show($id)
    {
        return Discussion::with('comments.replies')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'saved_article_id' => 'required|exists:saved_articles,id',
        ]);

        return Discussion::create([
            'saved_article_id' => $request->saved_article_id,
            'title' => $request->title,
        ]);
    }
}
