@extends('layouts.app')

@section('title', 'Grand Horizon Hotels — Where Every Stay Becomes a Story')

@section('extra_css')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    /* ═══════════════════════════════════════════
       GRAND HORIZON — Public Homepage
       Parchment · Gold · Deep Ink
    ═══════════════════════════════════════════ */

    :root {
        --ink:         #16100a;
        --ink-mid:     #2e1f0e;
        --ink-light:   #7a6a55;
        --ink-muted:   #a89880;
        --gold:        #c9a84c;
        --gold-pale:   #e8d48a;
        --gold-dim:    rgba(201,168,76,0.18);
        --cream:       #f6f1e9;
        --cream-mid:   #faf6ef;
        --white:       #ffffff;
        --green:       #2e7d4f;
        --red:         #8b3a2a;
        --radius:      10px;
        --font-serif:  'Cormorant Garamond', Georgia, serif;
        --font-sans:   'DM Sans', sans-serif;
        --ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { font-family: var(--font-sans); background: var(--white); color: var(--ink); overflow-x: hidden; }

    /* ── Utility ── */
    .visually-hidden { position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0,0,0,0); }
    img { display: block; max-width: 100%; }
    a { text-decoration: none; }

    /* ══════════════════════════════════════
       NAVBAR
    ══════════════════════════════════════ */
    .gh-nav {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 3rem;
        transition: background 0.4s var(--ease-smooth), box-shadow 0.4s;
    }

    .gh-nav.scrolled {
        background: rgba(22,16,10,0.96);
        backdrop-filter: blur(12px);
        box-shadow: 0 2px 24px rgba(0,0,0,0.3);
    }

    .nav-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .nav-monogram {
        font-family: var(--font-serif);
        font-size: 26px;
        font-weight: 300;
        color: var(--gold);
        letter-spacing: 3px;
        line-height: 1;
    }

    .nav-brandname {
        font-family: var(--font-serif);
        font-size: 14px;
        font-weight: 400;
        color: #f0e0c0;
        letter-spacing: 0.5px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 2rem;
        list-style: none;
    }

    .nav-links a {
        font-size: 12px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(240,224,192,0.75);
        transition: color 0.2s;
    }

    .nav-links a:hover { color: var(--gold); }

    .nav-cta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 22px;
        background: transparent;
        border: 1px solid rgba(201,168,76,0.5);
        color: var(--gold) !important;
        border-radius: 4px;
        font-size: 11px !important;
        letter-spacing: 2px !important;
        text-transform: uppercase !important;
        transition: background 0.2s, border-color 0.2s !important;
    }

    .nav-cta:hover {
        background: var(--gold) !important;
        color: var(--ink) !important;
        border-color: var(--gold) !important;
    }

    .nav-hamburger {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        flex-direction: column;
        gap: 5px;
        padding: 4px;
    }

    .nav-hamburger span {
        display: block;
        width: 22px;
        height: 1.5px;
        background: var(--gold);
        transition: transform 0.2s;
    }

    /* ══════════════════════════════════════
       HERO
    ══════════════════════════════════════ */
    .hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
    }

    .hero-slides {
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1.4s var(--ease-smooth);
        will-change: opacity;
        background-size: cover;
        background-position: center;
    }

    .hero-slide.active { opacity: 1; }

    .hero-slide::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(16,10,4,0.82) 0%,
            rgba(16,10,4,0.35) 50%,
            rgba(16,10,4,0.15) 100%
        );
    }

    .slide-1 { background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1800&q=80'); }
    .slide-2 { background-image: url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1800&q=80'); }
    .slide-3 { background-image: url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1800&q=80'); }
    .slide-4 { background-image: url('https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1800&q=80'); }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        padding: 0 3rem 5rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .hero-eyebrow {
        font-size: 10px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.8s 0.3s var(--ease-smooth) forwards;
    }

    .hero-eyebrow::before,
    .hero-eyebrow::after {
        content: '';
        flex: 0 0 32px;
        height: 1px;
        background: var(--gold);
        opacity: 0.5;
    }

    .hero-headline {
        font-family: var(--font-serif);
        font-size: clamp(46px, 7vw, 88px);
        font-weight: 300;
        color: #f5e6c8;
        line-height: 1.05;
        letter-spacing: -0.5px;
        max-width: 700px;
        opacity: 0;
        transform: translateY(24px);
        animation: fadeUp 0.9s 0.5s var(--ease-smooth) forwards;
    }

    .hero-headline em {
        font-style: italic;
        color: var(--gold-pale);
    }

    .hero-sub {
        font-size: 15px;
        color: rgba(240,220,190,0.65);
        margin-top: 1.25rem;
        max-width: 420px;
        line-height: 1.7;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.8s 0.7s var(--ease-smooth) forwards;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
        opacity: 0;
        transform: translateY(18px);
        animation: fadeUp 0.8s 0.9s var(--ease-smooth) forwards;
    }

    .btn-hero-primary {
        padding: 14px 32px;
        background: var(--gold);
        color: var(--ink);
        border: none;
        border-radius: 4px;
        font-family: var(--font-sans);
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-hero-primary:hover { background: var(--gold-pale); transform: translateY(-1px); }

    .btn-hero-ghost {
        padding: 14px 32px;
        background: transparent;
        color: rgba(240,220,190,0.8);
        border: 1px solid rgba(201,168,76,0.35);
        border-radius: 4px;
        font-family: var(--font-sans);
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-hero-ghost:hover { border-color: var(--gold); color: var(--gold); }

    .hero-dots {
        position: absolute;
        bottom: 2rem;
        right: 3rem;
        z-index: 3;
        display: flex;
        gap: 8px;
    }

    .hero-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(201,168,76,0.35);
        border: none;
        cursor: pointer;
        padding: 0;
        transition: background 0.3s, transform 0.2s;
    }

    .hero-dot.active {
        background: var(--gold);
        transform: scale(1.3);
    }

    .hero-counter {
        position: absolute;
        bottom: 2.1rem;
        left: 3rem;
        z-index: 3;
        font-size: 11px;
        letter-spacing: 2px;
        color: rgba(201,168,76,0.5);
        font-family: var(--font-serif);
    }

    .hero-counter strong { color: var(--gold); }

    /* ══════════════════════════════════════
       BOOKING BAR
    ══════════════════════════════════════ */
    .booking-bar-wrap {
        background: var(--ink);
        padding: 0 3rem;
    }

    .booking-bar {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        align-items: stretch;
        background: var(--ink);
        border: 1px solid rgba(201,168,76,0.15);
        border-top: none;
        border-radius: 0 0 12px 12px;
        overflow: hidden;
    }

    .booking-bar form {
        display: contents;
    }

    .booking-field {
        flex: 1;
        padding: 1.25rem 1.5rem;
        border-right: 1px solid rgba(201,168,76,0.12);
        display: flex;
        flex-direction: column;
        gap: 4px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .booking-field:hover { background: rgba(201,168,76,0.05); }

    .booking-field label {
        font-size: 9px;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: rgba(201,168,76,0.5);
        font-weight: 500;
        cursor: pointer;
        font-family: var(--font-sans);
    }

    .booking-field input,
    .booking-field select {
        background: transparent;
        border: none;
        outline: none;
        font-family: var(--font-sans);
        font-size: 14px;
        color: #f0e0c0;
        cursor: pointer;
        width: 100%;
        appearance: none;
        -webkit-appearance: none;
    }

    .booking-field input::placeholder { color: rgba(240,224,192,0.4); }
    .booking-field select option { background: var(--ink-mid); color: #f0e0c0; }

    /* Fix: date input calendar icon colour on dark bg */
    .booking-field input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.7) sepia(1) saturate(2) hue-rotate(5deg);
        cursor: pointer;
    }

    .booking-submit {
        padding: 1.5rem 2.5rem;
        background: var(--gold);
        border: none;
        color: var(--ink);
        font-family: var(--font-sans);
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .booking-submit:hover { background: var(--gold-pale); }

    /* ══════════════════════════════════════
       SECTION BASE
    ══════════════════════════════════════ */
    section { position: relative; }

    .section-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 3rem;
    }

    .section-head {
        text-align: center;
        margin-bottom: 3.5rem;
    }

    .section-eyebrow {
        font-size: 9.5px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold);
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        font-family: var(--font-sans);
    }

    .section-eyebrow::before,
    .section-eyebrow::after {
        content: '';
        display: block;
        width: 28px;
        height: 1px;
        background: var(--gold);
        opacity: 0.4;
    }

    .section-title {
        font-family: var(--font-serif);
        font-size: clamp(32px, 4vw, 52px);
        font-weight: 300;
        color: var(--ink);
        line-height: 1.15;
    }

    .section-title em { font-style: italic; color: var(--ink-mid); }

    .section-desc {
        font-size: 15px;
        color: var(--ink-light);
        line-height: 1.75;
        max-width: 520px;
        margin: 1rem auto 0;
    }

    /* ══════════════════════════════════════
       ABOUT STRIP
    ══════════════════════════════════════ */
    .about-strip {
        background: var(--cream);
        padding: 5rem 0;
    }

    .about-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 3rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5rem;
        align-items: center;
    }

    .about-image-group {
        position: relative;
        height: 480px;
    }

    .about-img-main {
        position: absolute;
        top: 0; left: 0;
        width: 75%;
        height: 85%;
        object-fit: cover;
        border-radius: 8px;
    }

    .about-img-accent {
        position: absolute;
        bottom: 0; right: 0;
        width: 52%;
        height: 52%;
        object-fit: cover;
        border-radius: 8px;
        border: 5px solid var(--white);
    }

    .about-award {
        position: absolute;
        top: 50%;
        left: 70%;
        transform: translate(-50%, -50%);
        background: var(--ink);
        border: 1px solid rgba(201,168,76,0.3);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        text-align: center;
        min-width: 100px;
    }

    .about-award-num {
        font-family: var(--font-serif);
        font-size: 36px;
        color: var(--gold);
        line-height: 1;
    }

    .about-award-label {
        font-size: 9px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(201,168,76,0.5);
        margin-top: 4px;
        font-family: var(--font-sans);
    }

    .about-text { padding: 1rem 0; }

    .about-headline {
        font-family: var(--font-serif);
        font-size: clamp(28px, 3.5vw, 44px);
        font-weight: 300;
        color: var(--ink);
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }

    .about-headline em { font-style: italic; }

    .about-body {
        font-size: 15px;
        color: var(--ink-light);
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .about-stats {
        display: flex;
        gap: 2.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .about-stat-num {
        font-family: var(--font-serif);
        font-size: 38px;
        color: var(--ink);
        line-height: 1;
    }

    .about-stat-label {
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-top: 4px;
    }

    .about-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold);
        font-weight: 500;
        border-bottom: 1px solid rgba(201,168,76,0.3);
        padding-bottom: 2px;
        transition: border-color 0.2s;
    }

    .about-link:hover { border-color: var(--gold); }

    /* ══════════════════════════════════════
       ROOM TYPES
    ══════════════════════════════════════ */
    .rooms-section {
        padding: 6rem 0;
        background: var(--white);
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .room-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        cursor: pointer;
    }

    .room-card:first-child { grid-row: span 2; }

    .room-img {
        width: 100%;
        height: 100%;
        min-height: 280px;
        object-fit: cover;
        display: block;
        transition: transform 0.7s var(--ease-smooth);
    }

    .room-card:first-child .room-img { min-height: 580px; }
    .room-card:hover .room-img { transform: scale(1.05); }

    .room-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(16,10,4,0.88) 0%, rgba(16,10,4,0.1) 60%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.75rem;
        transition: background 0.3s;
    }

    .room-card:hover .room-overlay {
        background: linear-gradient(to top, rgba(16,10,4,0.94) 0%, rgba(16,10,4,0.3) 60%);
    }

    .room-tag {
        font-size: 9px;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 0.4rem;
        font-family: var(--font-sans);
    }

    .room-name {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 400;
        color: #f5e6c8;
        line-height: 1.2;
        margin-bottom: 0.4rem;
    }

    .room-card:first-child .room-name { font-size: 30px; }

    .room-desc {
        font-size: 13px;
        color: rgba(240,220,190,0.6);
        line-height: 1.5;
        margin-bottom: 1rem;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s var(--ease-smooth);
    }

    .room-card:hover .room-desc { max-height: 80px; }

    .room-price-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
    }

    .room-price {
        font-family: var(--font-serif);
        font-size: 18px;
        color: var(--gold-pale);
    }

    .room-price span { font-size: 12px; color: rgba(201,168,76,0.5); }

    .room-btn {
        font-size: 10px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--gold);
        border: 1px solid rgba(201,168,76,0.4);
        padding: 7px 16px;
        border-radius: 4px;
        font-family: var(--font-sans);
        transition: background 0.2s, color 0.2s;
        display: inline-block;
    }

    .room-btn:hover { background: var(--gold); color: var(--ink); }

    /* ══════════════════════════════════════
       AMENITIES
    ══════════════════════════════════════ */
    .amenities-section {
        padding: 6rem 0;
        background: var(--cream);
        overflow: hidden;
    }

    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2px;
    }

    .amenity-card {
        background: var(--white);
        padding: 2.5rem 2rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
        transition: background 0.2s;
        border: 1px solid rgba(201,168,76,0.08);
    }

    .amenity-card:hover { background: var(--cream-mid); }

    .amenity-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--gold-dim);
        border-radius: 8px;
        color: var(--gold);
        font-size: 20px;
    }

    .amenity-name {
        font-family: var(--font-serif);
        font-size: 18px;
        color: var(--ink);
        line-height: 1.2;
    }

    .amenity-desc {
        font-size: 13px;
        color: var(--ink-light);
        line-height: 1.65;
        flex: 1;
    }

    .amenity-link {
        font-size: 10px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--gold);
        display: flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.2s;
    }

    .amenity-card:hover .amenity-link { gap: 9px; }

    /* ══════════════════════════════════════
       EXPERIENCE / PARALLAX BAND
    ══════════════════════════════════════ */
    .experience-band {
        position: relative;
        min-height: 520px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .experience-bg {
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1800&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .experience-bg::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(16,10,4,0.7);
    }

    .experience-content {
        position: relative;
        z-index: 1;
        max-width: 1400px;
        margin: 0 auto;
        padding: 5rem 3rem;
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .experience-headline {
        font-family: var(--font-serif);
        font-size: clamp(34px, 5vw, 62px);
        font-weight: 300;
        color: #f5e6c8;
        line-height: 1.1;
        margin-bottom: 1.5rem;
    }

    .experience-headline em {
        display: block;
        font-style: italic;
        color: var(--gold-pale);
    }

    .experience-body {
        font-size: 15px;
        color: rgba(240,220,190,0.65);
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .experience-features {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .experience-feat {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
        border: 1px solid rgba(201,168,76,0.15);
        border-radius: 8px;
        background: rgba(201,168,76,0.05);
        transition: background 0.2s;
    }

    .experience-feat:hover { background: rgba(201,168,76,0.1); }

    .feat-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: rgba(201,168,76,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold);
        font-size: 18px;
        flex-shrink: 0;
    }

    .feat-title {
        font-family: var(--font-serif);
        font-size: 17px;
        color: #f0e0c0;
        margin-bottom: 3px;
    }

    .feat-desc { font-size: 13px; color: rgba(240,220,190,0.55); line-height: 1.5; }

    /* ══════════════════════════════════════
       REVIEWS
    ══════════════════════════════════════ */
    .reviews-section {
        padding: 6rem 0;
        background: var(--white);
    }

    .reviews-track-wrap { overflow: hidden; }

    .reviews-track {
        display: flex;
        gap: 1.5rem;
        animation: reviewScroll 40s linear infinite;
        width: max-content;
    }

    .reviews-track:hover { animation-play-state: paused; }

    @keyframes reviewScroll {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    .review-card {
        background: var(--cream-mid);
        border: 1px solid rgba(201,168,76,0.12);
        border-radius: 10px;
        padding: 2rem;
        width: 340px;
        flex-shrink: 0;
        transition: border-color 0.2s;
    }

    .review-card:hover { border-color: rgba(201,168,76,0.35); }

    .review-stars {
        display: flex;
        gap: 3px;
        margin-bottom: 0.9rem;
        color: var(--gold);
        font-size: 13px;
    }

    .review-quote {
        font-family: var(--font-serif);
        font-size: 16px;
        color: var(--ink);
        line-height: 1.65;
        font-style: italic;
        margin-bottom: 1.25rem;
    }

    .review-author-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .review-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--ink-mid), var(--gold));
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-serif);
        font-size: 13px;
        color: #f5e6c8;
        flex-shrink: 0;
    }

    .review-name { font-size: 13px; font-weight: 500; color: var(--ink); }
    .review-meta { font-size: 11px; color: var(--ink-muted); }

    .reviews-score-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2.5rem;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .score-big {
        font-family: var(--font-serif);
        font-size: 80px;
        font-weight: 300;
        color: var(--ink);
        line-height: 1;
    }

    .score-right { display: flex; flex-direction: column; gap: 4px; }
    .score-stars { color: var(--gold); font-size: 18px; display: flex; gap: 3px; }
    .score-label { font-size: 12px; color: var(--ink-light); }
    .score-count { font-size: 11px; color: var(--ink-muted); }

    /* ══════════════════════════════════════
       GALLERY
    ══════════════════════════════════════ */
    .gallery-section {
        padding: 6rem 0;
        background: var(--cream);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: auto auto;
        gap: 6px;
    }

    .gallery-item {
        overflow: hidden;
        border-radius: 6px;
        position: relative;
    }

    .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
    .gallery-item:nth-child(5) { grid-column: span 2; }

    .gallery-img {
        width: 100%;
        height: 100%;
        min-height: 200px;
        object-fit: cover;
        display: block;
        transition: transform 0.6s var(--ease-smooth);
    }

    .gallery-item:nth-child(1) .gallery-img { min-height: 420px; }
    .gallery-item:hover .gallery-img { transform: scale(1.06); }

    /* ══════════════════════════════════════
       OFFERS / PACKAGES
    ══════════════════════════════════════ */
    .offers-section {
        padding: 6rem 0;
        background: var(--ink);
    }

    .offers-section .section-title { color: #f5e6c8; }
    .offers-section .section-desc { color: rgba(240,220,190,0.55); }

    .offers-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .offer-card {
        border: 1px solid rgba(201,168,76,0.15);
        border-radius: 10px;
        overflow: hidden;
        transition: border-color 0.2s, transform 0.2s;
        background: rgba(201,168,76,0.03);
    }

    .offer-card:hover {
        border-color: rgba(201,168,76,0.4);
        transform: translateY(-3px);
    }

    .offer-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }

    .offer-body { padding: 1.5rem; }

    .offer-tag {
        font-size: 9px;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .offer-tag::after {
        content: '';
        flex: 0 0 20px;
        height: 1px;
        background: var(--gold);
        opacity: 0.3;
    }

    .offer-title {
        font-family: var(--font-serif);
        font-size: 20px;
        color: #f5e6c8;
        line-height: 1.3;
        margin-bottom: 0.5rem;
    }

    .offer-desc { font-size: 13px; color: rgba(240,220,190,0.55); line-height: 1.65; margin-bottom: 1.25rem; }

    .offer-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .offer-price {
        font-family: var(--font-serif);
        font-size: 22px;
        color: var(--gold-pale);
    }

    .offer-price span { font-size: 12px; color: rgba(201,168,76,0.4); }

    .offer-btn {
        font-size: 10px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--gold);
        border: 1px solid rgba(201,168,76,0.35);
        padding: 8px 18px;
        border-radius: 4px;
        font-family: var(--font-sans);
        transition: background 0.2s, color 0.2s;
        display: inline-block;
    }

    .offer-btn:hover { background: var(--gold); color: var(--ink); }

    /* ══════════════════════════════════════
       NEWSLETTER
    ══════════════════════════════════════ */
    .newsletter-section {
        padding: 6rem 0;
        background: var(--cream);
        text-align: center;
    }

    .newsletter-box { max-width: 560px; margin: 0 auto; }

    .newsletter-form {
        display: flex;
        gap: 0;
        margin-top: 2rem;
        border: 1px solid rgba(201,168,76,0.25);
        border-radius: 6px;
        overflow: hidden;
    }

    .newsletter-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 0 1.25rem;
        font-family: var(--font-sans);
        font-size: 14px;
        color: var(--ink);
        background: var(--white);
    }

    .newsletter-input::placeholder { color: var(--ink-muted); }

    .newsletter-btn {
        padding: 15px 28px;
        background: var(--ink);
        color: var(--gold);
        border: none;
        font-family: var(--font-sans);
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .newsletter-btn:hover { background: var(--gold); color: var(--ink); }
    .newsletter-note { font-size: 11px; color: var(--ink-muted); margin-top: 1rem; }

    /* ══════════════════════════════════════
       FOOTER
    ══════════════════════════════════════ */
    .gh-footer {
        background: var(--ink);
        color: rgba(240,220,190,0.6);
        padding: 4rem 0 0;
    }

    .footer-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 3rem;
    }

    .footer-top {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr 1fr;
        gap: 3rem;
        padding-bottom: 3rem;
        border-bottom: 1px solid rgba(201,168,76,0.1);
    }

    .footer-logo {
        font-family: var(--font-serif);
        font-size: 28px;
        font-weight: 300;
        color: var(--gold);
        letter-spacing: 4px;
        margin-bottom: 0.75rem;
    }

    .footer-tagline {
        font-family: var(--font-serif);
        font-size: 15px;
        color: rgba(240,220,190,0.5);
        font-style: italic;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .footer-socials { display: flex; gap: 10px; }

    .social-btn {
        width: 34px;
        height: 34px;
        border-radius: 6px;
        border: 1px solid rgba(201,168,76,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(201,168,76,0.5);
        font-size: 14px;
        text-decoration: none;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
    }

    .social-btn:hover { border-color: var(--gold); color: var(--gold); background: rgba(201,168,76,0.08); }

    .footer-col-title {
        font-size: 10px;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: rgba(201,168,76,0.4);
        margin-bottom: 1.25rem;
        font-family: var(--font-sans);
    }

    .footer-links { list-style: none; display: flex; flex-direction: column; gap: 0.65rem; }

    .footer-links a {
        font-size: 13px;
        color: rgba(240,220,190,0.5);
        text-decoration: none;
        transition: color 0.2s;
    }

    .footer-links a:hover { color: var(--gold); }

    .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
        color: rgba(240,220,190,0.5);
        margin-bottom: 0.75rem;
        line-height: 1.5;
    }

    .footer-contact-item i { color: var(--gold); margin-top: 2px; flex-shrink: 0; }

    .footer-bottom {
        padding: 1.25rem 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .footer-copy { font-size: 12px; }
    .footer-legal { display: flex; gap: 1.5rem; }
    .footer-legal a { font-size: 12px; color: rgba(240,220,190,0.35); text-decoration: none; transition: color 0.2s; }
    .footer-legal a:hover { color: var(--gold); }

    /* ══════════════════════════════════════
       ANIMATIONS
    ══════════════════════════════════════ */
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.7s var(--ease-smooth), transform 0.7s var(--ease-smooth);
    }

    .reveal.visible { opacity: 1; transform: translateY(0); }

    .reveal-delay-1 { transition-delay: 0.1s; }
    .reveal-delay-2 { transition-delay: 0.2s; }
    .reveal-delay-3 { transition-delay: 0.3s; }
    .reveal-delay-4 { transition-delay: 0.4s; }

    /* ══════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════ */
    @media (max-width: 1100px) {
        .rooms-grid { grid-template-columns: repeat(2, 1fr); }
        .room-card:first-child { grid-row: span 1; }
        .room-card:first-child .room-img { min-height: 280px; }
        .amenities-grid { grid-template-columns: repeat(2, 1fr); }
        .footer-top { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 900px) {
        .about-inner { grid-template-columns: 1fr; }
        .about-image-group { height: 340px; }
        .experience-content { grid-template-columns: 1fr; gap: 2rem; }
        .offers-grid { grid-template-columns: 1fr; }
        .gallery-grid { grid-template-columns: repeat(2, 1fr); }
        .gallery-item:nth-child(1) { grid-column: span 2; }
        .gallery-item:nth-child(5) { grid-column: span 2; }
    }

    @media (max-width: 768px) {
        .section-inner,
        .about-inner,
        .footer-inner,
        .experience-content { padding-left: 1.5rem; padding-right: 1.5rem; }
        .gh-nav { padding: 1rem 1.5rem; }
        .hero-content { padding: 0 1.5rem 4rem; }
        .hero-counter, .hero-dots { left: 1.5rem; right: 1.5rem; }
        .nav-links { display: none; }
        .nav-links.open {
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(22,16,10,0.98);
            align-items: center;
            justify-content: center;
            gap: 2rem;
            z-index: 300;
        }
        .nav-links.open a { font-size: 16px; }
        .nav-hamburger { display: flex; }
        .booking-bar { flex-direction: column; border-radius: 0 0 8px 8px; }
        .booking-field { border-right: none; border-bottom: 1px solid rgba(201,168,76,0.12); }
        .rooms-grid { grid-template-columns: 1fr; }
        .amenities-grid { grid-template-columns: 1fr; }
        .footer-top { grid-template-columns: 1fr; }
        .footer-bottom { flex-direction: column; align-items: flex-start; }
    }

    @media (prefers-reduced-motion: reduce) {
        .reviews-track { animation: none; }
        .hero-slide { transition: none; }
        .reveal { transition: none; }
        * { animation-duration: 0.01ms !important; }
    }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════
     NAVBAR
══════════════════════════════════════ --}}
<nav class="gh-nav" id="ghNav" aria-label="Main navigation">
    <a href="/" class="nav-brand" aria-label="Grand Horizon Hotels home">
        <span class="nav-monogram">GH</span>
        <span class="nav-brandname">Grand Horizon Hotels</span>
    </a>

    <ul class="nav-links" id="navLinks">
        <li><a href="#rooms">Rooms</a></li>
        <li><a href="#amenities">Amenities</a></li>
        <li><a href="#experiences">Experiences</a></li>
        <li><a href="#offers">Offers</a></li>
        <li><a href="#">Contact</a></li>
        <li>
                <a href="#book" class="nav-cta">
                    <i class="fas fa-calendar-check" style="font-size:10px"></i>
                    Book Now
                </a>
            </li>
    </ul>

    <button class="nav-hamburger" id="navHamburger" aria-label="Open menu" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</nav>

