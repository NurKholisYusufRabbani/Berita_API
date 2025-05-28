<?php 

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\Request;

class AdminDiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::withCount('comments')->latest()->get();
        return view('admin.discussions.index', compact('discussions'));
    }

    public function show($id)
    {
        $discussion = Discussion::with(['comments.user', 'comments.replies.user'])->findOrFail($id);
        return view('admin.discussions.show', compact('discussion'));
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->replies()->delete();
        $comment->delete();

        return redirect()->back()->with('success', 'Komentar dan balasan berhasil dihapus.');
    }

    public function deleteReply($id)
    {
        $reply = Reply::findOrFail($id);
        $reply->delete();

        return redirect()->back()->with('success', 'Balasan berhasil dihapus.');
    }
}
