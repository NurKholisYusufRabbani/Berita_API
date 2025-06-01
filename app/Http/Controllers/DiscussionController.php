<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function index($token)
    {
        $discussions = Discussion::where('article_token', $token)->with('user')->get();
        return response()->json($discussions);
    }

    public function show($id)
    {
        return Discussion::with('comments.replies')->findOrFail($id);
    }

    public function store(Request $request, $token)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $discussion = new Discussion();
        $discussion->user_id = auth('api')->id();
        $discussion->article_token = $token;
        $discussion->content = $validated['content'];
        $discussion->save();

        return response()->json(['message' => 'Comment posted']);
    }
}