<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TokoController extends Controller
{
    public function __construct(
        protected FileService $files,
    ) {}

    /**
     * Show the shop profile form (create or edit for the current seller).
     */
    public function showForm(): View
    {
        $toko = auth()->user()->toko;

        return view('toko.profil', [
            'toko'   => $toko,
            'active' => 'profil',
        ]);
    }

    /**
     * Create the shop profile (first time onboarding).
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->files->storeUpload($request->file('foto'), 'tokos');
        }

        Toko::create([
            'user_id'   => auth()->id(),
            'nama_toko' => $data['nama_toko'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'lokasi'    => $data['lokasi'],
            'no_wa'     => $data['no_wa'] ?? null,
            'foto'      => $fotoPath,
            'status'    => 'pending',
        ]);

        return redirect()->route('toko.dashboard')
            ->with('success', 'Profil toko tersimpan. Toko kamu sedang menunggu persetujuan admin.');
    }

    /**
     * Update the shop profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $toko = auth()->user()->toko;
        abort_if(! $toko, 404);

        $data = $this->validated($request);

        $fotoPath = $toko->foto;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->files->replace($toko->foto, $request->file('foto'), 'tokos');
        }

        $toko->update([
            'nama_toko' => $data['nama_toko'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'lokasi'    => $data['lokasi'],
            'no_wa'     => $data['no_wa'] ?? null,
            'foto'      => $fotoPath,
        ]);

        return redirect()->route('toko.dashboard')
            ->with('success', 'Profil toko berhasil diperbarui.');
    }

    /**
     * Validate the shop profile form.
     */
    protected function validated(Request $request): array
    {
        return $request->validate([
            'nama_toko' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'lokasi'    => ['required', 'string', 'max:150'],
            'no_wa'     => ['nullable', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'foto'      => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ]);
    }
}
