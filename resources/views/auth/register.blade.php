<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    <form id="registerForm">
        <label>Name:</label><br />
        <input type="text" id="name" name="name" required /><br /><br />

        <label>Username:</label><br />
        <input type="text" id="username" name="username" required /><br /><br />

        <label>Email:</label><br />
        <input type="email" id="email" name="email" required /><br /><br />

        <label>Password:</label><br />
        <input type="password" id="password" name="password" required /><br /><br />

        <label>Confirm Password:</label><br />
        <input type="password" id="password_confirmation" name="password_confirmation" required /><br /><br />

        <button type="submit">Register</button>
    </form>

    <script>
        document.querySelector('#registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                name: document.querySelector('#name').value,
                username: document.querySelector('#username').value,
                email: document.querySelector('#email').value,
                password: document.querySelector('#password').value,
                password_confirmation: document.querySelector('#password_confirmation').value
            };

            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (response.ok) {
                    localStorage.setItem('token', result.token);
                    alert(result.message);
                    window.location.href = '/login';
                } else {
                    let msg = result.message || JSON.stringify(result.errors) || 'Registrasi gagal';
                    alert(msg);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    </script>

    <p>Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a></p>
</body>
</html>
