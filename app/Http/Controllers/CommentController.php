<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Discussion;
use App\Models\SavedArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Ambil komentar berdasarkan article_token
    public function index($token)
    {
        $article = SavedArticle::where('article_token', $token)->firstOrFail();

        $discussion = Discussion::where('article_token', $token)->first();
        if (!$discussion) {
            return response()->json([]);  // Atau bisa juga message kalau mau
        }

        $comments = Comment::where('discussion_id', $discussion->id)
            ->with('user')
            ->latest()
            ->get();

        return response()->json($comments);
    }

    // Simpan komentar baru berdasarkan article_token
    public function store(Request $request, $token)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        $article = SavedArticle::where('article_token', $token)->firstOrFail();

        // Cari atau buat diskusi berdasarkan article_token (bukan saved_article_id)
        $discussion = Discussion::firstOrCreate(
            ['article_token' => $token], // primary lookup
            [
                'saved_article_id' => $article->id,
                'title' => $article->title
            ]
        );

        $comment = Comment::create([
            'discussion_id' => $discussion->id,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        return response()->json($comment->load('user'), 201);
    }

    // Hapus komentar (jika milik user sendiri)
    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$comment) {
            return response()->json(['message' => 'Komentar tidak ditemukan atau bukan milik Anda'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Komentar berhasil dihapus']);
    }
}
