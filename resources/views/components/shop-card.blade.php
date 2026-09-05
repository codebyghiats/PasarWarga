<a href="{{ route('tokos.show', $toko) }}" class="shop-card" role="listitem" aria-label="{{ $toko->nama_toko }}">
    <div class="shop-card__avatar">
        @if($toko->foto)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($toko->foto) }}" alt="{{ $toko->nama_toko }}">
        @else
            <div style="width:100%;height:100%;background:var(--color-page);display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
        @endif
    </div>
    <p class="shop-card__name">{{ $toko->nama_toko }}</p>
    <span class="shop-card__category">{{ $toko->produks->first()?->kategori?->nama ?? 'Toko' }}</span>
    <span class="shop-card__meta">{{ $toko->lokasi }}</span>
</a>