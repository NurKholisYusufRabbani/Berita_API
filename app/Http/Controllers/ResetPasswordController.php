<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    /**
     * Menampilkan form untuk mereset password.
     * Token dan email biasanya akan diambil dari request.
     */
    public function showResetForm(Request $request, $token = null)
    {
        // $request->email akan mengambil 'email' dari query string di URL
        // $token akan diambil dari parameter route
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Memproses permintaan reset password.
     */
    public function reset(Request $request)
    {
        // Validasi input dari form reset password
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Mencoba untuk mereset password pengguna
        // Metode Password::reset akan menangani validasi token,
        // menemukan user berdasarkan email dan token,
        // dan memanggil callback jika berhasil.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Update password pengguna
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // Jika password berhasil direset
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login') // Arahkan ke halaman login (atau dashboard jika sudah login)
                             ->with('status', __($status)); // Tampilkan pesan sukses
        }

        // Jika reset gagal (misalnya token tidak valid, email salah, dll.)
        return back()
                ->withInput($request->only('email')) // Kirim kembali input email
                ->withErrors(['email' => __($status)]); // Tampilkan pesan error
    }
}