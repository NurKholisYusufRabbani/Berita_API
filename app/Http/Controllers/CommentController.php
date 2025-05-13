<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'discussion_id' => 'required|exists:discussions,id',
            'content' => 'required',
        ]);

        return Comment::create([
            'discussion_id' => $request->discussion_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}
