<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function Home()
    {
        // Mengambil data dari API NYT Top Stories dengan api-key
        $response = Http::get('https://api.nytimes.com/svc/topstories/v2/home.json', [
            'api-key' => env('NYT_KEY')
        ]);

        // Mengambil artikel dari respons API
        $articles = $response->json()['results'] ?? [];

        return view('index', compact('articles'));
    }

    public function category($category)
    {
    // Panggil API NYT Top Stories berdasarkan kategori
    $response = Http::get("https://api.nytimes.com/svc/topstories/v2/{$category}.json", [
        'api-key' => env('NYT_KEY')
    ]);

    $articles = $response->json()['results'] ?? [];

    return view('category', compact('articles', 'category'));
    }
}
