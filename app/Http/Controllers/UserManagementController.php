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

    // cegah HR inactive
    if (
        $user->role === 'human_resource' &&
        $request->status === 'inactive'
    ) {

        return response()->json([
            'success' => false,
            'message' => 'User HR tidak dapat dinonaktifkan'
        ], 403);
    }

    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'position' => 'required',
        'role' => 'required',
        'status' => 'required',

        // password optional
        'password' => 'nullable|min:6'
    ]);

    // update field biasa
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->position = $validated['position'];
    $user->role = $validated['role'];
    $user->status = $validated['status'];

    // kalau password diisi
    if (!empty($validated['password'])) {

        $user->password = bcrypt($validated['password']);
    }

    $user->save();

    return response()->json([
        'message' => 'User berhasil diupdate',
        'data' => $user
    ]);
}

    public function deactivate(Request $request, $id)
{
    $user = User::findOrFail($id);

    // user yang sedang login
    $loggedInUser = $request->user();

    // tidak bisa deactivate akun sendiri
    if ($loggedInUser->id == $user->id) {

        return response()->json([
            'success' => false,
            'message' => 'Anda tidak dapat menonaktifkan akun sendiri'
        ], 403);
    }

    // tidak bisa deactivate sesama HR
    if ($user->role === 'human_resource') {

        return response()->json([
            'success' => false,
            'message' => 'User HR tidak dapat dinonaktifkan'
        ], 403);
    }

    // deactivate user
    $user->update([
        'status' => 'inactive'
    ]);

    return response()->json([
        'success' => true,
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
