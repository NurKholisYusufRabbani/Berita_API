<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'content' => 'required',
        ]);

        return Reply::create([
            'comment_id' => $request->comment_id,
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
