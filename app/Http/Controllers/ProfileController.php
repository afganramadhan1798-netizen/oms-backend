<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'profile_picture' => 'required|image|max:2048',
    ]);

    if ($request->hasFile('profile_picture')) {

        $file = $request->file('profile_picture');

        // paksa png
        $filename = time() . '.png';

        $file->storeAs(
            'profile_pictures',
            $filename,
            'public'
        );

        $user->profile_picture = $filename;

        $user->save();

        return response()->json([
            'message' => 'Profile updated',
            'data' => $user
        ]);
    }

    return response()->json([
        'message' => 'No file uploaded'
    ], 400);
}

public function deletePhoto()
{
    $user = auth()->user();

    if ($user->profile_picture) {

        $path = 'profile_pictures/' . $user->profile_picture;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $user->profile_picture = null;
        $user->save();
    }

    return response()->json([
        'message' => 'Photo deleted successfully'
    ]);
}

}