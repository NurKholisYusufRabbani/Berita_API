@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-20 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Profil Pengguna</h2>
    <div id="profileSection" class="mb-4">
        <img id="profileImage" class="w-32 h-32 rounded-full mb-2" src="" alt="Foto Profil">
        <p><strong>Nama:</strong> <span id="profileName"></span></p>
        <p><strong>Email:</strong> <span id="profileEmail"></span></p>
    </div>

    <form id="uploadForm" enctype="multipart/form-data">
        <label class="block mb-2 text-sm font-medium">Upload Foto Baru</label>
        <input type="file" name="photo" accept="image/*" required
               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Upload</button>
    </form>

    <button onclick="deletePhoto()" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus Foto</button>
</div>

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
        document.getElementById('profileImage').src = user.profile_photo
            ? `/storage/${user.profile_photo}`
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}`;
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
                location.reload(); // atau panggil ulang fungsi fetch profil kalau mau lebih halus
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
@endsection
