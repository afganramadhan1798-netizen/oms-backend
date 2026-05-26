<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);

        if ($user->status !== 'active') {
            return response()->json([
                'message' => 'Akun anda sudah dinonaktifkan'
            ], 403);
        }
        }

        $accessToken  = $user->createToken(
            'access_token',
            ['*'],
            now()->addMinutes(60 * 24),
        );

        return response()->json([
            'success' => true,
            'access_token' => $accessToken->plainTextToken,
            'role' => $user->role,
            'position' => $user->position
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    }
}