<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller
{
    public function __construct(
        protected FileService $files,
    ) {}

    /**
     * List the seller's own products.
     */
    public function index(): View
    {
        $toko = auth()->user()->toko;
        abort_if(! $toko, 404);

        $produks = $toko->produks()->with('kategori')->latest()->paginate(20);

        return view('toko.produks.index', [
            'produks' => $produks,
            'active'  => 'pesanan',
        ]);
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('toko.produks.create', [
            'kategoris' => Kategori::orderBy('nama')->get(),
            'active'    => 'pesanan',
        ]);
    }

    /**
     * Store a new product.
     */
    public function store(Request $request): RedirectResponse
    {
        $toko = auth()->user()->toko;
        abort_if(! $toko, 404);

        $data = $this->validated($request);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->files->storeUpload($request->file('foto'), 'produks');
        }

        $toko->produks()->create([
            'kategori_id' => $data['kategori_id'],
            'nama_produk' => $data['nama_produk'],
            'deskripsi'   => $data['deskripsi'] ?? null,
            'harga'       => $data['harga'],
            'stok'        => $data['stok'],
            'foto'        => $fotoPath,
        ]);

        return redirect()->route('toko.produks.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the edit form.
     */
    public function edit(Produk $produk): View
    {
        $this->authorizeOwner($produk);

        return view('toko.produks.edit', [
            'produk'    => $produk,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'active'    => 'pesanan',
        ]);
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $data = $this->validated($request);

        $fotoPath = $produk->foto;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->files->replace($produk->foto, $request->file('foto'), 'produks');
        }

        $produk->update([
            'kategori_id' => $data['kategori_id'],
            'nama_produk' => $data['nama_produk'],
            'deskripsi'   => $data['deskripsi'] ?? null,
            'harga'       => $data['harga'],
            'stok'        => $data['stok'],
            'foto'        => $fotoPath,
        ]);

        return redirect()->route('toko.produks.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $this->files->delete($produk->foto);
        $produk->delete();

        return redirect()->route('toko.produks.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Ensure the product belongs to the authenticated seller's shop.
     */
    protected function authorizeOwner(Produk $produk): void
    {
        $toko = auth()->user()->toko;
        abort_if(! $toko || $produk->toko_id !== $toko->id, 403);
    }

    /**
     * Validate the product form.
     */
    protected function validated(Request $request): array
    {
        return $request->validate([
            'nama_produk' => ['required', 'string', 'max:100'],
            'deskripsi'   => ['nullable', 'string', 'max:2000'],
            'harga'       => ['required', 'integer', 'min:1'],
            'stok'        => ['required', 'integer', 'min:0'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'foto'        => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ]);
    }
}
