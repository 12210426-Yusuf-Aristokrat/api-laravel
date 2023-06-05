<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autentikasi berhasil, lakukan tindakan yang diinginkan
            return response()->json(['pesan' => 'Berhasil login']);
        } else {
            // Autentikasi gagal
            return response()->json(['pesan' => 'Email atau password salah'], 401);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Lakukan validasi data yang diinputkan
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:6|confirmed',
            ]);

            // Update data pengguna
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];

            if (!empty($validatedData['password'])) {
                $user->password = bcrypt($validatedData['password']);
            }

            $user->save();

            return redirect()->route('profile')->with('success', 'Profil Anda telah diperbarui.');
        }

        return redirect()->route('login')->with('error', 'Tidak ada pengguna yang masuk.');
    }

    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Lakukan validasi file foto yang diunggah
            $validatedData = $request->validate([
                'photo' => 'nullable|image|max:2048', // Batasan ukuran foto 2MB (ubah sesuai kebutuhan Anda)
            ]);

            // Periksa apakah ada file foto yang diunggah
            if ($request->hasFile('photo')) {
                // Hapus foto profil lama jika ada
                if ($user->photo) {
                    Storage::delete($user->photo);
                }

                // Simpan foto baru dan dapatkan path-nya
                $path = $request->file('photo')->store('public/profiles');
                $user->photo = $path;

                $user->save();

                return redirect()->route('profile')->with('success', 'Foto profil Anda telah diperbarui.');
            }

            return redirect()->route('profile')->with('error', 'Tidak ada file foto yang diunggah.');
        }

        return redirect()->route('login')->with('error', 'Tidak ada pengguna yang masuk.');
    }

    public function showProfilePhoto()
    {
        $user = Auth::user();

        if ($user && $user->photo) {
            $path = Storage::url($user->photo);
            return response()->file(public_path($path));
        }

        // Jika pengguna tidak ada atau tidak memiliki foto profil
        return response()->file(public_path('default-profile-photo.png')); // Ganti dengan path ke gambar default profil
    }

}

