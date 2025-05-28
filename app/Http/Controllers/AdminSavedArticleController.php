<?php

namespace App\Http\Controllers;

use App\Models\SavedArticle;
use Illuminate\Http\Request;

class AdminSavedArticleController extends Controller
{
    public function index()
    {
        $savedArticles = SavedArticle::with('user')->latest()->get();
        return view('admin.saved_articles.index', compact('savedArticles'));
    }

    public function userArticles($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $articles = $user->savedArticles()->latest()->get();

        return view('admin.saved_articles.user_articles', compact('user', 'articles'));
    }


    public function show($id)
    {
        $article = SavedArticle::with('user')->findOrFail($id);
        return view('admin.saved_articles.show', compact('article'));
    }

    public function destroy($id)
    {
        $article = SavedArticle::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.saved_articles.index')->with('success', 'Artikel berhasil dihapus');
    }
}
