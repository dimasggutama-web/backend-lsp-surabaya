<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login user
    public function login(Request $request)
    {
    $request ->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'username atau password salah'], 401);
        }

        if ($user->status === 'Non-aktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun anda sedang di Non-aktifkan. Silahkan hubungi Super Admin untuk mengaktifkan kembali akun anda.'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login sukses',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role,
            'user' => $user,
        ], 200);
    }
    
    // Logout user
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout sukses'], 200);
    }


}
