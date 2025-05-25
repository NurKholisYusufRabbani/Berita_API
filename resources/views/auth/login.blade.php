<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="bg-gray-50 min-h-screen flex flex-col items-center justify-center py-6 px-4">
        <div class="max-w-md w-full">
            <div class="p-8 rounded-2xl bg-white shadow">
                <h2 class="text-slate-900 text-center text-3xl font-semibold">Sign in</h2>
                <form id="loginForm" class="mt-12 space-y-6">
                    <div>
                        <label class="text-slate-800 text-sm font-medium mb-2 block">User email</label>
                        <input name="email" type="email" required
                            class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                            placeholder="Email" />
                    </div>

                    <div>
                        <label class="text-slate-800 text-sm font-medium mb-2 block">Password</label>
                        <input name="password" type="password" required
                            class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                            placeholder="Password" />
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 shrink-0 text-gray-900 focus:ring-gray-900 border-slate-300 rounded" />
                            <label for="remember-me" class="ml-3 block text-sm text-slate-800">Remember me</label>
                        </div>
                        <div class="text-sm">
                            <a href="javascript:void(0);" class="text-gray-900 hover:underline font-semibold">Forgot your
                                password?</a>
                        </div>
                    </div>

                    <div class="!mt-12">
                        <button type="submit"
                            class="w-full py-2 px-4 text-[15px] font-medium tracking-wide rounded-md text-white bg-gray-900 hover:bg-gray-700 focus:outline-none cursor-pointer">
                            Sign in
                        </button>
                    </div>
                </form>

                <!-- Google OAuth button -->
                <div class="mt-6">
                    <a href="/auth/google"
                        class="flex items-center justify-center gap-3 border border-gray-300 rounded-md py-2 hover:bg-gray-100 transition cursor-pointer">
                        <img src="https://www.gstatic.com/marketing-cms/assets/images/d5/dc/cfe9ce8b4425b410b49b7f2dd3f3/g.webp=s48-fcrop64=1,00000000ffffffff-rw"
                            alt="Google logo" class="w-6 h-6" />
                        <span class="text-gray-700 font-medium text-sm">Sign in with Google</span>
                    </a>
                </div>

                <p class="text-slate-800 text-sm !mt-6 text-center">
                    Don't have an account?
                    <a href="/register" class="text-gray-900 hover:underline ml-1 whitespace-nowrap font-semibold">Register
                        here</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {
                email: formData.get('email'),
                password: formData.get('password'),
            };

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok) {
                    // Simpan token JWT yang benar
                    localStorage.setItem('token', result.access_token);
                    window.location.href = '/'; // Redirect ke home
                } else {
                    alert(result.error || 'Login gagal');
                }
            } catch (error) {
                alert('Terjadi kesalahan jaringan');
                console.error(error);
            }
        });
    </script>
</body>

</html>
