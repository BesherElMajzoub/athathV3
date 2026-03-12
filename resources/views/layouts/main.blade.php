<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ===== SEO Core ===== --}}
    <title>@yield('title', 'شراء أثاث مستعمل بجدة | أفضل الأسعار والخدمات')</title>
    <meta name="description" content="@yield('meta_description', 'نشتري الأثاث المستعمل في جدة بأفضل الأسعار. تواصل معنا للتقييم والتسعير الفوري.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- ===== Open Graph (WhatsApp sharing) ===== --}}
    <meta property="og:site_name" content="{{ config('app.name', 'أثاث جدة') }}">
    <meta property="og:title" content="@yield('title', 'شراء أثاث مستعمل بجدة')">
    <meta property="og:description" content="@yield('meta_description', 'نشتري الأثاث المستعمل في جدة بأفضل الأسعار.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:locale" content="ar_SA">
    <meta property="og:image" content="@yield('og_image', asset(config('business.og_image', '/assets/og-default.jpg')))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'شراء أثاث مستعمل بجدة')">

    {{-- ===== Twitter / X Card ===== --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'شراء أثاث مستعمل بجدة')">
    <meta name="twitter:description" content="@yield('meta_description', 'نشتري الأثاث المستعمل في جدة بأفضل الأسعار.')">
    <meta name="twitter:image" content="@yield('og_image', asset(config('business.og_image', '/assets/og-default.jpg')))">

    {{-- ===== Favicons ===== --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#2F6B3F">

    {{-- ===== Schema ===== --}}
    @stack('schema')

    {{-- ===== Fonts ===== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">

    <style>
        /* ====== Variables ====== */
        :root {
            --primary: #2F6B3F;
            --primary-hover: #245632;
            --secondary: #6FAF7B;
            --mint: #BFE7CF;
            --bg: #F6FBF7;
            --surface: #FFFFFF;
            --text: #123018;
            --muted: #5D6F62;
            --border: rgba(18, 48, 24, .08);
            --shadow: 0 10px 30px rgba(18, 48, 24, .06);
            --shadow-lg: 0 20px 50px rgba(18, 48, 24, .1);
            --radius: 20px;
            --radius-sm: 12px;
            --radius-pill: 999px;
            --font: 'Tajawal', sans-serif;
        }

        /* ====== Reset ====== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ====== Utility ====== */
        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        .section {
            padding: 5rem 0;
        }

        .section-sm {
            padding: 3rem 0;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: var(--muted);
        }

        /* ====== Typography ====== */
        .section-badge {
            display: inline-block;
            background: var(--mint);
            color: var(--primary);
            font-size: .8rem;
            font-weight: 700;
            padding: .35rem 1rem;
            border-radius: var(--radius-pill);
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            font-weight: 900;
            color: var(--text);
            line-height: 1.25;
            margin-bottom: .75rem;
        }

        .section-desc {
            font-size: 1.05rem;
            color: var(--muted);
            max-width: 640px;
            margin: 0 auto 2.5rem;
            line-height: 1.8;
        }

        /* ====== Buttons ====== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .8rem 1.8rem;
            border-radius: var(--radius-pill);
            font-weight: 700;
            font-size: .95rem;
            font-family: var(--font);
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all .25s ease;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            box-shadow: 0 8px 25px rgba(47, 107, 63, .3);
        }

        /* WhatsApp Official */
        .btn-whatsapp {
            background: #25d366;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .btn-whatsapp svg {
            flex-shrink: 0;
        }

        .btn-whatsapp:hover {
            background: #1fba59;
            box-shadow: 0 8px 25px rgba(37, 211, 102, .3);
        }

        .btn-call {
            background: var(--secondary);
            color: #fff;
        }

        .btn-call:hover {
            background: #5ea06a;
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid rgba(47, 107, 63, .2);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            background: rgba(47, 107, 63, .05);
        }

        .btn-light {
            background: rgba(255, 255, 255, .15);
            color: #fff;
            backdrop-filter: blur(4px);
        }

        .btn-light:hover {
            background: rgba(255, 255, 255, .25);
        }

        /* ====== Header ====== */
        .site-header {
            background: rgba(255, 255, 255, .94);
            border-bottom: 1px solid var(--border);
            padding: .75rem 0;
            position: sticky;
            top: 0;
            z-index: 200;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        /* Logo */
        .site-logo {
            font-size: 1.3rem;
            font-weight: 900;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-shrink: 0;
        }

        .site-logo .logo-icon {
            width: 38px;
            height: 38px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-icon svg {
            width: 22px;
            height: 22px;
        }

        .site-logo .logo-text {
            line-height: 1.1;
        }

        .site-logo .logo-sub {
            font-size: .65rem;
            font-weight: 500;
            color: var(--muted);
            display: block;
        }

        /* Nav */
        .site-nav {
            display: flex;
            align-items: center;
            gap: .2rem;
        }

        .site-nav a {
            text-decoration: none;
            color: var(--muted);
            font-weight: 500;
            font-size: .88rem;
            padding: .45rem .75rem;
            border-radius: var(--radius-sm);
            transition: all .2s;
            white-space: nowrap;
        }

        .site-nav a:hover,
        .site-nav a.active {
            color: var(--primary);
            background: rgba(47, 107, 63, .06);
        }

        .nav-cta {
            background: var(--primary) !important;
            color: #fff !important;
            padding: .5rem 1.1rem !important;
            border-radius: var(--radius-pill) !important;
            font-size: .85rem !important;
        }

        .nav-cta:hover {
            background: var(--primary-hover) !important;
            transform: translateY(-1px);
        }

        /* Hamburger */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            cursor: pointer;
            color: var(--text);
            padding: .3rem;
            line-height: 1;
        }

        @media(max-width:900px) {
            .nav-toggle {
                display: block;
            }

            .site-nav {
                display: none;
                position: absolute;
                top: 100%;
                right: 0;
                left: 0;
                background: var(--surface);
                flex-direction: column;
                align-items: stretch;
                padding: .75rem 1rem 1rem;
                border-bottom: 1px solid var(--border);
                box-shadow: var(--shadow);
                gap: .25rem;
            }

            .site-nav.open {
                display: flex;
            }

            .site-nav a {
                padding: .75rem 1rem;
                font-size: .95rem;
            }

            .nav-cta {
                text-align: center;
            }
        }

        /* ====== Cards ====== */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: all .3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .card-flat {
            box-shadow: none;
        }

        .card-flat:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        /* ====== Grid ====== */
        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        @media(max-width:900px) {
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:560px) {

            .grid-4,
            .grid-3,
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* ====== Hero ====== */
        .hero {
            background: radial-gradient(circle at 15% 20%, #D9F1E3 0%, #F6FBF7 55%, #FFFFFF 100%);
            padding: 4rem 0 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(191, 231, 207, .4), transparent 70%);
            top: -150px;
            left: -100px;
            border-radius: 50%;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border: 3px solid rgba(47, 107, 63, .08);
            border-radius: 50%;
            bottom: -80px;
            right: 10%;
            pointer-events: none;
        }

        .hero-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 900;
            color: var(--text);
            line-height: 1.2;
            margin-bottom: 1.25rem;
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--muted);
            line-height: 1.8;
            margin-bottom: 2rem;
            max-width: 520px;
        }

        .hero-btns {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .hero-ring {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-ring-circle {
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--mint) 0%, #e8f5ed 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 30px 60px rgba(47, 107, 63, .12);
        }

        .hero-ring-circle::before {
            content: '';
            position: absolute;
            inset: -16px;
            border-radius: 50%;
            border: 2px dashed rgba(47, 107, 63, .15);
        }

        .hero-ring-inner {
            font-size: 5rem;
            line-height: 1;
        }

        .hero-badges {
            position: absolute;
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }

        .hero-badge {
            background: var(--surface);
            border-radius: var(--radius-sm);
            padding: .55rem 1rem;
            font-size: .8rem;
            font-weight: 700;
            color: var(--text);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: .5rem;
            white-space: nowrap;
        }

        .hero-badge-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
        }

        .badge-green {
            background: rgba(47, 107, 63, .1);
            color: var(--primary);
        }

        .badge-mint {
            background: rgba(191, 231, 207, .5);
            color: var(--primary);
        }

        @media(max-width:900px) {
            .hero {
                padding: 2.5rem 0 2rem;
            }

            .hero-inner {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero p {
                margin: 0 auto 2rem;
            }

            .hero-btns {
                justify-content: center;
            }

            .hero-ring {
                display: none;
            }
        }

        /* ====== Service Cards ====== */
        .service-card {
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .service-card .card-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--mint), #e8f5ed);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .service-card h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .5rem;
        }

        .service-card p {
            font-size: .9rem;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 1rem;
        }

        .service-card .card-link {
            font-size: .85rem;
            font-weight: 700;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        /* ====== FAQ ====== */
        .faq-card {
            border-radius: var(--radius);
            overflow: hidden;
        }

        .faq-card details {
            border-bottom: 1px solid var(--border);
        }

        .faq-card details:last-child {
            border-bottom: none;
        }

        .faq-card summary {
            padding: 1.25rem 1.5rem;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            list-style: none;
            transition: background .2s;
        }

        .faq-card summary::-webkit-details-marker {
            display: none;
        }

        .faq-card summary::after {
            content: '+';
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--muted);
        }

        .faq-card details[open] summary::after {
            content: '−';
            color: var(--primary);
        }

        .faq-card details[open] summary {
            background: rgba(191, 231, 207, .15);
            color: var(--primary);
        }

        .faq-card .faq-answer {
            padding: 0 1.5rem 1.25rem;
            color: var(--muted);
            line-height: 1.8;
            font-size: .95rem;
        }

        /* ====== Contact ====== */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: stretch;
        }

        @media(max-width:768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }

        .contact-btn {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 600;
            transition: all .2s;
        }

        .contact-btn:hover {
            transform: translateX(-4px);
        }

        .contact-btn-wa {
            background: rgba(37, 211, 102, .1);
            color: #166534;
        }

        .contact-btn-call {
            background: rgba(47, 107, 63, .08);
            color: var(--primary);
        }

        .contact-btn-faq {
            background: rgba(191, 231, 207, .3);
            color: var(--primary);
        }

        .contact-btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-form .form-group {
            margin-bottom: 1rem;
        }

        .contact-form label {
            display: block;
            font-weight: 600;
            font-size: .85rem;
            margin-bottom: .4rem;
        }

        .contact-form input,
        .contact-form textarea,
        .contact-form select {
            width: 100%;
            padding: .75rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: var(--font);
            font-size: .9rem;
            background: var(--bg);
            transition: border .2s;
        }

        .contact-form input:focus,
        .contact-form textarea:focus,
        .contact-form select:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
        }

        /* ====== CTA Banner ====== */
        .cta-banner {
            background: linear-gradient(135deg, var(--primary) 0%, #3d8a52 100%);
            color: #fff;
            border-radius: var(--radius);
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
            top: -100px;
            left: -50px;
        }

        .cta-banner h2 {
            font-size: 1.8rem;
            font-weight: 900;
            margin-bottom: .75rem;
            position: relative;
        }

        .cta-banner p {
            font-size: 1.05rem;
            opacity: .9;
            margin-bottom: 2rem;
            position: relative;
        }

        /* ====== YouTube Section ====== */
        .yt-trigger {
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            cursor: pointer;
            background: #000;
            aspect-ratio: 16/9;
            display: block;
            width: 100%;
        }

        .yt-trigger img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: opacity .3s;
        }

        .yt-trigger:hover img {
            opacity: .8;
        }

        .yt-play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 72px;
            height: 72px;
            background: rgba(255, 0, 0, .9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .25s, background .25s;
            pointer-events: none;
        }

        .yt-trigger:hover .yt-play-btn {
            background: rgba(255, 0, 0, 1);
            transform: translate(-50%, -50%) scale(1.1);
        }

        .yt-play-btn svg {
            width: 28px;
            height: 28px;
            fill: #fff;
            margin-right: -3px;
        }

        .yt-iframe-wrapper {
            aspect-ratio: 16/9;
            border-radius: var(--radius);
            overflow: hidden;
        }

        .yt-iframe-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        /* ====== Floating CTAs ====== */
        .floating-cta {
            position: fixed;
            bottom: 1.5rem;
            left: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: .6rem;
            z-index: 300;
        }

        .float-btn {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .6rem 1rem;
            border-radius: var(--radius-pill);
            color: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .18);
            font-size: .82rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .25s;
            max-width: 195px;
            white-space: nowrap;
        }

        .float-btn:hover {
            transform: scale(1.04);
            box-shadow: 0 10px 28px rgba(0, 0, 0, .22);
        }

        .float-btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(255, 255, 255, .2);
            font-size: 1rem;
        }

        .float-wa {
            background: #25d366;
        }

        .float-call {
            background: var(--primary);
        }

        @media(max-width:560px) {
            .float-btn span {
                display: none;
            }

            .float-btn {
                padding: 0;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                justify-content: center;
                max-width: none;
            }

            .float-btn-icon {
                width: 100%;
                height: 100%;
                background: transparent;
            }
        }

        /* ====== Footer ====== */
        .site-footer {
            background: var(--text);
            color: rgba(255, 255, 255, .6);
            padding: 3rem 0 1.5rem;
        }

        .footer-inner {
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media(max-width:900px) {
            .footer-inner {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:560px) {
            .footer-inner {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        .footer-brand {
            font-size: 1.2rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .footer-col h4 {
            color: #fff;
            font-size: .85rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: .5rem;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .footer-col a {
            display: block;
            color: rgba(255, 255, 255, .55);
            text-decoration: none;
            font-size: .88rem;
            padding: .25rem 0;
            transition: color .2s;
        }

        .footer-col a:hover {
            color: var(--mint);
        }

        .footer-col .footer-ext-link {
            color: rgba(255, 255, 255, .4);
            font-size: .8rem;
        }

        .footer-map-wrap {
            border-radius: var(--radius-sm);
            overflow: hidden;
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 */
            height: 0;
            margin-top: .5rem;
        }

        .footer-map-wrap iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .footer-contact-btn {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: rgba(255, 255, 255, .7);
            text-decoration: none;
            font-size: .88rem;
            padding: .4rem 0;
            transition: color .2s;
        }

        .footer-contact-btn:hover {
            color: #fff;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .1);
            padding-top: 1.25rem;
            text-align: center;
            font-size: .82rem;
        }

        /* ====== Breadcrumb ====== */
        .breadcrumb {
            font-size: .85rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* ====== Links Bar ====== */
        .links-bar {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem;
            justify-content: center;
        }

        .links-bar a {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-pill);
            padding: .5rem 1.1rem;
            font-size: .82rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            transition: all .2s;
        }

        .links-bar a:hover {
            background: var(--mint);
            border-color: var(--mint);
        }

        /* ====== About Preview ====== */
        .about-preview {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        @media(max-width:768px) {
            .about-preview {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        .about-points {
            display: flex;
            flex-direction: column;
            gap: .75rem;
            margin: 1.5rem 0;
        }

        .about-point {
            display: flex;
            align-items: center;
            gap: .75rem;
            font-size: .95rem;
            font-weight: 500;
            color: var(--text);
        }

        .about-point-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            flex-shrink: 0;
            background: rgba(191, 231, 207, .5);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .about-visual {
            background: linear-gradient(135deg, #D9F1E3, #BFE7CF);
            border-radius: var(--radius);
            padding: 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .about-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, .3), transparent 60%);
        }

        .about-visual .about-emoji {
            font-size: 5rem;
            display: block;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .about-stat {
            background: rgba(255, 255, 255, .8);
            border-radius: var(--radius-sm);
            padding: .75rem 1.25rem;
            display: inline-block;
            font-weight: 900;
            font-size: 1.3rem;
            color: var(--primary);
            margin: .3rem;
            backdrop-filter: blur(4px);
        }

        .about-stat small {
            display: block;
            font-size: .75rem;
            font-weight: 500;
            color: var(--muted);
        }

        /* ====== Animation ====== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp .6s ease both;
        }

        /* ====== Mobile Fixes ====== */
        @media(max-width:560px) {
            .section {
                padding: 3rem 0;
            }

            .section-sm {
                padding: 2rem 0;
            }

            .card {
                padding: 1.25rem;
            }

            .cta-banner {
                padding: 2rem 1.25rem;
            }

            .cta-banner h2 {
                font-size: 1.4rem;
            }

            .floating-cta {
                bottom: 1rem;
                left: 1rem;
            }

            .hero-btns .btn {
                font-size: .85rem;
                padding: .7rem 1.25rem;
            }
        }
    </style>
    @stack('head')
</head>

<body>

    <header class="site-header">
        <div class="container header-inner">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="site-logo" aria-label="شراء اثاث مستعمل - الرئيسية">
                <span class="logo-icon" aria-hidden="true"
                    style="font-size:1.4rem;background:var(--primary);border-radius:10px;width:38px;height:38px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">🪑</span>
                <span class="logo-text">
                    {{ config('app.name') }}
                    <span class="logo-sub">أعلى الأسعار في جدة</span>
                </span>
            </a>

            <button class="nav-toggle"
                onclick="const n=document.querySelector('.site-nav');n.classList.toggle('open');this.setAttribute('aria-expanded',n.classList.contains('open'));"
                aria-label="القائمة" aria-expanded="false">
                ☰
            </button>

            <nav class="site-nav" role="navigation" aria-label="التنقل الرئيسي">
                <a href="{{ route('home') }}" @if (request()->routeIs('home')) class="active" @endif>الرئيسية</a>
                <a href="{{ route('about') }}" @if (request()->routeIs('about')) class="active" @endif>من نحن</a>
                <a href="{{ route('services.index') }}"
                    @if (request()->routeIs('services.*')) class="active" @endif>الخدمات</a>
                <a href="{{ route('districts.index') }}" @if (request()->routeIs('districts.*')) class="active" @endif>أحياء
                    جدة</a>
                <a href="{{ url('/blog') }}" @if (request()->is('blog*')) class="active" @endif>المدونة</a>
                <a href="{{ route('faq') }}" @if (request()->routeIs('faq')) class="active" @endif>الأسئلة
                    الشائعة</a>
                <a href="{{ route('contact') }}" @if (request()->routeIs('contact')) class="active" @endif>اتصل بنا</a>
                <a href="https://wa.me/{{ config('business.whatsapp') }}" class="nav-cta"
                    rel="nofollow noopener noreferrer" target="_blank" data-track="navbar_whatsapp_click"
                    data-placement="navbar" data-target="https://wa.me/{{ config('business.whatsapp') }}"
                    style="display:inline-flex;align-items:center;gap:.35rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    واتساب
                </a>
            </nav>
        </div>
    </header>

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="site-footer" aria-label="تذييل الموقع">
        <div class="container">
            <div class="footer-inner">

                {{-- Col 1: About --}}
                <div>
                    <div class="footer-brand">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="color:#BFE7CF">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        أثاث جدة الموثوق
                    </div>
                    <p style="font-size:.88rem;line-height:1.8;max-width:320px;">
                        مؤسسة سعودية متخصصة في شراء جميع أنواع الأثاث والأجهزة المستعملة في مدينة جدة. تقييم عادل، دفع
                        فوري، فك ونقل مجاني.
                    </p>
                    <a href="{{ route('about') }}"
                        style="display:inline-block;margin-top:1rem;color:var(--mint);font-size:.85rem;font-weight:600;text-decoration:none;">
                        اقرأ المزيد عنا ←
                    </a>
                </div>

                {{-- Col 2: Services --}}
                <div class="footer-col">
                    <h4>خدماتنا</h4>
                    <a href="{{ url('/services/شراء-اثاث-مستعمل-بجدة') }}">شراء أثاث مستعمل</a>
                    <a href="{{ url('/services/شراء-مكيفات-مستعملة-بجدة') }}">شراء مكيفات</a>
                    <a href="{{ url('/services/شراء-مطابخ-مستعملة-بجدة') }}">شراء مطابخ</a>
                    <a href="{{ url('/services/شراء-اجهزة-مستعملة-بجدة') }}">شراء أجهزة</a>
                    <a href="{{ url('/services/شراء-عفش-مستعمل-بجدة') }}">شراء عفش</a>
                    <a href="{{ url('/services/شراء-سكراب-بجدة') }}">شراء سكراب</a>
                    <a href="{{ url('/services/شراء-معدات-مطاعم-مستعملة-بجدة') }}">معدات مطاعم</a>
                </div>

                {{-- Col 3: Quick Links + Contact --}}
                <div class="footer-col">
                    <h4>روابط سريعة</h4>
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('about') }}">من نحن</a>
                    <a href="{{ route('services.index') }}">جميع الخدمات</a>
                    <a href="{{ route('districts.index') }}">أحياء جدة</a>
                    <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                    <a href="{{ route('contact') }}">تواصل معنا</a>
                    <a href="{{ url('/blog') }}">المدونة</a>
                    @if (config('business.external_footer_link_url'))
                        <a href="{{ config('business.external_footer_link_url') }}"
                            rel="nofollow noopener noreferrer" target="_blank" class="footer-ext-link">
                            {{ config('business.external_footer_link_label', 'رابط خارجي') }} ↗
                        </a>
                    @endif
                </div>

                {{-- Col 4: Map + Contact --}}
                <div class="footer-col">
                    <h4>موقعنا وتواصل</h4>
                    <a href="https://wa.me/{{ config('business.whatsapp') }}" class="footer-contact-btn"
                        rel="nofollow noopener noreferrer" target="_blank" data-track="footer_whatsapp_click"
                        data-placement="footer" data-target="https://wa.me/{{ config('business.whatsapp') }}">
                        💬 <span>واتساب</span>
                    </a>
                    <a href="tel:{{ config('business.phone') }}" class="footer-contact-btn"
                        data-track="footer_call_click" data-placement="footer"
                        data-target="tel:{{ config('business.phone') }}">
                        📞 <span>{{ config('business.phone') }}</span>
                    </a>
                    <a href="{{ route('contact') }}" class="footer-contact-btn">
                        📧 <span>راسلنا</span>
                    </a>
                    {{-- Google Map embed --}}
                    <div class="footer-map-wrap" style="margin-top:1rem;">
                        <iframe src="{{ config('business.google_maps_embed') }}" title="موقعنا على الخريطة - جدة"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen>
                        </iframe>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <p>© {{ date('Y') }} مؤسسة شراء الأثاث المستعمل بجدة. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    {{-- Floating CTAs --}}
    <div class="floating-cta" aria-label="أزرار التواصل السريع">
        <a href="https://wa.me/{{ config('business.whatsapp') }}" class="float-btn float-wa"
            rel="nofollow noopener noreferrer" data-track="float_whatsapp_click" data-placement="float"
            data-target="https://wa.me/{{ config('business.whatsapp') }}" aria-label="أرسل الصور من هنا">
            <span class="float-btn-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
            </span>
            <span>أرسل الصور من هنا</span>
        </a>
        <a href="tel:{{ config('business.phone') }}" class="float-btn float-call" data-track="float_call_click"
            data-placement="float" data-target="tel:{{ config('business.phone') }}" aria-label="اتصل بنا">
            <span class="float-btn-icon">📞</span>
            <span>اتصل الآن</span>
        </a>
    </div>

    {{-- ================================================================
     GLOBAL TRACKING SCRIPT
     Uses navigator.sendBeacon (mobile-safe) + fetch keepalive fallback
     Attached via data-track attribute — no inline onclick needed
     ================================================================ --}}
    <script>
        (function() {
            var ENDPOINT = '/api/track/click';
            var isMobile = /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);

            function sendClick(el) {
                var evt = el.getAttribute('data-track');
                var place = el.getAttribute('data-placement') || '';
                var target_url = el.getAttribute('data-target') || el.href || '';

                if (!evt) return;

                var data = {
                    event_type: evt,
                    page_url: window.location.href,
                    placement: place,
                    target_url: target_url,
                    meta_data: {
                        device_hint: isMobile ? 'mobile' : 'desktop'
                    }
                };

                var payload = JSON.stringify(data);

                // Option 1: sendBeacon (most reliable for navigating away)
                if (navigator.sendBeacon) {
                    var blob = new Blob([payload], {
                        type: 'application/json'
                    });
                    if (navigator.sendBeacon(ENDPOINT, blob)) return;
                }

                // Option 2: fetch keepalive
                if (window.fetch) {
                    fetch(ENDPOINT, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: payload,
                        keepalive: true
                    }).catch(function() {});
                    return;
                }

                // Option 3: Fallback Pixel (GET) for very old browsers
                var img = new Image();
                var params = new URLSearchParams({
                    event_type: data.event_type,
                    page_url: data.page_url,
                    placement: data.placement,
                    target_url: data.target_url
                });
                img.src = ENDPOINT + '?' + params.toString();
            }

            function attachTracking() {
                var trackedElements = document.querySelectorAll('[data-track]');

                for (var i = 0; i < trackedElements.length; i++) {
                    var el = trackedElements[i];
                    // Skip if already attached
                    if (el.__tracking_attached) continue;

                    el.addEventListener('click', function(e) {
                        // We do not prevent default to avoid blocking user flow.
                        // sendBeacon or keepalive will run in background.
                        sendClick(this);
                    });

                    el.__tracking_attached = true;
                }
            }

            // Run on DOM loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', attachTracking);
            } else {
                attachTracking();
            }

            // Observe dynamic elements
            if (window.MutationObserver) {
                var observer = new MutationObserver(function(mutations) {
                    var shouldAttach = false;
                    for (var i = 0; i < mutations.length; i++) {
                        if (mutations[i].addedNodes.length > 0) {
                            shouldAttach = true;
                            break;
                        }
                    }
                    if (shouldAttach) attachTracking();
                });
                document.addEventListener('DOMContentLoaded', function() {
                    observer.observe(document.body, {
                        childList: true,
                        subtree: true
                    });
                });
            }
        })();
    </script>

    @stack('scripts')
</body>

</html>
