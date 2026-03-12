<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['title'] ?? config('app.name') }}</title>
    @isset($seo['description'])
        <meta name="description" content="{{ $seo['description'] }}">
    @endisset
    @isset($seo['canonical'])
        <link rel="canonical" href="{{ $seo['canonical'] }}">
    @endisset
    <meta property="og:title" content="{{ $seo['title'] ?? config('app.name') }}">
    @isset($seo['description'])
        <meta property="og:description" content="{{ $seo['description'] }}">
    @endisset
    @isset($seo['canonical'])
        <meta property="og:url" content="{{ $seo['canonical'] }}">
    @endisset
    @isset($seo['image'])
        <meta property="og:image" content="{{ $seo['image'] }}">
    @endisset
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ar_SA">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] ?? config('app.name') }}">
    @isset($seo['description'])
        <meta name="twitter:description" content="{{ $seo['description'] }}">
    @endisset

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #eff6ff;
            --accent: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: 'Tajawal', sans-serif;
            color: var(--gray-900);
            background: #fff;
            line-height: 1.7;
        }

        /* ===== HEADER ===== */
        .site-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--gray-200);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            height: 64px;
            transition: box-shadow 0.2s;
        }

        .site-header.scrolled {
            box-shadow: var(--shadow-md);
        }

        .site-logo {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            letter-spacing: -0.02em;
        }

        .site-logo .logo-dot {
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            display: inline-block;
        }

        .site-nav {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .site-nav a {
            color: var(--gray-600);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.45rem 0.875rem;
            border-radius: var(--radius-sm);
            transition: all 0.15s;
        }

        .site-nav a:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .site-nav a.active {
            color: var(--primary);
            background: var(--primary-light);
            font-weight: 600;
        }

        .nav-cta {
            background: var(--primary) !important;
            color: #fff !important;
            padding: 0.45rem 1rem !important;
            border-radius: var(--radius-sm) !important;
            font-weight: 600 !important;
        }

        .nav-cta:hover {
            background: var(--primary-dark) !important;
        }

        /* ===== CONTAINER ===== */
        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ===== FOOTER ===== */
        .site-footer {
            background: var(--gray-900);
            color: rgba(255, 255, 255, 0.65);
            margin-top: 5rem;
        }

        .footer-inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-logo {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.15s;
        }

        .footer-links a:hover {
            color: #fff;
        }

        .footer-copy {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.4);
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 1.25rem;
            margin-top: 0.5rem;
            text-align: center;
        }

        /* ===== GLOBAL BUTTON ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.65rem 1.25rem;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
    </style>
    @stack('head')
</head>

<body>
    <header class="site-header" id="siteHeader">
        <a href="/" class="site-logo">🪑 مدونة شراء أثاث مستعمل</a>
        <nav class="site-nav">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">الرئيسية</a>
            <a href="/blog" class="{{ request()->is('blog*') ? 'active' : '' }}">المدونة</a>
            <a href="/contact" class="nav-cta">اتصل بنا</a>
        </nav>
    </header>

    <main class="container" style="padding-top:2.5rem;padding-bottom:2.5rem;">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-logo">🪑 مدونة شراء أثاث مستعمل</div>
            <div class="footer-links">
                <a href="/blog">المدونة</a>
                <a href="/contact">اتصل بنا</a>
                <a href="/sitemap.xml">خريطة الموقع</a>
            </div>
            <div class="footer-copy">
                © {{ date('Y') }} {{ config('app.name') }} — جميع الحقوق محفوظة
            </div>
        </div>
    </footer>

    <script>
        // Sticky header shadow on scroll
        const header = document.getElementById('siteHeader');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 20);
        }, {
            passive: true
        });
    </script>
    @stack('scripts')
</body>

</html>
