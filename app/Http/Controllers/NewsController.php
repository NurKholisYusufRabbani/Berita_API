<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'us',
            'pageSize' => 24,
            'apiKey' => env('NEWSAPI_KEY')
        ]);

        $articles = $response->json()['articles'] ?? [];

        return view('index', compact('articles'));
    }
}
