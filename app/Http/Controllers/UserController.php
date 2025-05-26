<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ✅ Cek apakah user adalah admin
    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized. Admin only access.'
            ], 403);
        }
        return null;
    }

    // ✅ Lihat semua user (admin only)
    public function index()
    {
        if ($response = $this->authorizeAdmin()) return $response;

        $users = User::all();

        return response()->json([
            'message' => 'List of all users',
            'data' => $users,
        ], 200);
    }

    // ✅ Simpan user baru (admin only)
    public function store(Request $request)
    {
        if ($response = $this->authorizeAdmin()) return $response;

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'nullable|in:user,admin',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = $validated['role'] ?? 'user';

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    // ✅ Tampilkan 1 user (admin only)
    public function show(User $user)
    {
        if ($response = $this->authorizeAdmin()) return $response;

        return response()->json([
            'message' => 'User detail',
            'data' => $user,
        ], 200);
    }

    // ✅ Update user (admin only)
    public function update(Request $request, User $user)
    {
        if ($response = $this->authorizeAdmin()) return $response;

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role' => 'nullable|in:user,admin',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user,
        ], 200);
    }

    // ✅ Hapus user (admin only)
    public function destroy($id)
    {
        if ($response = $this->authorizeAdmin()) return $response;

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (auth()->id() === $user->id) {
            return response()->json(['message' => 'You cannot delete yourself'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // Profil user sendiri
    public function profile()
    {
        $user = auth()->user();
        return response()->json([
            'message' => 'User profile',
            'data' => $user,
        ], 200);
    }

    public function viewProfile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed',
            'photo_profile' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        // Handle foto profil
        if ($request->hasFile('photo_profile')) {
            if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
                Storage::disk('public')->delete($user->photo_profile);
            }

            $path = $request->file('photo_profile')->store('profile_photos', 'public');
            $validated['photo_profile'] = $path;
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $user,
        ]);
    }

    // Hapus akun user sendiri
    public function destroyProfile()
    {
        $user = auth()->user();

        $user->delete();

        return response()->json([
            'message' => 'Your account has been deleted successfully',
        ], 200);
    }
}
