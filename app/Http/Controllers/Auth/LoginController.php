<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Attempt to authenticate the user and redirect by role.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password tidak cocok.']);
        }

        $request->session()->regenerate();

        return $this->redirectByRole(Auth::user()->role);
    }

    /**
     * Redirect an authenticated user to the right dashboard.
     */
    protected function redirectByRole(string $role): RedirectResponse
    {
        return match ($role) {
            'admin'        => redirect()->route('admin.dashboard'),
            'pemilik_toko' => Auth::user()->toko
                ? redirect()->route('toko.dashboard')
                : redirect()->route('toko.pendaftaran'),
            default        => redirect()->route('home'),
        };
    }
}
