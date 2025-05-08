<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portal Berita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1a73e8;
            color: #fff;
            text-align: center;
            padding: 2rem 1rem;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        header p {
            margin: 0.5rem 0 0;
            font-size: 1.1rem;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            padding: 2rem;
        }

        .article {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            padding: 1.5rem;
            transition: transform 0.2s ease;
        }

        .article:hover {
            transform: scale(1.01);
        }

        .article h2 {
            margin-top: 0;
            font-size: 1.5rem;
        }

        .article a {
            text-decoration: none;
            color: #1a73e8;
        }

        .article a:hover {
            text-decoration: underline;
        }

        .article img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 6px;
            margin: 1rem 0;
        }

        .meta {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 1rem;
        }

        .description {
            font-size: 1rem;
            color: #333;
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 1rem;
            }

            .article h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>News Portal</h1>
        <p>Updated international news collection</p>
    </header>

    <div class="container">
        @foreach ($articles as $article)
            <div class="article">
                <h2>
                    <a href="{{ $article['url'] }}" target="_blank" rel="noopener noreferrer">
                        {{ $article['title'] }}
                    </a>
                </h2>

                @if (!empty($article['urlToImage']))
                    <img src="{{ $article['urlToImage'] }}" alt="Gambar Berita">
                @endif

                <div class="meta">
                    Sumber: {{ $article['source']['name'] ?? 'Tidak diketahui' }} |
                    Tanggal: {{ \Carbon\Carbon::parse($article['publishedAt'])->format('d M Y H:i') }}
                </div>

                <p class="description">
                    {{ $article['description'] ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>
        @endforeach
    </div>
</body>
</html>
