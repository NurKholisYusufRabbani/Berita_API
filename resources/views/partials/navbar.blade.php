<nav class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 dark:bg-gray-900 z-[9999] shadow-md">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Global News</span>
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse" id="userProfile">
            <!-- Isi dinamis lewat JS -->
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li><a href="{{ url('/') }}" class="block py-2 px-3 text-gray-900 dark:text-white md:p-0"
                        aria-current="page">Home</a></li>
                <li><a href="{{ url('/home/health') }}"
                        class="block py-2 px-3 text-gray-900 dark:text-white md:p-0">Health</a></li>
                <li><a href="{{ url('/home/movies') }}"
                        class="block py-2 px-3 text-gray-900 dark:text-white md:p-0">Movies</a></li>
                <li><a href="{{ url('/home/food') }}"
                        class="block py-2 px-3 text-gray-900 dark:text-white md:p-0">Food</a></li>
                <li><a href="{{ url('/home/fashion') }}"
                        class="block py-2 px-3 text-gray-900 dark:text-white md:p-0">Fashion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Template dropdown menu -->
<div id="userDropdownTemplate" class="hidden">
    <div class="relative">
        <button type="button"
            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            id="user-menu-button" aria-expanded="false">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="User photo">
        </button>
        <div class="absolute right-0 z-50 mt-2 w-48 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 hidden"
            id="user-dropdown">
            <div class="px-4 py-3">
                <span id="dropdown-name" class="block text-sm text-gray-900 dark:text-white">User Name</span>
                <span id="dropdown-email"
                    class="block text-sm text-gray-500 truncate dark:text-gray-400">email@example.com</span>
            </div>
            <ul class="py-2" aria-labelledby="user-menu-button">
                <li><a href="/dashboard"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                </li>
                <li><a href="/settings"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                </li>
                <li><a href="#" onclick="logout()"
                        class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600 dark:hover:text-white">Sign
                        out</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
    async function checkAuthAndRenderProfile() {
        const token = localStorage.getItem('token');
        const profileContainer = document.getElementById('userProfile');

        if (!token) {
            profileContainer.innerHTML = `<a href="/login" class="bg-white text-gray-800 px-3 py-1 rounded shadow hover:underline">Login</a>
`;
            return;
        }

        try {
            const res = await fetch('/api/me', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            if (!res.ok) throw new Error('Unauthorized');

            const user = await res.json();

            // Clone template and inject data
            const template = document.getElementById('userDropdownTemplate').cloneNode(true);
            template.id = "";
            template.classList.remove('hidden');
            template.querySelector('#dropdown-name').textContent = user.name;
            template.querySelector('#dropdown-email').textContent = user.email;

            const dropdownBtn = template.querySelector('#user-menu-button');
            const dropdownMenu = template.querySelector('#user-dropdown');

            dropdownBtn.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
            });

            profileContainer.innerHTML = "";
            profileContainer.appendChild(template.firstElementChild);
        } catch (err) {
            console.error(err);
            profileContainer.innerHTML = `<a href="/login" class="bg-white text-gray-800 px-3 py-1 rounded shadow hover:underline">Login</a>
`;
        }
    }

    function logout() {
        localStorage.removeItem('token');
        window.location.href = '/login';
    }

    checkAuthAndRenderProfile();
</script>
