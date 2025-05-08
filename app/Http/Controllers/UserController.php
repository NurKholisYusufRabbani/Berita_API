<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Lihat semua user
    public function index()
    {
        return User::all();
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    // Tampilkan 1 user
    public function show(User $user)
    {
        return $user;
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $user->update($request->only(['name', 'email']));
        return response()->json($user);
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