{{-- ══════════════════════════════════════
     HERO SLIDER
══════════════════════════════════════ --}}
<section class="hero" aria-label="Featured hotel photography">
    <div class="hero-slides" aria-hidden="true">
        <div class="hero-slide slide-1 active"></div>
        <div class="hero-slide slide-2"></div>
        <div class="hero-slide slide-3"></div>
        <div class="hero-slide slide-4"></div>
    </div>

    <div class="hero-content">
        <p class="hero-eyebrow">Est. 1932 · Five star excellence</p>
        <h1 class="hero-headline">
            Where luxury<br><em>finds its home</em>
        </h1>
        <p class="hero-sub">
            Eighteen curated properties across twelve cities — each one a masterwork of design, service, and setting.
        </p>
        <div class="hero-actions">
            <a href="#book" class="btn-hero-primary">
                Reserve your stay
                <i class="fas fa-arrow-right" style="font-size:10px"></i>
            </a>
            <a href="#rooms" class="btn-hero-ghost">
                Explore rooms
            </a>
        </div>
    </div>

    <div class="hero-counter" aria-live="polite">
        <strong id="heroSlideNum">01</strong> / 04
    </div>

    <div class="hero-dots" role="tablist" aria-label="Slide navigation">
        <button class="hero-dot active" role="tab" aria-label="Slide 1" aria-selected="true"  data-index="0"></button>
        <button class="hero-dot"        role="tab" aria-label="Slide 2" aria-selected="false" data-index="1"></button>
        <button class="hero-dot"        role="tab" aria-label="Slide 3" aria-selected="false" data-index="2"></button>
        <button class="hero-dot"        role="tab" aria-label="Slide 4" aria-selected="false" data-index="3"></button>
    </div>
