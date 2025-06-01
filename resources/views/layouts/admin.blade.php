<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-900 text-white min-h-screen font-sans antialiased">

    <!-- Header Nav -->
<header class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}">
            <h1 class="text-lg font-semibold text-red-500">Dashboard Admin</h1>
        </a>

        <!-- Dropdown user profile -->
        <div x-data="{ open: false }" class="relative inline-block text-left">
            <button @click="open = !open" type="button"
                class="inline-flex justify-center items-center w-full rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-sm font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                id="menu-button" aria-expanded="true" aria-haspopup="true">
                {{ auth()->user()->name }}
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown panel -->
            <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                style="display: none;">
                <div class="py-3 px-4 text-sm border-b border-gray-700">
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                    <p class="truncate text-gray-400">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="px-4 py-2">
                    @csrf
                    <button type="submit"
                        class="w-full text-left text-red-500 hover:text-red-600 font-semibold focus:outline-none">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-gray-500 text-xs py-4 border-t border-gray-700">
        &copy; {{ date('Y') }} Sistem Admin.
    </footer>

</body>
</html>
