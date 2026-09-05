<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminKategoriController extends Controller
{
    /**
     * List all categories.
     */
    public function index(): View
    {
        $kategoris = Kategori::withCount('produks')->orderBy('nama')->get();

        return view('admin.kategoris.index', [
            'kategoris' => $kategoris,
            'active'    => 'profil',
        ]);
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('admin.kategoris.create', ['active' => 'profil']);
    }

    /**
     * Store a new category.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:50', 'unique:kategoris,nama'],
            'icon' => ['nullable', 'string', 'max:255'],
        ]);

        Kategori::create($data);

        return redirect()->route('admin.kategoris.index')
            ->with('success', "Kategori {$data['nama']} berhasil dibuat.");
    }

    /**
     * Show the edit form.
     */
    public function edit(Kategori $kategori): View
    {
        return view('admin.kategoris.edit', [
            'kategori' => $kategori,
            'active'   => 'profil',
        ]);
    }

    /**
     * Update a category.
     */
    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:50', 'unique:kategoris,nama,' . $kategori->id],
            'icon' => ['nullable', 'string', 'max:255'],
        ]);

        $kategori->update($data);

        return redirect()->route('admin.kategoris.index')
            ->with('success', "Kategori {$data['nama']} diperbarui.");
    }

    /**
     * Delete a category.
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        $nama = $kategori->nama;
        $kategori->delete();

        return redirect()->route('admin.kategoris.index')
            ->with('success', "Kategori {$nama} dihapus.");
    }
}
