<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        // VALIDASI
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // UPLOAD FOTO
        if ($request->hasFile('profile_picture')) {

            $file = $request->file('profile_picture');

            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('profile_pictures', $filename, 'public');

            $user->profile_picture = $filename;
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }
}