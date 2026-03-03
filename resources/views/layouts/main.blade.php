<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Meta --}}
    <title>@yield('title', 'شراء أثاث مستعمل بجدة | أفضل الأسعار والخدمات')</title>
    <meta name="description" content="@yield('meta_description', 'نشتري الأثاث المستعمل في جدة بأفضل الأسعار. تواصل معنا للتقييم والتسعير الفوري من راحة منزلك.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'شراء أثاث مستعمل بجدة')">
    <meta property="og:description" content="@yield('meta_description', 'أفضل تسعير لجميع أنواع الأثاث والأجهزة في جدة.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:locale" content="ar_SA">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'شراء أثاث مستعمل بجدة')">

    {{-- Schema --}}
    @stack('schema')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: #f9fafb;
            color: #111827;
            line-height: 1.6;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .gap-4 {
            gap: 1rem;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .py-16 {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-black {
            font-weight: 900;
        }

        .text-blue-600 {
            color: #2563eb;
        }

        .bg-blue-600 {
            background: #2563eb;
        }

        .text-white {
            color: #fff;
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            transition: transform 0.2s, opacity 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-whatsapp {
            background: #25d366;
            color: #fff;
        }

        .btn-call {
            background: #16a34a;
            color: #fff;
        }

        header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        nav a {
            text-decoration: none;
            color: #4b5563;
            font-weight: 500;
            margin-right: 1.5rem;
        }

        nav a:hover {
            color: #2563eb;
        }

        .hero {
            background: linear-gradient(to bottom, #dbeafe, #fff);
            padding: 5rem 1.5rem;
            text-align: center;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: #1e3a8a;
            line-height: 1.3;
            margin-bottom: 1.5rem;
        }

        .hero p {
            font-size: 1.25rem;
            color: #4b5563;
            max-width: 800px;
            margin: 0 auto 2rem;
        }

        .grid {
            display: grid;
            gap: 2rem;
        }

        .grid-cols-3 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #f3f4f6;
        }

        .card h2 {
            font-size: 1.25rem;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .card p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .floating-cta {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            z-index: 100;
        }

        .floating-cta a {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            font-size: 1.5rem;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .floating-cta a:hover {
            transform: scale(1.1);
        }

        .float-wa {
            background: #25d366;
        }

        .float-call {
            background: #2563eb;
        }

        footer {
            background: #1f2937;
            color: #9ca3af;
            padding: 3rem 0;
            margin-top: 4rem;
            text-align: center;
        }

        footer a {
            color: #d1d5db;
            text-decoration: none;
            margin: 0 0.5rem;
        }
    </style>
    @stack('head')
</head>

<body>

    <header>
        <div class="container flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-black text-blue-600"
                style="font-size:1.5rem;text-decoration:none;">أثاث جدة</a>
            <nav>
                <a href="{{ route('home') }}">الرئيسية</a>
                <a href="{{ route('services.index') }}">الخدمات</a>
                <a href="{{ route('districts.index') }}">أحياء جدة</a>
                <a href="{{ url('/blog') }}">المدونة</a>
                <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                <a href="{{ route('contact') }}">تواصل معنا</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div style="margin-bottom:1rem;">
                <a href="{{ route('home') }}">الرئيسية</a>
                <a href="{{ route('contact') }}">تواصل معنا</a>
                <a href="{{ url('/sitemap.xml') }}">Sitemap</a>
            </div>
            <p>© {{ date('Y') }} شركة شراء أثاث مستعمل بجدة. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    {{-- Floating CTAs --}}
    <div class="floating-cta">
        <a href="https://wa.me/966500000000" class="float-wa track-cta" data-cta-type="cta_whatsapp_click"
            title="واتساب">💬</a>
        <a href="tel:+966500000000" class="float-call track-cta" data-cta-type="cta_call_click" title="اتصال">📞</a>
    </div>

    {{-- Tracking Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.track-cta').forEach(el => {
                el.addEventListener('click', function() {
                    const type = this.getAttribute('data-cta-type');
                    fetch('/api/tracking/events', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            event_type: type,
                            page_url: window.location.href,
                            meta_data: {
                                label: this.innerText || this.title
                            }
                        })
                    }).catch(e => console.error('Tracking Error:', e));
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