</section>

{{-- ══════════════════════════════════════
     BOOKING BAR
══════════════════════════════════════ --}}
<div class="booking-bar-wrap">
    <div class="booking-bar">
        <form action="#" method="GET" aria-label="Quick booking" onsubmit="return false;">
            <div class="booking-field">
                <label for="bk-checkin">Check-in</label>
                <input type="date" id="bk-checkin" name="start_date"
                       min="{{ date('Y-m-d') }}"
                       value="{{ request('start_date') }}"
                       aria-label="Check-in date">
            </div>
            <div class="booking-field">
                <label for="bk-checkout">Check-out</label>
                <input type="date" id="bk-checkout" name="end_date"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       value="{{ request('end_date') }}"
                       aria-label="Check-out date">
            </div>
            <div class="booking-field">
                <label for="bk-guests">Guests</label>
                <select id="bk-guests" name="adults" aria-label="Number of guests">
                    <option value="1">1 adult</option>
                    <option value="2" selected>2 adults</option>
                    <option value="3">3 adults</option>
                    <option value="4">4 adults</option>
                </select>
            </div>
            <div class="booking-field">
                <label for="bk-room-type">Room type</label>
                <select id="bk-room-type" name="room_type_id" aria-label="Room type">
                    <option value="">Any type</option>
                    @foreach($roomTypes ?? [] as $rt)
                        <option value="{{ $rt->id }}">{{ $rt->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="booking-submit">
                <i class="fas fa-search" style="font-size:12px"></i>
                Check availability
            </button>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════
     ABOUT
══════════════════════════════════════ --}}
<section class="about-strip" aria-labelledby="about-heading">
    <div class="about-inner">
        <div class="about-image-group reveal">
            <img class="about-img-main"
                 src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=900&q=80"
                 alt="Grand Horizon lobby interior"
                 loading="lazy">
            <img class="about-img-accent"
                 src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=600&q=80"
                 alt="Grand Horizon suite detail"
                 loading="lazy">
            <div class="about-award" aria-label="28 years of excellence">
                <div class="about-award-num">28</div>
                <div class="about-award-label">Years of<br>excellence</div>
            </div>
        </div>

        <div class="about-text">
            <p class="section-eyebrow reveal">Our story</p>
            <h2 class="about-headline reveal reveal-delay-1" id="about-heading">
                More than a stay —<br>
                <em>a memory made</em>
            </h2>
            <p class="about-body reveal reveal-delay-2">
                Founded in Cairo in 1996, Grand Horizon Hotels has grown into one of the region's most celebrated
                luxury hospitality groups. Each property is a statement of place — designed around its city,
                its culture, and the guests who make it their home away from home.
            </p>
            <div class="about-stats reveal reveal-delay-2">
                <div>
                    <div class="about-stat-num">18</div>
                    <div class="about-stat-label">Properties</div>
                </div>
                <div>
                    <div class="about-stat-num">12</div>
                    <div class="about-stat-label">Cities</div>
                </div>
                <div>
                    <div class="about-stat-num">4.9</div>
                    <div class="about-stat-label">Guest rating</div>
                </div>
            </div>
            <a href="#" class="about-link reveal reveal-delay-3">
                Discover our story
                <i class="fas fa-arrow-right" style="font-size:10px"></i>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     ROOMS
