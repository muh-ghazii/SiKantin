<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /register
    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pelanggan',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registrasi berhasil, silakan login',
            'data'    => $user
        ], 201);
    }

    // POST /login
   public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Email atau password salah',
        ], 401);
    }

    $user  = Auth::user();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status'  => 'success',
        'message' => 'Login berhasil',
        'token'   => $token,
        'data'    => [
            'id'    => $user->id,
            'nama'  => $user->nama,
            'email' => $user->email,
            'role'  => $user->role,
        ]
    ]);
}

    // POST /logout
    public function logout(Request $request)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Logout berhasil',
        ]);
    }

    // GET /me
    public function me()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'data'   => $user
        ]);
    }

    // PUT /me
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'  => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:6',
        ]);

        if ($request->has('nama')) {
            $user->nama = $request->nama;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil berhasil diupdate',
            'data'    => $user
        ]);
    }
}