<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Middleware auth supaya hanya user login yang bisa akses
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Menampilkan data user yang sedang login
    public function me()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    // Update photo profile
    public function updatePhoto(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Hapus foto lama jika ada
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Simpan foto baru
        $path = $request->file('photo')->store('profile_photos', 'public');

        $user->profile_photo = $path;
        $user->save();

        return response()->json([
            'message' => 'Foto berhasil diunggah',
            'path' => $path
        ]);
    }

    // Delete photo profile
    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();
        }

        return response()->json(['message' => 'Foto berhasil dihapus']);
    }
}
