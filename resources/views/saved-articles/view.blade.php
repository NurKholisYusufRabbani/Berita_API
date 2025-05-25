@extends('layouts.app')

@section('title', 'Saved Articles')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Saved Articles</h1>

    <div id="article-section">
        <p class="text-gray-600">Memuat artikel...</p>
    </div>
</div>

<script>
(() => {
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "/saved-articles";
    }

    fetch('/api/saved-articles', {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error("Gagal mengambil data artikel");
        return res.json();
    })
    .then(data => {
        const section = document.getElementById('article-section');

        if (data.length === 0) {
            section.innerHTML = `<p class="text-gray-600">Belum ada artikel yang tersimpan.</p>`;
            return;
        }

        const ul = document.createElement('ul');
        ul.className = 'space-y-4';

        data.forEach(article => {
            const li = document.createElement('li');
            li.className = 'border rounded p-4 shadow-sm hover:shadow-md transition';
            li.innerHTML = `
                <a href="/discussions/${article.article_token}" class="block hover:shadow-lg transition duration-200 rounded-lg border p-4 bg-white">
                    <h2 class="text-xl font-semibold mb-2">${article.title}</h2>
                    <p class="text-sm text-gray-700 mb-1"><strong>URL:</strong> <span class="text-blue-600 underline">${article.url}</span></p>
                    <p class="text-sm text-gray-700 mb-1"><strong>Summary:</strong> ${article.summary ?? '-'}</p>
                    <p class="text-sm text-gray-700"><strong>Section:</strong> ${article.section ?? '-'}</p>
                </a>
            `;
            ul.appendChild(li);
        });

        section.innerHTML = '';
        section.appendChild(ul);
    })
    .catch(err => {
        console.error(err);
        document.getElementById('article-section').innerHTML = `
            <div class="bg-yellow-100 text-yellow-700 p-4 rounded">
                <strong>Gagal memuat artikel:</strong> Pastikan Anda sudah login dan token Anda valid.
            </div>
        `;
    });
})();
</script>
@endsection
