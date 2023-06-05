<?php

namespace App\Http\Controllers;

use App\Models\UserDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDetailController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user) {
            $userDetail = $user->userDetail;

            return view('user_detail.show', compact('userDetail'));
        }

        return redirect()->route('login')->with('error', 'Tidak ada pengguna yang masuk.');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:80',
                'gender' => 'required|in:L,P',
                'tgl_lahir' => 'required|date',
                'alamat' => 'required|string|max:512',
                'lokasi' => 'required|string',
            ]);

            $userDetail = new UserDetailModel([
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'gender' => $validatedData['gender'],
                'tgl_lahir' => $validatedData['tgl_lahir'],
                'alamat' => $validatedData['alamat'],
                'lokasi' => $validatedData['lokasi'],
            ]);

            $user->userDetail()->save($userDetail);

            return redirect()->route('profile')->with('success', 'Detail pengguna berhasil disimpan.');
        }

        return redirect()->route('login')->with('error', 'Tidak ada pengguna yang masuk.');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:80',
                'gender' => 'required|in:L,P',
                'tgl_lahir' => 'required|date',
                'alamat' => 'required|string|max:512',
                'lokasi' => 'required|string',
            ]);

            $userDetail = $user->userDetail;

            if ($userDetail) {
                $userDetail->nama_lengkap = $validatedData['nama_lengkap'];
                $userDetail->gender = $validatedData['gender'];
                $userDetail->tgl_lahir = $validatedData['tgl_lahir'];
                $userDetail->alamat = $validatedData['alamat'];
                $userDetail->lokasi = $validatedData['lokasi'];
                $userDetail->save();

                return redirect()->route('profile')->with('success', 'Detail pengguna berhasil diperbarui.');
            } else {
                return redirect()->route('profile')->with('error', 'Detail pengguna tidak ditemukan.');
            }
        }

        return redirect()->route('login')->with('error', 'Tidak ada pengguna yang masuk.');
    }

    public function destroy()
    {
        $user = Auth::user();

        if ($user) {
            $userDetail = $user->userDetail;

            if ($userDetail) {
                $userDetail->delete();

                return redirect()->route('profile')->with('success', 'Detail pengguna berhasil dihapus.');
            } else {
                return redirect()->route('profile')->with('error', 'Detail pengguna tidak ditemukan.');
            }
        }

        return redirect()->route('login')->with('error', 'Tidak ada pengguna yang masuk.');
    }
}
