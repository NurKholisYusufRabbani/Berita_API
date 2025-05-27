<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Portal Berita Dunia')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Font Awesome untuk ikon WhatsApp -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
      /* Custom font fallback mirip 'Segoe UI' */
      body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    @include('partials.navbar')

    <main class="container mx-auto px-4 py-8 pt-20 flex-grow">
        @yield('content')
        @yield('scripts')
    </main>

    <footer class="bg-gray-900 text-gray-400 py-8 mt-8">
        <div class="container mx-auto px-4 text-center">
            @include('partials.footer')
        </div>
    </footer>

</body>

</html>
