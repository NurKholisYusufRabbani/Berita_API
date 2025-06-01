<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons CDN (untuk ikon back) -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-900 min-h-screen flex items-center justify-center px-4 relative">

    <!-- Tombol Back -->
    <a href="{{ url('/') }}"
        class="absolute top-4 left-4 flex items-center text-gray-400 hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="text-sm font-medium">Kembali</span>
    </a>

    <div class="max-w-md w-full mx-auto mt-20 p-8 bg-gray-800 text-white rounded-[32px] shadow-xl">
        <h2 class="text-center text-gray-500 text-xl mb-6">Pengaturan Akun</h2>

        <form id="settingsForm">
            <div class="mb-4">
                <label for="name" class="block text-sm text-gray-300 mb-1">Nama</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="mb-4">
                <label for="username" class="block text-sm text-gray-300 mb-1">Username</label>
                <input type="text" id="username" name="username" required
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm text-gray-300 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm text-gray-300 mb-1">Password Baru (opsional)</label>
                <input type="password" id="password" name="password" placeholder="Password baru"
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm text-gray-300 mb-1">Konfirmasi Password
                    Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Konfirmasi password baru"
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl transition duration-200">
                Simpan Perubahan
            </button>
        </form>
    </div>


    <script>
        (() => {
            const token = localStorage.getItem('token');
            if (!token) {
                alert('Anda belum login, silakan login terlebih dahulu.');
                window.location.href = '/login';
                return;
            }

            // Ambil data user dari API
            fetch('/api/me', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                    }
                })
                .then(res => {
                    if (!res.ok) {
                        if (res.status === 401) {
                            alert('Token tidak valid atau sudah kadaluarsa, silakan login ulang.');
                            window.location.href = '/login';
                        }
                        throw new Error('Gagal mengambil data user.');
                    }
                    return res.json();
                })
                .then(user => {
                    document.getElementById('name').value = user.name || '';
                    document.getElementById('username').value = user.username || '';
                    document.getElementById('email').value = user.email || '';
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal memuat data user.');
                });

            // Submit form update data
            document.getElementById('settingsForm').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = {
                    name: document.getElementById('name').value.trim(),
                    username: document.getElementById('username').value.trim(),
                    email: document.getElementById('email').value.trim(),
                    password: document.getElementById('password').value,
                    password_confirmation: document.getElementById('password_confirmation').value,
                };

                try {
                    const res = await fetch('/api/settings', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer ' + token,
                        },
                        body: JSON.stringify(formData),
                    });

                    if (res.ok) {
                        alert('Data berhasil diperbarui.');
                        window.location.href = "{{ url('/') }}"; // Redirect ke halaman utama
                    } else {
                        const err = await res.json();
                        alert(err.message || 'Gagal memperbarui data.');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan saat memperbarui data.');
                    console.error(error);
                }
            });

        })();
    </script>
</body>

</html>
