<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * List all users.
     */
    public function index(): View
    {
        $users = User::with('toko')->latest()->paginate(20);

        return view('admin.users.index', [
            'users'  => $users,
            'active' => 'profil',
        ]);
    }
}
