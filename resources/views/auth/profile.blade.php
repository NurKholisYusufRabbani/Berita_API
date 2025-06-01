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
    <a href="{{ url('/') }}" class="absolute top-4 left-4 flex items-center text-gray-400 hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="text-sm font-medium">Kembali</span>
    </a>

    <div class="max-w-md w-full bg-gray-800 rounded-[32px] shadow-xl p-8 text-white relative overflow-hidden">

        <h2 class="text-center text-gray-500 text-xl mb-6">Profil Pengguna</h2>

        <div id="profileSection" class="mb-6 flex flex-col items-center">
            <img id="profileImage" class="w-28 h-28 rounded-full mb-4 border-4 border-gray-700 object-cover shadow-lg"
                src="" alt="Foto Profil" />
            <p class="text-base mb-1 text-gray-200">
                <strong>Nama:</strong> <span id="profileName" class="text-gray-100 font-medium"></span>
            </p>
            <p class="text-base text-gray-200">
                <strong>Email:</strong> <span id="profileEmail" class="text-gray-100 font-medium"></span>
            </p>
        </div>

        <form id="uploadForm" enctype="multipart/form-data" class="mb-6">
            <label for="photo" class="block mb-2 text-xs text-gray-400">Upload Foto Baru</label>
            <input id="photo" type="file" name="photo" accept="image/*" required
                class="block w-full text-sm text-white border border-gray-600 rounded-md bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 
           file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white 
           hover:file:bg-blue-700" />

            <button type="submit"
                class="mt-4 w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-xl text-white font-semibold transition duration-200">
                Upload
            </button>
        </form>

        <button onclick="deletePhoto()"
            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded-xl text-white font-semibold transition duration-200">
            Hapus Foto
        </button>
    </div>

    <script>
        feather.replace();
    </script>


    <script>
        (() => {
            const token = localStorage.getItem('token');
            if (!token) {
                alert('Anda belum login, silakan login terlebih dahulu.');
                window.location.href = '/login';
                return;
            }

            fetch('/api/me', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                    },
                })
                .then(res => {
                    if (!res.ok) {
                        if (res.status === 401) {
                            alert('Token sudah kadaluarsa atau tidak valid, silakan login ulang.');
                            window.location.href = '/login';
                        }
                        throw new Error('Gagal mengambil data profil.');
                    }
                    return res.json();
                })
                .then(user => {
                    document.getElementById('profileName').textContent = user.name;
                    document.getElementById('profileEmail').textContent = user.email;
                    document.getElementById('profileImage').src = user.profile_photo ?
                        `/storage/${user.profile_photo}` :
                        `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=374151&color=fff&size=128`;
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('profileSection').innerHTML = `
                <div class="bg-red-100 text-red-700 p-4 rounded">
                    Gagal memuat data profil. Pastikan Anda sudah login dan token valid.
                </div>
            `;
                });

            document.getElementById('uploadForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);

                try {
                    const res = await fetch('/api/profile/photo', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                        },
                        body: formData,
                    });

                    if (res.ok) {
                        alert('Foto berhasil diunggah');
                        location.reload();
                    } else {
                        const err = await res.json();
                        alert(err.message || 'Gagal upload foto');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan saat upload foto');
                    console.error(error);
                }
            });

            window.deletePhoto = async () => {
                if (!confirm('Yakin ingin menghapus foto profil?')) return;

                try {
                    const res = await fetch('/api/profile/photo', {
                        method: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json',
                        },
                    });

                    if (res.ok) {
                        alert('Foto berhasil dihapus');
                        location.reload();
                    } else {
                        const err = await res.json();
                        alert(err.message || 'Gagal menghapus foto');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan saat menghapus foto');
                    console.error(error);
                }
            }
        })();
    </script>
</body>

</html>
