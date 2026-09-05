/**
 * Pasar Warga — Cart interactions.
 * Handles the "Tambah" buttons on product cards and the cart badge.
 */

(() => {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    /**
     * Update the cart badge in the top bar.
     */
    function updateBadge(count) {
        const badge = document.getElementById('cart-count-badge');
        const topbarCart = document.querySelector('.topbar__icon-btn[aria-label="Keranjang belanja"]');

        if (!topbarCart) return;

        let el = badge;
        if (!el) {
            el = document.createElement('span');
            el.id = 'cart-count-badge';
            el.className = 'topbar__badge';
            el.setAttribute('aria-label', 'item di keranjang');
            topbarCart.appendChild(el);
        }
        el.textContent = count;

        if (count > 0) {
            el.style.display = 'flex';
        } else {
            el.style.display = 'none';
        }
    }

    /**
     * POST a product to the cart via fetch.
     */
    async function addToCart(produkId, btn) {
        btn.disabled = true;
        try {
            const res = await fetch('/keranjang/tambah', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ produk_id: produkId, qty: 1 }),
            });

            const data = await res.json();

            if (!res.ok) {
                console.warn('Cart add failed:', data.error ?? res.statusText);
                return;
            }

            updateBadge(data.cart_count);

            // Micro-feedback
            const original = btn.innerHTML;
            btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> Ditambahkan';
            btn.style.background = 'var(--color-primary-deep)';
            setTimeout(() => {
                btn.innerHTML = original;
                btn.style.background = '';
            }, 1200);
        } catch (err) {
            console.warn('Cart add error:', err);
        } finally {
            btn.disabled = false;
        }
    }

    // Attach to all "Tambah" buttons
    document.querySelectorAll('[data-add-to-cart]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();
            const produkId = btn.dataset.produkId;
            if (!produkId) return;
            addToCart(produkId, btn);
        });
    });
})();