══════════════════════════════════════ --}}
<section class="rooms-section" id="rooms" aria-labelledby="rooms-heading">
    <div class="section-inner">
        <div class="section-head">
            <p class="section-eyebrow reveal">Accommodations</p>
            <h2 class="section-title reveal reveal-delay-1" id="rooms-heading">
                Rooms crafted for <em>rest</em>
            </h2>
            <p class="section-desc reveal reveal-delay-2">
                From tranquil garden-view studios to sprawling penthouse suites — every room is a sanctuary.
            </p>
        </div>

        <div class="rooms-grid">
            @php
                $fallbackRooms = [
                    ['name' => 'Presidential Suite',   'tag' => 'Suite',      'price' => '850',  'img' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=900&q=80', 'desc' => 'A full-floor retreat with panoramic city views, private dining, and butler service.'],
                    ['name' => 'Deluxe King',           'tag' => 'Deluxe',     'price' => '320',  'img' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=700&q=80', 'desc' => 'Spacious and serene, with handpicked furnishings and floor-to-ceiling windows.'],
                    ['name' => 'Garden View Double',    'tag' => 'Standard',   'price' => '210',  'img' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=700&q=80', 'desc' => 'Wake to the sound of water features and lush tropical gardens.'],
                    ['name' => 'Penthouse Collection',  'tag' => 'Penthouse',  'price' => '1400', 'img' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=700&q=80', 'desc' => 'Private pool, personal chef arrangement, and skyline views that define the city.'],
                    ['name' => 'Junior Suite',          'tag' => 'Suite',      'price' => '490',  'img' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=700&q=80', 'desc' => 'A generous suite with separate living quarters, ideal for extended stays.'],
                ];
                $displayRooms = isset($roomTypes) && $roomTypes->count() ? $roomTypes->take(5) : collect($fallbackRooms);
            @endphp

            @foreach($displayRooms as $i => $rt)
            <article class="room-card reveal" style="transition-delay: {{ $i * 0.08 }}s"
                     aria-label="{{ is_array($rt) ? $rt['name'] : $rt->title }}">
                <img class="room-img"
                     src="{{ is_array($rt) ? $rt['img'] : ($rt->cover_image_url ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=900&q=80') }}"
                     alt="{{ is_array($rt) ? $rt['name'] : $rt->title }}"
                     loading="lazy">
                <div class="room-overlay">
                    <p class="room-tag">{{ is_array($rt) ? $rt['tag'] : 'Room type' }}</p>
                    <h3 class="room-name">{{ is_array($rt) ? $rt['name'] : $rt->title }}</h3>
                    <p class="room-desc">{{ is_array($rt) ? $rt['desc'] : ($rt->description ?? '') }}</p>
                    <div class="room-price-row">
                        <div class="room-price">
                            ${{ is_array($rt) ? $rt['price'] : ($rt->base_price ?? '—') }}
                            <span>/ night</span>
                        </div>
                        <a href="#book"
                           class="room-btn">Book now</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     AMENITIES
══════════════════════════════════════ --}}
<section class="amenities-section" id="amenities" aria-labelledby="amenities-heading">
    <div class="section-inner">
        <div class="section-head">
            <p class="section-eyebrow reveal">Hotel amenities</p>
            <h2 class="section-title reveal reveal-delay-1" id="amenities-heading">
                Everything you <em>need</em>
            </h2>
            <p class="section-desc reveal reveal-delay-2">World-class facilities, available from the moment you arrive.</p>
        </div>
    </div>
    <div class="amenities-grid">
        @php
            $amenities = [
                ['icon' => 'fa-swimmer',       'name' => 'Infinity pool',    'desc' => 'An all-season rooftop pool with panoramic views, heated year-round and surrounded by private cabanas.'],
                ['icon' => 'fa-utensils',      'name' => 'Fine dining',      'desc' => 'Five award-winning restaurants spanning Mediterranean, Asian, and contemporary cuisines.'],
                ['icon' => 'fa-spa',           'name' => 'Horizon Spa',      'desc' => 'A 2,400 sqm sanctuary offering personalised treatments, steam rooms, and silent meditation spaces.'],
                ['icon' => 'fa-dumbbell',      'name' => 'Fitness centre',   'desc' => 'State-of-the-art equipment, personal training, and daily fitness classes overlooking the city.'],
                ['icon' => 'fa-concierge-bell','name' => '24h Concierge',    'desc' => 'Our concierge team is on hand around the clock to arrange anything you might need.'],
                ['icon' => 'fa-wine-glass-alt','name' => 'Rooftop bar',      'desc' => 'Craft cocktails and rare wines served at golden hour on our signature sky terrace.'],
                ['icon' => 'fa-briefcase',     'name' => 'Business centre',  'desc' => 'Fully equipped meeting rooms and event spaces, from intimate board rooms to grand ballrooms.'],
                ['icon' => 'fa-car',           'name' => 'Valet parking',    'desc' => 'Complimentary valet and covered secure parking available for all hotel guests.'],
            ];
        @endphp

        @foreach($amenities as $i => $a)
        <div class="amenity-card reveal" style="transition-delay: {{ ($i % 4) * 0.1 }}s">
            <div class="amenity-icon" aria-hidden="true">
                <i class="fas {{ $a['icon'] }}"></i>
            </div>
            <h3 class="amenity-name">{{ $a['name'] }}</h3>
            <p class="amenity-desc">{{ $a['desc'] }}</p>
            <a href="#" class="amenity-link" aria-label="Learn more about {{ $a['name'] }}">
                Learn more
                <i class="fas fa-arrow-right" style="font-size:9px"></i>
            </a>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════
     EXPERIENCE BAND
══════════════════════════════════════ --}}
<section class="experience-band" id="experiences" aria-labelledby="exp-heading">
    <div class="experience-bg" aria-hidden="true"></div>
    <div class="experience-content">
        <div>
            <p class="section-eyebrow reveal" style="justify-content:flex-start;color:var(--gold)">The Grand Horizon difference</p>
            <h2 class="experience-headline reveal reveal-delay-1" id="exp-heading">
                Crafted<br>for the<br><em>discerning guest</em>
            </h2>
            <p class="experience-body reveal reveal-delay-2">
                We believe a hotel stay should be an experience that stays with you long after checkout.
                Every touchpoint — from the thread count of your linens to the temperature of your welcome towel —
                is considered, curated, and perfected.
            </p>
            <a href="#" class="btn-hero-ghost reveal reveal-delay-3" style="display:inline-flex">
                Explore experiences
            </a>
        </div>

        <div class="experience-features reveal reveal-delay-2">
            @php
                $features = [
                    ['icon' => 'fa-user-tie',     'title' => 'Personal butler',   'desc' => 'Every suite guest is assigned a dedicated butler, available around the clock.'],
                    ['icon' => 'fa-glass-cheers', 'title' => 'Welcome ritual',    'desc' => 'A bespoke arrival ceremony with regional flavours and seasonal offerings.'],
                    ['icon' => 'fa-moon',         'title' => 'Turndown service',  'desc' => 'Thoughtful evening preparation so your room is perfect when you return.'],
                    ['icon' => 'fa-heart',        'title' => 'Guest preferences', 'desc' => 'We remember your preferences — so every return visit feels like coming home.'],
                ];
            @endphp

            @foreach($features as $f)
            <div class="experience-feat">
                <div class="feat-icon" aria-hidden="true"><i class="fas {{ $f['icon'] }}"></i></div>
                <div>
                    <div class="feat-title">{{ $f['title'] }}</div>
                    <div class="feat-desc">{{ $f['desc'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     REVIEWS
══════════════════════════════════════ --}}
<section class="reviews-section" aria-labelledby="reviews-heading">
    <div class="section-inner">
        <div class="section-head">
            <p class="section-eyebrow reveal">Guest reviews</p>
            <h2 class="section-title reveal reveal-delay-1" id="reviews-heading">
                What our guests <em>say</em>
            </h2>
        </div>

        <div class="reviews-score-row reveal">
            <div class="score-big" aria-label="4.9 out of 5">4.9</div>
            <div class="score-right">
                <div class="score-stars" aria-hidden="true">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="score-label">Exceptional</div>
                <div class="score-count">Based on 2,840 verified stays</div>
            </div>
        </div>
    </div>

    <div class="reviews-track-wrap" aria-label="Guest reviews carousel">
        <div class="reviews-track" role="list">
            @php
                $reviews = [
                    ['quote' => 'Every detail was perfect. The room was exactly as described, the service was impeccable, and the breakfast is something I still think about.', 'name' => 'Sarah M.', 'meta' => 'Presidential Suite, Cairo',       'initials' => 'SM'],
                    ['quote' => 'I have stayed in many five-star hotels across the world, and Grand Horizon is genuinely a cut above. The spa alone is worth the trip.',          'name' => 'James O.', 'meta' => 'Penthouse Collection, Dubai',    'initials' => 'JO'],
                    ['quote' => 'The concierge arranged a private dinner on the rooftop for our anniversary. It was beyond anything we imagined. Simply extraordinary.',          'name' => 'Lena K.',  'meta' => 'Junior Suite, Beirut',            'initials' => 'LK'],
                    ['quote' => 'Clean, elegant, and genuinely warm service. The staff remembered my name from check-in to departure — every single time.',                      'name' => 'Omar F.', 'meta' => 'Deluxe King, Alexandria',          'initials' => 'OF'],
                    ['quote' => 'The infinity pool at sunset is simply spectacular. I have already booked my return trip. Grand Horizon sets a standard others aspire to.',       'name' => 'Priya N.','meta' => 'Garden View Double, Cairo',       'initials' => 'PN'],
                    ['quote' => 'Business travel will never be the same. The meeting facilities are superb, and being able to decompress at the spa afterwards makes all the difference.', 'name' => 'Tom H.', 'meta' => 'Deluxe King, Riyadh', 'initials' => 'TH'],
                ];
                $allReviews = array_merge($reviews, $reviews); // duplicate for seamless loop
            @endphp

            @foreach($allReviews as $r)
            <div class="review-card" role="listitem">
                <div class="review-stars" aria-label="5 stars">
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                </div>
                <blockquote class="review-quote">&ldquo;{{ $r['quote'] }}&rdquo;</blockquote>
                <div class="review-author-row">
                    <div class="review-avatar" aria-hidden="true">{{ $r['initials'] }}</div>
                    <div>
                        <div class="review-name">{{ $r['name'] }}</div>
                        <div class="review-meta">{{ $r['meta'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     GALLERY
══════════════════════════════════════ --}}
<section class="gallery-section" aria-labelledby="gallery-heading">
    <div class="section-inner">
        <div class="section-head">
            <p class="section-eyebrow reveal">Gallery</p>
            <h2 class="section-title reveal reveal-delay-1" id="gallery-heading">A glimpse inside</h2>
        </div>
    </div>
    <div style="max-width:1400px;margin:0 auto;padding:0 3rem">
        <div class="gallery-grid reveal">
            <div class="gallery-item"><img class="gallery-img" src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=900&q=80"  alt="Hotel suite panoramic view"  loading="lazy"></div>
            <div class="gallery-item"><img class="gallery-img" src="https://images.unsplash.com/photo-1540541338287-41700207dee6?w=600&q=80"  alt="Hotel pool terrace"          loading="lazy"></div>
            <div class="gallery-item"><img class="gallery-img" src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80"  alt="Fine dining restaurant"      loading="lazy"></div>
            <div class="gallery-item"><img class="gallery-img" src="https://images.unsplash.com/photo-1600334129128-685c5582fd35?w=600&q=80"  alt="Spa treatment room"          loading="lazy"></div>
            <div class="gallery-item"><img class="gallery-img" src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=900&q=80"  alt="Hotel lobby at night"        loading="lazy"></div>
            <div class="gallery-item"><img class="gallery-img" src="https://images.unsplash.com/photo-1559599101-f09722fb4948?w=600&q=80"     alt="Cocktail bar"                loading="lazy"></div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     OFFERS
══════════════════════════════════════ --}}
<section class="offers-section" id="offers" aria-labelledby="offers-heading">
    <div class="section-inner">
        <div class="section-head">
            <p class="section-eyebrow reveal" style="color:rgba(201,168,76,0.5)">Exclusive offers</p>
            <h2 class="section-title reveal reveal-delay-1" id="offers-heading">
                Tailored <em>packages</em>
            </h2>
            <p class="section-desc reveal reveal-delay-2" style="color:rgba(240,220,190,0.5)">
                Curated experiences and preferential rates for our most valued guests.
            </p>
        </div>

        <div class="offers-grid">
            @php
                $offers = [
                    ['tag' => 'Romantic escape', 'title' => 'Honeymoon & Anniversary', 'desc' => 'Champagne on arrival, couples spa treatment, and a private rooftop dinner. Complimentary room upgrade where available.', 'price' => '640', 'img' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=700&q=80'],
                    ['tag' => 'Long stay',        'title' => 'Extended Stay Rate',      'desc' => 'Stay seven nights or more and receive 20% off your total booking, including daily breakfast and airport transfers.',    'price' => '280', 'img' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=700&q=80'],
                    ['tag' => 'Corporate',        'title' => 'Business Traveller',      'desc' => 'Dedicated workspace, priority breakfast, pressing service, and late checkout — everything a busy traveller needs.',     'price' => '320', 'img' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=700&q=80'],
                ];
            @endphp

            @foreach($offers as $i => $o)
            <article class="offer-card reveal" style="transition-delay: {{ $i * 0.12 }}s">
                <img class="offer-img" src="{{ $o['img'] }}" alt="{{ $o['title'] }}" loading="lazy">
                <div class="offer-body">
                    <p class="offer-tag">{{ $o['tag'] }}</p>
                    <h3 class="offer-title">{{ $o['title'] }}</h3>
                    <p class="offer-desc">{{ $o['desc'] }}</p>
                    <div class="offer-footer">
                        <div class="offer-price">
                            ${{ $o['price'] }} <span>/ night from</span>
                        </div>
                        <a href="#book" class="offer-btn">Book offer</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     NEWSLETTER
══════════════════════════════════════ --}}
<section class="newsletter-section" aria-labelledby="newsletter-heading">
    <div class="section-inner">
        <div class="newsletter-box reveal">
            <p class="section-eyebrow" style="justify-content:center">Stay in touch</p>
            <h2 class="section-title" id="newsletter-heading">
                Exclusive rates, <em>delivered</em>
            </h2>
            <p class="section-desc" style="margin:0.75rem auto 0">
                Join our guest list for priority access to new properties, seasonal offers, and curated travel inspiration.
            </p>
            <form action="#" method="POST" class="newsletter-form" aria-label="Newsletter subscription">
                @csrf
                <label for="nl-email" class="visually-hidden">Your email address</label>
                <input type="email" id="nl-email" name="email"
                       class="newsletter-input"
                       placeholder="Your email address"
                       required>
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
            <p class="newsletter-note">No spam. Unsubscribe at any time.</p>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     FOOTER
══════════════════════════════════════ --}}
<footer class="gh-footer" aria-label="Site footer">
    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-brand-col">
                <div class="footer-logo" aria-label="Grand Horizon Hotels">GH</div>
                <p class="footer-tagline">
                    Where every stay<br>becomes a story worth telling.
                </p>
                <div class="footer-socials">
                    <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-btn" aria-label="Twitter / X"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div>
                <p class="footer-col-title">Hotel</p>
                <ul class="footer-links">
                    <li><a href="#rooms">Our rooms</a></li>
                    <li><a href="#amenities">Amenities</a></li>
                    <li><a href="#offers">Offers</a></li>
                    <li><a href="#">Dining</a></li>
                    <li><a href="#">Spa</a></li>
                    <li><a href="#">Events</a></li>
                </ul>
            </div>

            <div>
                <p class="footer-col-title">Information</p>
                <ul class="footer-links">
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Sustainability</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div>
                <p class="footer-col-title">Contact us</p>
                <address style="font-style:normal">
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        <span>12 Nile Corniche, Garden City<br>Cairo, Egypt 11511</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <a href="tel:+20221234567" style="color:inherit">+20 2 2123 4567</a>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <a href="mailto:reservations@grandhorizon.com" style="color:inherit">reservations@grandhorizon.com</a>
                    </div>
                </address>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copy">&copy; {{ date('Y') }} Grand Horizon Hotels. All rights reserved.</p>
            <nav class="footer-legal" aria-label="Legal links">
                <a href="#">Privacy policy</a>
                <a href="#">Terms of use</a>
                <a href="#">Cookie settings</a>
            </nav>
        </div>
    </div>
