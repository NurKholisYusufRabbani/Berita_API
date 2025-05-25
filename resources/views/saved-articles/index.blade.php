<!DOCTYPE html>
<html>
<head>
    <title>Saved Articles</title>
    <script>
        const token = localStorage.getItem('token');
        if (token) {
            // Redirect ke halaman utama yang pakai layout
            window.location.href = "/saved-articles/view";
        }
    </script>
</head>
<body>
    <div style="padding: 2rem; font-family: sans-serif; background: #fee2e2; color: #991b1b;">
        <h1>Error: Anda belum login</h1>
        <p>Silakan login terlebih dahulu untuk melihat artikel yang disimpan.</p>
    </div>
</body>
</html>
