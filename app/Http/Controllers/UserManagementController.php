<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index()
    {
        return User::select(
            'id',
            'name',
            'email',
            'role',
            'position',
            'status'
        )->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'position' => 'required'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'position' =>$validated['position'],
            'status' => 'active'
        ]);

        return response()->json([
            'message' => 'User berhasil dibuat',
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required'
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User berhasil diupdate',
            'data' => $user
        ]);
    }

    public function deactivate($id)
{
    if (auth()->id() == $id) {

        return response()->json([
            'message' => 'Tidak bisa menonaktifkan akun sendiri'
        ], 403);
    }

    $user = User::findOrFail($id);

    $user->update([
        'status' => 'inactive'
    ]);

    return response()->json([
        'message' => 'User berhasil dinonaktifkan'
    ]);
}

    public function activate($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'active'
        ]);

        return response()->json([
            'message' => 'User berhasil diaktifkan'
        ]);
    }
}
