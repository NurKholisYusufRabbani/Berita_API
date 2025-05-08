<?php

namespace App\Http\Controllers;

use App\Models\SavedArticle;
use Illuminate\Http\Request;

class SavedArticleController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan artikel yang disimpan oleh user yang sedang login
        $savedArticles = $request->user()->savedArticles; 
        return response()->json($savedArticles);
    }

    public function store(Request $request)
    {
        // Validasi input artikel
        $request->validate([
            'title' => 'required|string',
            'url' => 'required|url',
            'description' => 'nullable|string',
            'urlToImage' => 'nullable|url',
        ]);

        // Menyimpan artikel baru yang disimpan oleh user
        $savedArticle = $request->user()->savedArticles()->create([
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'urlToImage' => $request->urlToImage,
        ]);

        return response()->json($savedArticle, 201);  // Response dengan artikel yang baru disimpan
    }

    public function destroy(Request $request, $id)
    {
        // Menghapus artikel berdasarkan ID dari daftar yang disimpan oleh user
        $savedArticle = $request->user()->savedArticles()->find($id);

        if (!$savedArticle) {
            return response()->json(['message' => 'Artikel tidak ditemukan'], 404);
        }

        $savedArticle->delete();
        return response()->json(['message' => 'Artikel berhasil dihapus']);
    }
}
