<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function attempt(Request $request)
    {
        $key = 'login:' . $request->ip();
        $maxAttempts = 5;
        $decay = 60; // detik

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retry = RateLimiter::availableIn($key);
            return back()
                ->with('error', "Terlalu banyak percobaan. Coba lagi dalam {$retry} detik.")
                ->withInput();
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            // ambil semua data user
            $user = Auth::user();

            // simpan ke session
            $request->session()->put([
                'pengguna' => $user->toArray(),
                'role'     => $user->role,
            ]);

            // redirect sesuai role
            $role = strtolower($user->role); // biar aman huruf kecil semua
            return redirect()->intended("/{$role}/dashboard");
        }

        RateLimiter::hit($key, $decay);

        return back()
            ->with('error', 'Email atau password salah.')
            ->withInput();
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
