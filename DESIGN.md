<!-- SEED: established with the user before implementation; re-run /impeccable document once there's code to capture the actual tokens and components. -->

---
name: Pasar Warga
description: Hyperlocal Indonesian neighborhood marketplace — discover, order, connect.
---

# Design System: Pasar Warga

## Overview

**Creative North Star: "The Clean Warung Counter"**

Pasar Warga is designed the way a well-run modern warung is arranged: everything you need is in front of you, uncluttered, immediately legible, with just enough warmth to remind you this is your neighborhood. The interface is a working tool, not a showroom. The visitor's job — find something nearby, add it to their order, done — should be completable without thought. Decoration earns no space here.

The palette is a committed emerald green on a near-white ground: the green of fresh produce, of the WhatsApp bubble warga already trust, of a shop awning on a sunny morning. It appears where action is needed and nowhere else. The ground is cool off-white, never cream, because this is an operating surface used in daylight on a phone screen. Typography is clean and unpretentious, with one strong weight step between headings and body — confident, not corporate.

Mobile is the primary scene. The layout is thumb-friendly at every level: large tap targets, a bottom tab bar within thumb reach, 2-column product grids that scan fast. Desktop exists as a wider, still-simple version of the same model.

**Key Characteristics:**
- Off-white (#FAFAFA) working surface; emerald (#059669) as the single committed accent
- Generous vertical spacing; tight internal card padding
- One font family, two weights (400 body, 700 headings)
- Depth through subtle shadows, never decorative halos
- Bottom tab navigation on mobile; no top hamburger menus
- Emerald used only for primary actions, active states, and prices — never decoratively

## Colors

The palette is Committed: one saturated accent (emerald) against a neutral off-white ground. No secondary palette. The accent's rarity is its authority.

### Primary
- **Fresh Market Emerald** (`#059669`): The single accent color. Used for primary buttons ("Tambah", "Pesan", "Checkout"), active tab indicators, price displays, and active category pills. Appears nowhere decoratively.
- **Deep Emerald** (`#047857`): Hover and pressed state for the primary accent. Also used for the wordmark.

### Neutral
- **Page Ground** (`#FAFAFA`): Background for all page surfaces. Cool, not warm.
- **Card Surface** (`#FFFFFF`): Product cards, shop cards, and modals. Pure white so cards lift from the ground.
- **Primary Text** (`#111827`): All headings and body text. Near-black for maximum contrast on white.
- **Secondary Text** (`#6B7280`): Shop names below product names, metadata, timestamps, labels.
- **Border / Divider** (`#E5E7EB`): Card outlines, section dividers, input borders at rest.
- **Input Ground** (`#F9FAFB`): Background fill inside search bar and form inputs at rest.
- **Disabled** (`#D1D5DB`): Disabled buttons and placeholder text.

### Named Rules
**The One Green Rule.** Emerald (#059669) appears in exactly four contexts: primary action buttons, active state indicators, price text, and the wordmark. If a screen has emerald in a fifth place, remove it from the weakest one.

**The White Card Rule.** Product and shop cards are always pure white (#FFFFFF) on the #FAFAFA page ground. Never tint cards with the accent color; depth comes from the shadow, not from hue.

## Typography

**Display / Heading Font:** Plus Jakarta Sans (Google Fonts), with system-ui, sans-serif fallback  
**Body Font:** Plus Jakarta Sans (same family, weight 400)

**Character:** Plus Jakarta Sans reads as modern and Indonesian-friendly without the corporate stiffness of Inter or the startup cliché of DM Sans. A single family in two weights keeps the system tightly controlled. No serif faces; this is a working tool.

### Hierarchy
- **Display** (700, 28–32px, 1.2 line-height): Page-level headlines ("Belanja dari tetanggamu"). One per screen.
- **Headline** (700, 20–24px, 1.3): Section headings ("Produk Terbaru", "Toko Dekatmu"). Bold, clear entry points.
- **Title** (700, 16–18px, 1.4): Product names and shop names in cards. Same weight as Headline, smaller size.
- **Body** (400, 14–16px, 1.6): Product descriptions, form labels, general copy. Max line length 65–75ch on desktop.
- **Label** (500, 12–13px, 1.4, slightly tracked): Category pill text, badge labels, tab bar items. Medium weight, never uppercase.
- **Price** (700, 16–18px, 1.2): Product prices in emerald (#059669). Same scale as Title but colored.

### Named Rules
**The No Uppercase Rule.** Labels, pills, tab items, and section headers are sentence-case or title-case. Tracked uppercase is not part of this system.

## Layout

Mobile-first. The base layout is a single column within a max-width container (390px on mobile, 1024px centered on desktop). The bottom tab bar (56px tall) is always visible on mobile and creates the primary navigation layer.

**Grid:** Product and shop listings use a 2-column CSS grid on mobile (column gap 12px, row gap 16px). On desktop (≥768px), the product grid expands to 4 columns.

**Spacing rhythm:** 16px base unit. Internal card padding: 12px. Section vertical gaps: 24px between sections. Heading-to-content: 12px below a heading. Content-to-next-heading: 24px above.

**Page regions (mobile):**
- Top bar (56px): wordmark left, cart icon + avatar right
- Location strip (36px): location pill + category filter row
- Scrollable content: hero headline → search bar → category pills → product/shop sections
- Bottom tab bar (56px, fixed): Beranda · Kategori · Pesanan · Profil

**No sidebar on mobile.** Filtering happens in a bottom sheet modal or inline pill row, never a sidebar.

## Elevation & Depth

Flat at rest; lifted on cards and interactive elements. Depth is ambient and structural, never decorative. No colored shadow halos.

### Shadow Vocabulary
- **Card Rest** (`box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06)`): All product and shop cards at rest. Soft, ambient, barely perceptible lift.
- **Card Hover** (`box-shadow: 0 4px 12px rgba(0,0,0,0.12)`): Cards on hover (desktop). More lift, same color family.
- **Bottom Tab Bar** (`box-shadow: 0 -1px 0 #E5E7EB`): A single hairline border above the tab bar. No blur; depth is structural, not atmospheric.
- **Search Bar** (`box-shadow: 0 1px 4px rgba(0,0,0,0.08)`): Subtle, present, not floating.

### Named Rules
**The Flat-By-Default Rule.** Surfaces are flat at rest. Shadows appear only on cards (always) and as state feedback (hover). No element has a shadow purely for decoration.

## Shapes

Consistently rounded, never sharp, never pill-shaped at scale. The corner language is warm but functional.

- **Cards** (product, shop): `border-radius: 12px`
- **Buttons (primary)**: `border-radius: 8px`
- **Category pills / chips**: `border-radius: 20px` (fully rounded, thumb-friendly)
- **Search bar**: `border-radius: 10px`
- **Inputs (form fields)**: `border-radius: 8px`
- **Bottom tab bar**: square top edge (no radius); it meets the screen edge
- **Avatar / shop photos in circles**: `border-radius: 50%`

**No sharp (0px) corners anywhere.** No fully squared elements except the tab bar edge.

## Do's and Don'ts

### Do:
- **Do** use emerald (#059669) for every primary action button — "Tambah ke Keranjang", "Pesan Sekarang", "Checkout".
- **Do** show prices in emerald, formatted as "Rp 15.000" with Indonesian thousand-separator dots.
- **Do** use 2-column product grids on mobile and 4-column on desktop (≥768px).
- **Do** keep card internal padding at 12px and section gaps at 24px.
- **Do** use Plus Jakarta Sans 700 for all headings; 400 for body.
- **Do** show the bottom tab bar on all mobile pages; never hide it during scroll.

### Don't:
- **Don't** use emerald decoratively — backgrounds, borders, dividers, or illustrative elements are off-limits for the accent color.
- **Don't** use gradient text. Weight and size provide emphasis.
- **Don't** use uppercase labels or tracked eyebrows above section headings.
- **Don't** nest cards inside cards. A product card inside a shop card section is fine; a card wrapping another card is not.
- **Don't** use a hamburger menu on mobile. Navigation lives in the bottom tab bar.
- **Don't** use glass/blur as decoration. Blur appears only in intentional surface-level overlays (e.g., a bottom-sheet backdrop).
- **Don't** animate product images on hover — animate the card container (shadow lift, subtle scale) instead.
