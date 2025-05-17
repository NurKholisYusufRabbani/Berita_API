<form id="loginForm">
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Login</button>
</form>

<script>
  document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {
      email: formData.get('email'),
      password: formData.get('password')
    };

    const response = await fetch('/api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify(data)
    });

    const result = await response.json();

    if (response.ok) {
      localStorage.setItem('token', result.token);
      window.location.href = '/'; // Redirect ke home
    } else {
      alert(result.error || 'Login gagal');
    }
  });
</script>
