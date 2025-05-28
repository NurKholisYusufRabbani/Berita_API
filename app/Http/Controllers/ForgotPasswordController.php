<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan form untuk meminta link reset password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); // Path ke Blade view
    }

    /**
     * Mengirim link reset password ke email pengguna.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Mencoba mengirim link reset
        $status = Password::sendResetLink($request->only('email'));

        // Jika link berhasil dikirim
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]); // __($status) akan mengambil pesan dari file lang/en/passwords.php
        }

        // Jika pengiriman gagal (misalnya, email tidak ditemukan)
        return back()->withInput($request->only('email'))
                     ->withErrors(['email' => __($status)]);
    }
}