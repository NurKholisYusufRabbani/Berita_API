<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function index($commentId)
    {
        $replies = Reply::with('user')->where('comment_id', $commentId)->get();
        return response()->json($replies);
    }

    public function store(Request $request, $commentId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        return Reply::create([
            'comment_id' => $commentId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
    }

    public function destroy($id)
    {
        $reply = Reply::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $reply->delete();
        return response()->json(['message' => 'Reply deleted']);
    }
}
