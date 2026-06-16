<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FORM LOGIN
    public function loginForm()
    {
        return view('auth.login');
    }

   
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8'
        ], [
            'password.min' => 'Password minimal harus 8 karakter.'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($request->wantsJson() || $request->is('api/*')) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'user' => $user,
                        'access_token' => $token,
                        'token_type' => 'Bearer'
                    ]
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ]);
    }

    // FORM REGISTER
    public function registerForm()
    {
        return view('auth.register');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min' => 'Password minimal harus 8 karakter.'
        ]);

        if ($request->wantsJson() || $request->is('api/*')) {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'keuangan', 
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 201);
        }

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'keuangan', 
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            // Revoke current token
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
