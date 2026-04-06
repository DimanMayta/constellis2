<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            return redirect('/');
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = auth()->user();
            $redirect = $request->input('redirect', '/');

            // Role-based redirect
            if (str_contains($redirect, 'intranet')) {
                if ($user->canAccessIntranet()) return redirect($redirect);
                Auth::logout();
                return back()->withErrors(['email' => 'No intranet access.']);
            }
            if (str_contains($redirect, 'store')) {
                if ($user->canAccessStore()) return redirect($redirect);
                Auth::logout();
                return back()->withErrors(['email' => 'No store access.']);
            }

            return redirect()->intended($redirect);
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
