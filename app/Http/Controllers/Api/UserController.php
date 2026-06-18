<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        try {
            $user = $request->user();
            $user->load('instansi');

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data profil tidak ditemukan atau Anda belum login.',
                    'data' => null
                ], 404);
            }
            $user->load('instansi');
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data profil pengguna.',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil profil.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
    public function getFotoProfile(Request $request)
    {
        try {
            $user = $request->user();

            if (empty($user->fotoProfil)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User belum mengatur foto profil.',
                    'data' => [
                        'foto_url' => url('default-avatar.png') 
                    ]
                ], 200);
            }

            $pathFisik =  storage_path('app/public/' . $user->fotoProfil);

            if (!file_exists($pathFisik)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Foto profil tidak ditemukan di server.',
                    'data' => [
                        'foto_url' => url('default-avatar.png') 
                    ]
                ], 200);
            }
            return response()->file($pathFisik);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil foto profil.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
    //Ganti password (user sendiri)
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Password lama tidak sesuai'], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $user->tokens()->delete();

        return response()->json(['message' => 'Password berhasil diubah. Silahkan login kembali dengan password baru Anda.'], 200);
    }

    // Edit profil (user sendiri)
    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'namaLengkap' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $request->user()->id,
            'nomorTelpon' => 'nullable|string',
            'tanggalLahir' => 'nullable|date',
            'alamatDomisili' => 'nullable|string',
            'asalDaerah' => [
                $request->user()->role === 'asesor' ? 'required' : 'nullable', 
                'string'
            ],
            'jenisKelamin' => 'nullable|in:L,P',
        ], [
            'asalDaerah.required' => 'Asal daerah wajib diisi.',
        ]);

        $request->user()->update(array_filter($validatedData));

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui', 
            'data' => $request->user() 
        ], 200);
    }
    
    public function updateProfilePicture(Request $request)
    {
        try {
            $request->validate([
                'fotoProfil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user = $request->user();

            if ($request->hasFile('fotoProfil')) {
                if ($user->fotoProfil) {
                    Storage::disk('public')->delete($user->fotoProfil);
                }
                $path = $request->file('fotoProfil')->store('profile_photos', 'public');
                $user->update(['fotoProfil' => $path]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Foto profil berhasil diperbarui', 
                    'data' => [
                        'foto_url' => asset('storage/' . $user->fotoProfil)
                    ]
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada file yang diunggah'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengupdate foto profil.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }  
    public function deleteProfilePicture(Request $request)
    {
        try {
            $user = $request->user();

            if ($user->fotoProfil) {
                Storage::disk('public')->delete($user->fotoProfil);
                $user->update(['fotoProfil' => null]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Foto profil berhasil dihapus', 
                    'data' => $user
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'User tidak memiliki foto profil untuk dihapus'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus foto profil.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }    
}