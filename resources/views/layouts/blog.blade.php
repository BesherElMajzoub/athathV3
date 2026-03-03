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
    {{-- OpenGraph --}}
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
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] ?? config('app.name') }}">
    @isset($seo['description'])
        <meta name="twitter:description" content="{{ $seo['description'] }}">
    @endisset

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
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
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            color: var(--gray-900);
            background: #fff;
            line-height: 1.6;
        }

        .site-header {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .site-logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        nav a {
            color: var(--gray-700);
            text-decoration: none;
            margin-right: 1.5rem;
            font-size: 0.95rem;
        }

        nav a:hover {
            color: var(--primary);
        }

        .site-footer {
            background: var(--gray-900);
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            padding: 2rem;
            font-size: 0.9rem;
            margin-top: 4rem;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.65rem 1.25rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }
    </style>
    @stack('head')
</head>

<body>
    <header class="site-header">
        <a href="/" class="site-logo">🪑 {{ config('app.name') }}</a>
        <nav>
            <a href="/">الرئيسية</a>
            <a href="/blog">المدونة</a>
            <a href="/contact">اتصل بنا</a>
        </nav>
    </header>

    <main class="container" style="padding-top:2rem;padding-bottom:2rem;">
        @yield('content')
    </main>

    <footer class="site-footer">
        <p>© {{ date('Y') }} {{ config('app.name') }} — جميع الحقوق محفوظة</p>
    </footer>

    @stack('scripts')
</body>

</html>
