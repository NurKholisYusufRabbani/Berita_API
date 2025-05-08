<?php

namespace App\Http\Controllers;

use App\Models\SavedArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedArticleController extends Controller
{
    // Tampilkan semua artikel yang disimpan oleh user yang sedang login
    public function index()
    {
        $articles = Auth::user()->savedArticles()->latest()->get();
        return response()->json($articles);
    }

    // Simpan artikel baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'url' => 'required|url',
            'urlToImage' => 'nullable|url',
            'source' => 'required|string',
            'published_at' => 'required|date',
        ]);

        $article = Auth::user()->savedArticles()->create($validated);

        return response()->json($article, 201);
    }

    // Tampilkan satu artikel
    public function show(SavedArticle $savedArticle)
    {
        $this->authorizeUser($savedArticle);

        return response()->json($savedArticle);
    }

    // Hapus artikel
    public function destroy(SavedArticle $savedArticle)
    {
        $this->authorizeUser($savedArticle);

        $savedArticle->delete();

        return response()->json(['message' => 'Deleted']);
    }

    // Optional: middleware auth dan pengecekan user
    protected function authorizeUser(SavedArticle $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }
}
