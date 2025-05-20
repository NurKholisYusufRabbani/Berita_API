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
        $validated = $request->validate([
            'title' => 'required|string',
            'url' => 'required|url',
            'summary' => 'nullable|string',
            'section' => 'nullable|string',
        ]);

        $user = auth('api')->user();

        $article = new SavedArticle();
        $article->user_id = $user->id;
        $article->title = $validated['title'];
        $article->url = $validated['url'];
        $article->summary = $validated['summary'] ?? null;
        $article->section = $validated['section'] ?? null;
        $article->save();

        return response()->json(['message' => 'Article saved successfully']);
    }

    public function destroy($id)
    {
        $article = SavedArticle::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $article->delete();
        return response()->json(['message' => 'Deleted']);
    }
}