</footer>

@endsection

@section('extra_js')
<script>
(function () {
    'use strict';

    /* ── Navbar scroll behaviour ── */
    var nav = document.getElementById('ghNav');
    window.addEventListener('scroll', function () {
        nav.classList.toggle('scrolled', window.scrollY > 60);
    }, { passive: true });

    /* ── Mobile nav toggle ── */
    var hamburger = document.getElementById('navHamburger');
    var navLinks  = document.getElementById('navLinks');

    hamburger.addEventListener('click', function () {
        var open = navLinks.classList.toggle('open');
        hamburger.setAttribute('aria-expanded', open);
    });

    navLinks.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () {
            navLinks.classList.remove('open');
            hamburger.setAttribute('aria-expanded', 'false');
        });
    });

    /* ── Hero slider ── */
    var slides   = document.querySelectorAll('.hero-slide');
    var dots     = document.querySelectorAll('.hero-dot');
    var counter  = document.getElementById('heroSlideNum');
    var current  = 0;
    var slideInt = null;

    function goToSlide(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        dots[current].setAttribute('aria-selected', 'false');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
        dots[current].setAttribute('aria-selected', 'true');
        counter.textContent = String(current + 1).padStart(2, '0');
    }

    function startAuto() {
        slideInt = setInterval(function () { goToSlide(current + 1); }, 5500);
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            clearInterval(slideInt);
            goToSlide(parseInt(this.dataset.index, 10));
            startAuto();
        });
    });

    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        startAuto();
    }

    /* ── Booking bar: keep end_date after start_date ── */
    var checkin  = document.getElementById('bk-checkin');
    var checkout = document.getElementById('bk-checkout');
    if (checkin && checkout) {
        checkin.addEventListener('change', function () {
            var next = new Date(this.value);
            next.setDate(next.getDate() + 1);
            var nextStr = next.toISOString().split('T')[0];
            checkout.min = nextStr;
            if (!checkout.value || checkout.value <= this.value) {
                checkout.value = nextStr;
            }
        });
    }

    /* ── Scroll reveal ── */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('visible'); });
    }

    /* ── Smooth scroll for anchor links ── */
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

})();
</script>
@endsection