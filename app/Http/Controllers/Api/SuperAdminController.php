<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JejaringLspBlk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    //Get All user (superAdmin Only)
    public function getAllUsers(Request $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            return response()->json(['message' => 'Akses ditolak, hanya SuperAdmin yang dapat melihat semua user'], 403);
        }
        
        $users = User::with(['instansi', 'tuk'])
            ->where('role', '!=', 'superAdmin')
            ->paginate(100); 

        return response()->json(['users' => $users], 200);
    }

    //Reset password (superAdmin Only)
    public function resetPasswordByAdmin(Request $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            return response()->json(['message' => 'Akses ditolak, hanya SuperAdmin yang dapat mereset password'], 403);
        }
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('username', $request->username)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password untuk user ' . $user->username . ' berhasil direset'], 200);
    }

    // Buat user (superAdmin Only)
    public function registerByAdmin(Request $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            return response()->json(['message' => 'Akses ditolak, hanya SuperAdmin yang dapat membuat user'], 403);
        }
        $rules = [
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:superAdmin,adminLsp,stafLsp,adminBlk,asesor',
            'instansi_id' => [
                'required',
                Rule::exists('jejaring_lsp_blk_sby', 'id')->where(function ($query) {
                    $query->where('status', 'Aktif'); 
                }),
            ],
        ];
        
        if ($request->role === 'adminBlk') {
            $rules['tuk_ids']   = 'required|array|min:1'; 
            $rules['tuk_ids.*'] = 'exists:jejaring_lsp_blk_sby,id';
        }
        $request->validate($rules);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'instansi_id' => $request->instansi_id, 
        ]);

        if ($user->role === 'adminBlk' && $request->has('tuk_ids')) {
            $user->tuk()->sync($request->tuk_ids);
            $user->load('tuk');
        }

        $user->load('instansi');

        return response()->json([
            'message' => 'User berhasil dibuat', 
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'instansi_id' => $user->instansi_id,
                'nama_instansi' => $user->instansi ? $user->instansi->namaInstitusi : null, 
                'tuk_akses' => $user->role === 'adminBlk' ? $user->tuk : null
            ]
        ], 201);
    }

    // Edit user (superAdmin Only)
    public function editUserByAdmin(Request $request, $id)
    {
        if (!$request->user()->isSuperAdmin()) {
            return response()->json(['message' => 'Akses ditolak, hanya SuperAdmin yang dapat mengedit user'], 403);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
        $rules = [
            'new_username' => 'nullable|string|unique:users,username,' . $user->id, 
            'new_role' => 'nullable|in:superAdmin,adminLsp,stafLsp,adminBlk,asesor',
            'instansi_id' => [
                'nullable', 
                Rule::exists('jejaring_lsp_blk_sby', 'id')->where(function ($query) {
                    $query->where('status', 'Aktif');
                }),
            ],
        ];
        
        $roleTarget = $request->has('new_role') ? $request->new_role : $user->role;
        $isNaikJabatan = $request->has('new_role') && $request->new_role === 'adminBlk' && $user->role !== 'adminBlk';

        if ($roleTarget === 'adminBlk') {
            $rules['tuk_ids']   = $isNaikJabatan ? 'required|array|min:1' : 'nullable|array|min:1';
            $rules['tuk_ids.*'] = 'exists:jejaring_lsp_blk_sby,id';
        }
        $customMessages = [
            'tuk_ids.required' => 'Karena jabatan diubah menjadi Admin BLK, Anda WAJIB memilih minimal 1 TUK (Lokasi Ujian)!',
            'tuk_ids.min'      => 'Array TUK tidak boleh kosong! Anda WAJIB memilih minimal 1 TUK (Lokasi Ujian)!'
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengupdate user! Ada inputan yang tidak sesuai.',
                'errors'  => $validator->errors()
            ], 422);
        }

        if ($request->has('new_username')) {
            $user->username = $request->new_username;
        }
        if ($request->has('new_role')) {
            $user->role = $request->new_role;
        }
        
        if ($request->has('instansi_id')) {
            $user->instansi_id = $request->instansi_id;
        }

        if ($roleTarget === 'adminBlk') {
            if ($request->has('tuk_ids')) {
                $user->tuk()->sync($request->tuk_ids); 
            }
        } else {
            $user->tuk()->detach();
        }

        $user->save();

        $user->load('tuk');
        return response()->json(['message' => 'User berhasil diupdate', 'user' => $user], 200);
    }

    // Non-aktif/Aktifkan User
    public function statusUser (Request $request, $userId)
    {
        if (!$request->user() || !$request->user()->isSuperAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak, hanya SuperAdmin yang dapat mengubah status user'
            ], 403);
        }

        try {
            $user = User::find($userId);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akun tidak ditemukan'
                ], 404);
            }
            if (auth()->id() === $user->id) { 
            return response()->json([
                'status' => 'error',
                'message' => 'anda tidak bisa menonaktifkan akun anda sendiri.'
            ], 403);
        }
        $statusBaru = ($user->status === 'Aktif') ? 'Non-aktif' : 'Aktif';
        $user->update([
                'status' => $statusBaru
            ]);
            return response()->json([
                'status' => 'success',
                'message' => "Status akun {$user->role} berhasil diubah menjadi {$statusBaru}.",
                'data' => [
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'status_sekarang' => $statusBaru
                ]    
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem saat mengubah status',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
    public function getListInstansi()
    {
        // Sesuaikan sama nama model tabel instansi lu ya
        $instansi = JejaringLspBlk::select('id', 'namaInstitusi')->where('status', 'Aktif')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $instansi
        ]);
    }
}
