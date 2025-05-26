<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function index()
    {
        // Ambil data dari NYT API untuk halaman utama
        $response = Http::get('https://api.nytimes.com/svc/topstories/v2/home.json', [
            'api-key' => env('NYT_KEY')
        ]);

        $articles = $response->json()['results'] ?? [];

         

        return view('pages.index', compact('articles'));
        

    }

    public function category($category)
    {
        $response = Http::get("https://api.nytimes.com/svc/topstories/v2/{$category}.json", [
            'api-key' => env('NYT_KEY')
        ]);

        $articles = $response->json()['results'] ?? [];

        return view('pages.category', compact('articles', 'category'));
    }
}
