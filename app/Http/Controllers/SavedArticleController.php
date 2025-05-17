<?php

namespace App\Http\Controllers;

use App\Models\SavedArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedArticleController extends Controller
{
    public function index()
    {
        return SavedArticle::where('user_id', Auth::id())->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required|url',
        ]);

        SavedArticle::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'url' => $request->url,
            'summary' => $request->summary,
            'section' => $request->section,
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil disimpan!');
    }

    public function destroy($id)
    {
        $article = SavedArticle::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $article->delete();
        return response()->json(['message' => 'Deleted']);
    }
}