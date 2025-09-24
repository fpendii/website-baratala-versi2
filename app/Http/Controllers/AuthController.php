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
        $key = 'login:'.$request->ip();
        $maxAttempts = 5;
        $decay = 60; // detik

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retry = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak percobaan. Coba lagi dalam {$retry} detik.")
                         ->withInput();
        }

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $login, 'password' => $request->password], $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // arahkan sesuai kebutuhan
        }

        RateLimiter::hit($key, $decay);

        throw ValidationException::withMessages([
            'login' => ['Email/Username atau password salah.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('status', 'Berhasil logout.');
    }
}
