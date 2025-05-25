@extends('layouts.app')

@section('title', 'Diskusi Artikel')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-4">Diskusi Artikel</h1>

    {{-- Artikel --}}
    <div id="discussion-article" class="mb-6 bg-gray-50 p-4 rounded border"></div>

    {{-- Form Komentar --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Tulis Komentar</h2>
        <form id="comment-form">
            <textarea id="comment-content" class="w-full p-3 border rounded mb-2" rows="3" placeholder="Tulis komentar..."></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kirim Komentar</button>
        </form>
    </div>

    {{-- Komentar --}}
    <div id="discussion-comments">
        <p class="text-gray-600">Memuat diskusi...</p>
    </div>
</div>

<script>
    (() => {
    const token = localStorage.getItem('token'); // ambil token user login
    const articleToken = "{{ $token }}";         // token artikel dari controller/URL

    // Fungsi escape HTML untuk keamanan XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Ambil user id dari JWT token sederhana
    function getUserIdFromToken(token) {
        if (!token) return null;
        try {
            const payload = token.split('.')[1];
            const decoded = JSON.parse(atob(payload));
            return decoded.sub || decoded.id || null;
        } catch(e) {
            return null;
        }
    }

    // Tampilkan artikel
    fetch(`/api/saved-articles/token/${articleToken}`, {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(article => {
        document.getElementById('discussion-article').innerHTML = `
            <h2 class="text-xl font-bold mb-2">${escapeHtml(article.title)}</h2>
            <p class="text-sm text-gray-700"><strong>URL:</strong> <a href="${article.url}" class="text-blue-500 underline" target="_blank">${article.url}</a></p>
            <p class="text-sm text-gray-700"><strong>Summary:</strong> ${escapeHtml(article.summary ?? '-')}</p>
        `;
    });

    // Load komentar + reply
    function loadComments() {
        fetch(`/api/articles/${articleToken}/comments`, {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const section = document.getElementById('discussion-comments');

            if (!Array.isArray(data)) {
                section.innerHTML = `<p class="text-red-500">Gagal memuat diskusi: ${data.message || 'Format tidak sesuai'}</p>`;
                return;
            }

            if (data.length === 0) {
                section.innerHTML = `<p class="text-gray-600">Belum ada diskusi.</p>`;
                return;
            }

            const ul = document.createElement('ul');
            ul.className = 'space-y-4';

            data.forEach(d => {
                const li = document.createElement('li');
                li.className = 'bg-white border p-3 rounded shadow-sm';

                const createdAt = new Date(d.created_at).toLocaleString();
                const isOwner = d.user && d.user.id === parseInt(getUserIdFromToken(token));

                li.innerHTML = `
                    <p class="text-gray-800 comment-content" data-comment-id="${d.id}">${escapeHtml(d.content)}</p>
                    <p class="text-sm text-gray-500 mt-1">— ${d.user?.name ?? 'Anonim'}, <small>${createdAt}</small></p>
                    <div class="flex space-x-2 mt-2">
                        ${isOwner ? `<button class="delete-btn text-red-500" data-id="${d.id}">Hapus</button>` : ''}
                        <button class="reply-toggle-btn text-blue-500 text-sm">Reply</button>
                    </div>
                    <form class="reply-form mt-2 hidden" data-comment-id="${d.id}">
                        <textarea class="reply-content w-full border p-2 rounded mb-1" rows="2" placeholder="Tulis balasan..."></textarea>
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm">Kirim Reply</button>
                        <button type="button" class="reply-cancel-btn ml-2 text-gray-600 text-sm">Batal</button>
                    </form>
                    <div class="replies-container"></div>
                `;

                ul.appendChild(li);

                // Load reply untuk komentar ini
                const repliesContainer = li.querySelector('.replies-container');
                loadReplies(d.id, repliesContainer);
            });

            section.innerHTML = '';
            section.appendChild(ul);

            bindDeleteActions();
            bindReplyToggle();
            bindReplyCancel();
            bindReplySubmit();
        })
        .catch(err => {
            console.error(err);
            document.getElementById('discussion-comments').innerHTML = `<p class="text-red-500">Gagal memuat diskusi.</p>`;
        });
    }

    // Load reply per komentar
    function loadReplies(commentId, container) {
        fetch(`/api/comments/${commentId}/replies`, {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(replies => {
            if (!Array.isArray(replies)) return;

            const replyList = document.createElement('ul');
            replyList.className = 'ml-6 mt-2 space-y-2';

            replies.forEach(reply => {
                const li = document.createElement('li');
                li.className = 'bg-gray-100 border p-2 rounded';

                const createdAt = new Date(reply.created_at).toLocaleString();
                const isOwner = reply.user && reply.user.id === parseInt(getUserIdFromToken(token));

                li.innerHTML = `
                    <p class="text-gray-700">${escapeHtml(reply.content)}</p>
                    <p class="text-xs text-gray-500">— ${reply.user?.name ?? 'Anonim'}, <small>${createdAt}</small></p>
                    ${isOwner ? `<button class="delete-reply-btn text-red-500 text-xs" data-id="${reply.id}">Hapus</button>` : ''}
                `;

                replyList.appendChild(li);
            });

            container.innerHTML = '';
            container.appendChild(replyList);

            bindDeleteReplyActions();
        })
        .catch(err => {
            console.error(err);
        });
    }

    // Submit komentar baru
    document.getElementById('comment-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const content = document.getElementById('comment-content').value.trim();
        if (!content) return alert("Komentar tidak boleh kosong.");

        fetch(`/api/articles/${articleToken}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ content })
        })
        .then(res => {
            if (!res.ok) throw new Error("Gagal menambahkan komentar");
            document.getElementById('comment-content').value = '';
            loadComments();
        })
        .catch(err => alert("Gagal mengirim komentar"));
    });

    // Bind tombol hapus komentar
    function bindDeleteActions() {
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.onclick = () => {
                if(confirm('Yakin ingin menghapus komentar ini?')) {
                    deleteComment(btn.dataset.id);
                }
            };
        });
    }

    function deleteComment(id) {
        fetch(`/api/comments/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error("Gagal menghapus komentar");
            loadComments();
        })
        .catch(err => alert(err.message));
    }

    // Bind toggle form reply
    function bindReplyToggle() {
        document.querySelectorAll('.reply-toggle-btn').forEach(btn => {
            btn.onclick = () => {
                const li = btn.closest('li');
                const form = li.querySelector('.reply-form');
                form.classList.toggle('hidden');
            };
        });
    }

    // Bind batal reply
    function bindReplyCancel() {
        document.querySelectorAll('.reply-cancel-btn').forEach(btn => {
            btn.onclick = () => {
                const form = btn.closest('form');
                form.classList.add('hidden');
                form.querySelector('.reply-content').value = '';
            };
        });
    }

    // Submit reply dengan variabel replyContent yang sudah dideklarasikan
    function bindReplySubmit() {
        document.querySelectorAll('.reply-form').forEach(form => {
            form.onsubmit = (e) => {
                e.preventDefault();

                const replyContent = form.querySelector('.reply-content').value.trim();

                if (!replyContent) {
                    return alert("Balasan tidak boleh kosong.");
                }

                const commentId = form.dataset.commentId;

                fetch(`/api/comments/${commentId}/replies`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ content: replyContent })
                })
                .then(res => {
                    if (!res.ok) throw new Error("Gagal menambahkan balasan");
                    form.querySelector('.reply-content').value = '';
                    form.classList.add('hidden');
                    loadComments();
                })
                .catch(err => alert(err.message));
            };
        });
    }

    // Bind hapus reply
    function bindDeleteReplyActions() {
        document.querySelectorAll('.delete-reply-btn').forEach(btn => {
            btn.onclick = () => {
                if(confirm('Yakin ingin menghapus balasan ini?')) {
                    deleteReply(btn.dataset.id);
                }
            };
        });
    }

    function deleteReply(id) {
        fetch(`/api/replies/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error("Gagal menghapus balasan");
            loadComments();
        })
        .catch(err => alert(err.message));
    }

    // Muat komentar saat halaman dibuka
    loadComments();
    })();
</script>
@endsection
