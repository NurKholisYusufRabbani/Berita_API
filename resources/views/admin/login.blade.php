<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 flex flex-col min-h-screen">

    <main class="flex-grow flex items-center justify-center">
        <div class="border border-gray-800 rounded p-4 mb-4 shadow-lg w-full max-w-md text-white">
            <h2 class="text-center text-gray-500 text-base mb-6">Login Admin</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-700 text-red-100 p-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block mb-1 font-small">Email:</label>
                    <input type="email" name="email" id="email" required
                           class="w-full rounded px-3 py-2 bg-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label for="password" class="block mb-1 font-medium">Password:</label>
                    <input type="password" name="password" id="password" required
                           class="w-full rounded px-3 py-2 bg-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 transition-colors font-semibold py-2 rounded">
                    Login
                </button>
            </form>
        </div>
    </main>

    <footer class="text-center text-gray-500 text-xs py-4 border-t border-gray-700">
        &copy; {{ date('Y') }} Sistem Admin.
    </footer>

</body>
</html>
