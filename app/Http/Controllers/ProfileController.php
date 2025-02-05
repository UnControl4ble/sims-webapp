<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find(Auth::id());

        if ($user->image && $user->image !== 'default.png') {
            $oldImagePath = public_path('assets/images/profile/' . $user->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        $imageName = time() . '.' . $request->image->extension();
        // $request->image->move(public_path('assets/images/profile'), $imageName);
        Storage::disk('public')->putFileAs('images/profile', $request->image, $imageName);

        User::where('id', $user->id)->update(['image' => $imageName]);

        return redirect()->back()->with('success', 'Gambar berhasil diperbarui.');
    }
}
