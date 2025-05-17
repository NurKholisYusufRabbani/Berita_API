<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Register Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="bg-gray-50 min-h-screen flex flex-col items-center justify-center py-6 px-4">
    <div class="max-w-md w-full">
        <div class="p-8 rounded-2xl bg-white shadow">
            <h2 class="text-slate-900 text-center text-3xl font-semibold">Register</h2>
            <form id="registerForm" class="mt-12 space-y-6">
                <div>
                    <label class="text-slate-800 text-sm font-medium mb-2 block">Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                        placeholder="Full Name" />
                </div>

                <div>
                    <label class="text-slate-800 text-sm font-medium mb-2 block">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                        placeholder="Username" />
                </div>

                <div>
                    <label class="text-slate-800 text-sm font-medium mb-2 block">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                        placeholder="Email address" />
                </div>

                <div>
                    <label class="text-slate-800 text-sm font-medium mb-2 block">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                        placeholder="Password" />
                </div>

                <div>
                    <label class="text-slate-800 text-sm font-medium mb-2 block">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                        placeholder="Confirm password" />
                </div>

                <div class="!mt-12">
                    <button type="submit"
                        class="w-full py-2 px-4 text-[15px] font-medium tracking-wide rounded-md text-white bg-gray-900 hover:bg-gray-700 focus:outline-none cursor-pointer">
                        Register
                    </button>
                </div>

                <p class="text-slate-800 text-sm !mt-6 text-center">
                    Already have an account?
                    <a href="/login"
                        class="text-gray-900 hover:underline ml-1 whitespace-nowrap font-semibold">Sign in here</a>
                </p>
            </form>
        </div>
    </div>
</div>


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
