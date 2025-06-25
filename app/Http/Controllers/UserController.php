<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password berhasil diganti']);
    }

    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $user->first_name = $request->firstName;
    $user->last_name = $request->lastName;
    $user->phone_number = $request->phoneNumber;
    $user->birthday = $request->birthday;
    $user->save();

    return redirect()->back()->with('success', 'Profile updated.');
}

public function uploadProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = auth()->user();

    $file = $request->file('profile_picture');
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $path = $file->storeAs('profile_pictures', $filename, 'public');

    // Update the user's profile picture URL
    $user->profile_picture_url = '/storage/' . $path;
    $user->save();

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Foto profil berhasil diperbarui!']);
    }

    return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
}


}

