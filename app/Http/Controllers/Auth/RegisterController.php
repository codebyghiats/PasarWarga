<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show the registration form with a preselected role path.
     */
    public function show(?string $path = null): View
    {
        $role = match ($path) {
            'pemilik' => 'pemilik_toko',
            'warga'   => 'warga',
            default   => null,
        };

        return view('auth.register', ['selectedRole' => $role]);
    }

    /**
     * Create the account and sign the user in.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:warga,pemilik_toko'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => strtolower($data['email']),
            'password' => $data['password'], // cast 'hashed' handles it
            'role'     => $data['role'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'pemilik_toko') {
            return redirect()->route('toko.pendaftaran')
                ->with('success', 'Akun berhasil dibuat. Lengkapi profil tokomu sekarang.');
        }

        return redirect()->route('home')
            ->with('success', 'Selamat datang di Pasar Warga! Mulai belanja dari tetanggamu.');
    }
}
