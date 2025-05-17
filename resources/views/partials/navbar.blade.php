<nav class="bg-gray-900 text-white">
  <div class="container mx-auto px-4 flex items-center justify-between py-4">
    <a href="/" class="font-bold text-xl">Global News</a>

    <button id="navbar-toggle" class="md:hidden focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
          d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>

    <div id="navbarContent" class="hidden md:flex space-x-6">
      <a href="/" class="hover:text-blue-400">Home</a>
      <a href="/home/health" class="hover:text-blue-400">Health</a>
      <a href="/home/movies" class="hover:text-blue-400">Movies</a>
      <a href="/home/food" class="hover:text-blue-400">Food</a>
      <a href="/home/fashion" class="hover:text-blue-400">Fashion</a>
      <div id="userProfile" class="ml-4"></div>
    </div>
  </div>
</nav>

<script>
  document.getElementById('navbar-toggle').addEventListener('click', function () {
    document.getElementById('navbarContent').classList.toggle('hidden');
  });

  async function checkAuthAndRenderProfile() {
    const token = localStorage.getItem('token');
    const profileDiv = document.getElementById('userProfile');

    if (!token) {
      profileDiv.innerHTML = `<a href="/login" class="hover:text-blue-400">Login</a>`;
      return;
    }

    try {
      const response = await fetch('/api/me', {
        headers: {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json'
        }
      });

      if (!response.ok) throw new Error('Unauthorized');
      const user = await response.json();

      profileDiv.innerHTML = `
        <span class="text-sm">Hi, ${user.name}</span>
        <button onclick="logout()" class="ml-2 text-red-400 hover:underline">Logout</button>
      `;
    } catch (err) {
      profileDiv.innerHTML = `<a href="/login" class="hover:text-blue-400">Login</a>`;
    }
  }

  function logout() {
    localStorage.removeItem('token');
    window.location.href = '/login';
  }

  checkAuthAndRenderProfile();
</script>
