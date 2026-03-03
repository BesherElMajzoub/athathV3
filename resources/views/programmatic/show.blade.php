<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title }}</title>
    <meta name="description" content="{{ $page->meta_description }}">
    <link rel="canonical" href="{{ $page->getEffectiveCanonical() }}">
    @if (!$page->indexable)
        <meta name="robots" content="noindex,nofollow">
    @endif

    {{-- OpenGraph --}}
    <meta property="og:title" content="{{ $page->meta_title }}">
    <meta property="og:description" content="{{ $page->meta_description }}">
    <meta property="og:url" content="{{ $page->getEffectiveCanonical() }}">
    <meta property="og:locale" content="ar_SA">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $page->meta_title }}">
    <meta name="twitter:description" content="{{ $page->meta_description }}">

    {{-- JSON-LD --}}
    <script type="application/ld+json">{!! $schema !!}</script>
    <script type="application/ld+json">{!! $breadcrumbSchema !!}</script>

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
            color: #111827;
            background: #fff;
            line-height: 1.75;
        }

        .site-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
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
            color: #2563eb;
            text-decoration: none;
        }

        nav a {
            color: #374151;
            text-decoration: none;
            margin-right: 1.5rem;
        }

        nav a:hover {
            color: #2563eb;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #9ca3af;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: #6b7280;
            text-decoration: none;
        }

        .page-hero {
            margin-bottom: 2.5rem;
        }

        .page-hero h1 {
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            font-weight: 900;
            margin-bottom: 0.75rem;
        }

        .page-hero .keyword-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 0.3rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .content-block {
            margin-bottom: 2.5rem;
        }

        .content-block h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .selling-points ul {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 0.75rem;
        }

        .selling-points li {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.875rem 1rem;
            display: flex;
            gap: 0.6rem;
            align-items: flex-start;
        }

        .selling-points li::before {
            content: '✓';
            color: #16a34a;
            font-weight: 700;
            flex-shrink: 0;
        }

        .faq-item {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 0.75rem;
            overflow: hidden;
        }

        .faq-question {
            padding: 1rem 1.25rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9fafb;
        }

        .faq-answer {
            padding: 1rem 1.25rem;
            color: #374151;
            display: none;
        }

        .faq-item.open .faq-answer {
            display: block;
        }

        .faq-item.open .faq-question::after {
            content: '▲';
        }

        .faq-question::after {
            content: '▼';
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .cta-block {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
        }

        .cta-block h2 {
            font-size: 1.6rem;
            font-weight: 900;
            margin-bottom: 1rem;
        }

        .cta-block p {
            opacity: 0.9;
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
        }

        .cta-btn {
            display: inline-block;
            background: #fff;
            color: #2563eb;
            padding: 0.875rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            transition: transform 0.2s;
        }

        .cta-btn:hover {
            transform: translateY(-2px);
        }

        .site-footer {
            background: #111827;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }
    </style>
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

    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="/">الرئيسية</a>
            <span>›</span>
            <span>{{ $page->title }}</span>
        </nav>

        <div class="page-hero">
            <span class="keyword-badge">{{ $page->primary_keyword }}</span>
            <h1>{{ $page->title }}</h1>
            <p style="color:#6b7280;">{{ $page->city }}</p>
        </div>

        {{-- Render Content Blocks --}}
        @foreach ($page->content_blocks ?? [] as $block)
            @if ($block['type'] === 'intro')
                <div class="content-block">
                    <p style="font-size:1.05rem;line-height:1.8;">{{ $block['content'] }}</p>
                </div>
            @elseif($block['type'] === 'selling_points')
                <div class="content-block selling-points">
                    <h2>لماذا تختارنا؟</h2>
                    <ul>
                        @foreach ($block['items'] ?? [] as $point)
                            <li>{{ is_string($point) ? $point : $point['text'] ?? '' }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif($block['type'] === 'faq')
                <div class="content-block">
                    <h2>الأسئلة الشائعة</h2>
                    @foreach ($block['items'] ?? [] as $faq)
                        <div class="faq-item" onclick="this.classList.toggle('open')">
                            <div class="faq-question">{{ $faq['question'] ?? '' }}</div>
                            <div class="faq-answer">{{ $faq['answer'] ?? '' }}</div>
                        </div>
                    @endforeach
                </div>
            @elseif($block['type'] === 'cta')
                <div class="cta-block">
                    <h2>تواصل معنا الآن</h2>
                    <p>{{ $block['content'] }}</p>
                    <a href="/contact" class="cta-btn">تواصل مجاناً</a>
                </div>
            @endif
        @endforeach
    </div>

    <footer class="site-footer">
        <p>© {{ date('Y') }} {{ config('app.name') }} — جميع الحقوق محفوظة</p>
    </footer>
</body>

</html>
