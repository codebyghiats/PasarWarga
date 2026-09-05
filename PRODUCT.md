# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

**Primary: Warga (residents)** — people living near local SMEs, browsing on mobile while on the go or at home, looking for everyday items (food, snacks, household goods) from sellers in their immediate neighborhood. Likely to arrive without an account and transact via WhatsApp rather than through a formal checkout.

**Secondary: Pemilik Toko (SME owners)** — small local business operators, often individuals with no existing online presence, who manage their shop profile and product listings through a dashboard. More likely to use on desktop.

**Platform admin** — manages category taxonomy and approves new shop registrations.

## Product Purpose

Pasar Warga is a hyperlocal directory and marketplace that connects residents with small businesses (UMKM) in their own neighborhood. It exists because most micro-local SMEs have zero discoverable online presence, meaning potential buyers who live nearby simply never find them. Success means a resident can discover, browse, and initiate contact with a local seller in under one minute — without the seller having to compete on a national platform.

## Positioning

Pasar Warga is the only discovery channel that is intentionally neighborhood-scoped. A seller on Pasar Warga is not competing with sellers across Indonesia — they are the answer for a buyer who wants something from someone nearby. This hyperlocal constraint is the product's irreplaceable mechanism; it cannot be truthfully copied by Shopee, Tokopedia, or any national marketplace.

## Operating Context

- Warga: casual mobile browsing, often impulse-driven — discovers nearby products, adds to cart, and places orders directly in-app. WhatsApp is available as a secondary contact channel to reach the seller, not the primary transaction path.
- Pemilik Toko: occasional but important sessions — registering a shop, managing products and stock, confirming or rejecting incoming orders. Dashboard must surface pending orders prominently.
- Admin: infrequent moderation tasks — approving or rejecting pending shop registrations, managing product categories.
- The platform owns the transaction: warga places an order in-app, the seller confirms/rejects in their dashboard. WhatsApp remains as a supplementary contact option per seller.

## Capabilities and Constraints

- **Tech stack (confirmed):** Laravel 10/11, MySQL, Blade + Tailwind CSS v4, Laravel Breeze (auth), Vite.
- **Roles:** `admin`, `pemilik_toko`, `warga`, and unauthenticated guest (read-only catalog access).
- **Core entities:** users, tokos (shops), kategoris (categories), produks (products), pesanans (orders), optional ulasans (reviews).
- **Shop approval flow:** new shops start as `pending` and are invisible in the public catalog until an admin approves them.
- **On-platform ordering (confirmed):** Warga adds items to cart → fills checkout form (nama, alamat pengiriman, catatan) → order submitted to seller. Seller confirms or rejects from their dashboard. This is the primary transaction flow.
- **WhatsApp as contact (not transaction):** each seller profile shows a WhatsApp contact link; this is a secondary channel for questions, not the order mechanism.
- **No payment gateway in current scope:** payment method is undecided (COD / transfer manual assumed unless specified).
- **Planned hosting:** Google Cloud Compute Engine (e2-micro, Always Free tier).
- **Current build state:** early scaffold — only `welcome.blade.php` and `User` model exist; all features are to be built.

## Brand Commitments

- Name **"Pasar Warga"** is fixed.
- No existing logo, color palette, or typography constraints — the visual world is fully open for design.

## Evidence on Hand

- `panduan.md`: step-by-step build guide covering all phases through deployment.
- `fitur-halaman.md`: complete feature list, role/permission matrix, ERD, sitemap, and user flows.
- No real content, testimonials, imagery, or press assets exist yet. Future work must not fabricate any.

## Product Principles

1. **Neighborhood first.** Every feature decision must reinforce the hyperlocal constraint — never let the platform accidentally feel national or impersonal.
2. **Owned transactions.** The platform handles the full order loop — discovery, cart, checkout, confirmation — end to end. WhatsApp is a contact supplement, not a crutch.
3. **Minimal friction for sellers.** Local SME owners are not tech-savvy power users. Every seller-facing screen should feel approachable to someone listing their first product online, confirming orders without a manual process.
4. **Mobile-ready for buyers.** Warga will browse on phones in everyday moments. Discovery, cart, and checkout flows must be fast, thumb-friendly, and completable in under two minutes.
5. **Trust through locality.** The platform's credibility comes from genuine neighborhood proximity, transparent order status, and seller responsiveness — not ratings counts or brand polish.

## Accessibility & Inclusion

No specific accessibility standard has been committed to. Given the mobile-primary audience and the likelihood of older or less tech-savvy users among SME owners, designs should favor high contrast, large touch targets, and clear Indonesian-language labels.
