<?php

namespace App\Http\Controllers;

use App\Models\SavedArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedArticleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $articles = $user->savedArticles;
        return response()->json($articles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'url' => 'required|url',
            'summary' => 'nullable|string',
            'section' => 'nullable|string',
        ]);

        $user = auth('api')->user();

        // Generate token dari URL (bisa pakai base64, hash, atau custom encode)
        $token = substr(base64_encode($validated['url']), 0, 100); // max 100 char

        // Cek apakah user sudah pernah simpan artikel dengan token yang sama
        $existing = SavedArticle::where('user_id', $user->id)
            ->where('article_token', $token)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Artikel sudah disimpan'], 409);
        }

        // Simpan artikel baru
        $article = new SavedArticle();
        $article->user_id = $user->id;
        $article->title = $validated['title'];
        $article->url = $validated['url'];
        $article->summary = $validated['summary'] ?? null;
        $article->section = $validated['section'] ?? null;
        $article->article_token = $token;
        $article->save();

        return response()->json([
            'message' => 'Article saved successfully',
            'article_token' => $token
        ]);
    }

    public function destroy($id)
    {
        $article = SavedArticle::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $article->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function findByToken($token)
    {
        $article = SavedArticle::where('article_token', $token)->firstOrFail();
        return response()->json($article);
    }
}
