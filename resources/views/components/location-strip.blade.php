<div class="location-strip" role="region" aria-label="Filter lokasi">
    <div class="container location-strip__inner">
        <button class="location-btn" id="btn-location" aria-haspopup="true" aria-expanded="false" type="button">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
            <span id="location-label">{{ $lokasi ?? 'Semua Lokasi' }}</span>
            <svg class="location-btn__caret" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </button>
    </div>
</div>