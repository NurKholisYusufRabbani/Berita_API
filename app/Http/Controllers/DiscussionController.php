<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
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
