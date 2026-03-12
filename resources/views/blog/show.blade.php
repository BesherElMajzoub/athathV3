<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Primary SEO --}}
    <title>{{ $post->getEffectiveMetaTitle() }}</title>
    <meta name="description" content="{{ $post->meta_description }}">
    <link rel="canonical" href="{{ $post->getEffectiveCanonical() }}">

    {{-- OpenGraph --}}
    <meta property="og:title" content="{{ $post->getEffectiveMetaTitle() }}">
    <meta property="og:description" content="{{ $post->meta_description }}">
    <meta property="og:url" content="{{ $post->getEffectiveCanonical() }}">
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ar_SA">
    @if ($post->featured_image)
        <meta property="og:image" content="{{ asset('storage/' . $post->featured_image) }}">
        <meta property="og:image:alt" content="{{ $post->featured_image_alt ?? $post->title }}">
    @endif
    <meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $post->updated_at?->toIso8601String() }}">
    @if ($post->author_name)
        <meta property="article:author" content="{{ $post->author_name }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->getEffectiveMetaTitle() }}">
    <meta name="twitter:description" content="{{ $post->meta_description }}">
    @if ($post->featured_image)
        <meta name="twitter:image" content="{{ asset('storage/' . $post->featured_image) }}">
    @endif

    {{-- JSON-LD --}}
    <script type="application/ld+json">{!! $schema !!}</script>
    <script type="application/ld+json">{!! $breadcrumbSchema !!}</script>

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

        :root {
            --primary: #2F6B3F;
            --primary-dark: #245632;
            --mint: #BFE7CF;
            --bg: #F6FBF7;
            --surface: #fff;
            --text: #123018;
            --muted: #5D6F62;
            --border: rgba(18, 48, 24, .09);
            --shadow: 0 4px 20px rgba(18, 48, 24, .07);
            --radius: 16px;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.75;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== HEADER ===== */
        .site-header {
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: box-shadow 0.2s;
        }

        .site-header.scrolled {
            box-shadow: 0 4px 20px rgba(18, 48, 24, .08);
        }

        .site-logo {
            font-size: 1.2rem;
            font-weight: 900;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-icon-box {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .site-nav a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.88rem;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            transition: all 0.15s;
        }

        .site-nav a:hover {
            color: var(--primary);
            background: rgba(47, 107, 63, .06);
        }

        .site-nav {
            display: flex;
            align-items: center;
            gap: 0.15rem;
        }

        .nav-wa-btn {
            background: #25d366 !important;
            color: #fff !important;
            border-radius: 999px !important;
            padding: 0.45rem 1rem !important;
            font-weight: 700 !important;
            font-size: 0.82rem !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
        }

        .nav-wa-btn:hover {
            background: #1fba59 !important;
        }

        .nav-wa-btn svg {
            flex-shrink: 0;
        }

        /* ===== CONTAINER ===== */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .article-wrap {
            max-width: 760px;
            margin: 0 auto;
        }

        /* ===== BREADCRUMB ===== */
        .breadcrumb {
            display: flex;
            gap: 0.4rem;
            font-size: 0.8rem;
            color: var(--muted);
            padding: 1.25rem 0 0;
            align-items: center;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-sep {
            color: #c4d4c8;
        }

        /* ===== POST HEADER ===== */
        .post-header {
            padding: 2rem 0 1.75rem;
        }

        .post-cats {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .cat-badge {
            background: var(--mint);
            color: var(--primary);
            padding: 0.2rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.15s;
        }

        .cat-badge:hover {
            background: #a5d8ba;
        }

        .post-title {
            font-size: clamp(1.7rem, 4vw, 2.5rem);
            font-weight: 900;
            line-height: 1.28;
            margin-bottom: 1.25rem;
            color: var(--text);
            letter-spacing: -0.02em;
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            font-size: 0.82rem;
            color: var(--muted);
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .post-meta span {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .meta-dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #c4d4c8;
        }

        /* ===== FEATURED IMAGE ===== */
        .post-featured-image {
            width: 100%;
            max-height: 460px;
            object-fit: cover;
            border-radius: var(--radius);
            margin-bottom: 2.5rem;
            box-shadow: 0 8px 32px rgba(18, 48, 24, .1);
        }

        /* ===== CONTENT ===== */
        .post-content {
            font-size: 1.06rem;
            line-height: 1.85;
            color: var(--text);
        }

        .post-content h2 {
            font-size: 1.55rem;
            font-weight: 800;
            margin: 2.5rem 0 1rem;
            color: var(--text);
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--mint);
        }

        .post-content h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 2rem 0 0.75rem;
            color: var(--text);
        }

        .post-content h4 {
            font-size: 1.05rem;
            font-weight: 700;
            margin: 1.5rem 0 0.5rem;
        }

        .post-content p {
            margin-bottom: 1.4rem;
        }

        .post-content ul,
        .post-content ol {
            padding-right: 1.5rem;
            margin-bottom: 1.4rem;
        }

        .post-content li {
            margin-bottom: 0.5rem;
        }

        .post-content a {
            color: var(--primary);
            font-weight: 500;
        }

        .post-content a:hover {
            text-decoration: underline;
        }

        .post-content blockquote {
            border-right: 4px solid var(--primary);
            padding: 1rem 1.25rem;
            background: rgba(191, 231, 207, .25);
            border-radius: 0 12px 12px 0;
            margin: 1.75rem 0;
            font-style: italic;
            color: var(--primary-dark);
        }

        .post-content img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin: 1rem 0;
        }

        .post-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.75rem 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .post-content th,
        .post-content td {
            border: 1px solid var(--border);
            padding: 0.75rem 1rem;
            text-align: right;
        }

        .post-content th {
            background: rgba(191, 231, 207, .3);
            font-weight: 700;
            color: var(--primary);
        }

        .post-content tr:hover td {
            background: rgba(191, 231, 207, .08);
        }

        /* ===== SHARE BAR ===== */
        .share-bar {
            margin: 2.5rem 0;
            padding: 1.5rem;
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .share-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--muted);
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 1rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }

        .share-btn:hover {
            transform: translateY(-1px);
        }

        .share-wa {
            background: #25d366;
            color: #fff;
        }

        .share-wa:hover {
            background: #1fba59;
        }

        .share-tw {
            background: #000;
            color: #fff;
        }

        .share-tw:hover {
            background: #222;
        }

        .share-copy {
            background: var(--bg);
            color: var(--primary);
            border: 1px solid var(--border);
            cursor: pointer;
            font-family: inherit;
        }

        .share-copy:hover {
            background: var(--mint);
            border-color: var(--mint);
        }

        /* ===== CTA MID-ARTICLE ===== */
        .article-cta {
            background: linear-gradient(135deg, var(--primary) 0%, #3d8a52 100%);
            border-radius: var(--radius);
            padding: 2rem 1.75rem;
            color: #fff;
            text-align: center;
            margin: 2.5rem 0;
            position: relative;
            overflow: hidden;
        }

        .article-cta::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
            top: -80px;
            left: -50px;
        }

        .article-cta h3 {
            font-size: 1.3rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .article-cta p {
            font-size: 0.9rem;
            opacity: .9;
            margin-bottom: 1.25rem;
            position: relative;
        }

        .article-cta-btns {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            font-family: inherit;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-whatsapp {
            background: #25d366;
            color: #fff;
        }

        .btn-whatsapp:hover {
            background: #1fba59;
            box-shadow: 0 6px 20px rgba(37, 211, 102, .35);
            transform: translateY(-2px);
        }

        .btn-light {
            background: rgba(255, 255, 255, .18);
            color: #fff;
            backdrop-filter: blur(4px);
        }

        .btn-light:hover {
            background: rgba(255, 255, 255, .28);
            transform: translateY(-2px);
        }

        /* ===== RELATED ===== */
        .related-posts {
            margin-top: 3.5rem;
            padding-top: 2.5rem;
            border-top: 1px solid var(--border);
        }

        .related-title {
            font-size: 1.3rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
        }

        .related-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .related-card:hover {
            box-shadow: 0 8px 28px rgba(18, 48, 24, .1);
            transform: translateY(-3px);
        }

        .related-card img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            background: var(--mint);
        }

        .related-card-placeholder {
            height: 130px;
            background: linear-gradient(135deg, var(--mint), #e8f5ed);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .related-card-body {
            padding: 1rem;
            flex: 1;
        }

        .related-card-body h3 {
            font-size: 0.9rem;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 0.4rem;
            color: var(--text);
        }

        .related-card-body .related-date {
            font-size: 0.75rem;
            color: var(--muted);
        }

        /* ===== FOOTER ===== */
        .site-footer {
            background: var(--text);
            color: rgba(255, 255, 255, .6);
            text-align: center;
            padding: 2rem;
            margin-top: 5rem;
            font-size: 0.85rem;
        }

        /* ===== FLOATING CTAs ===== */
        .floating-cta {
            position: fixed;
            bottom: 1.5rem;
            left: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            z-index: 300;
        }

        .float-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            border-radius: 999px;
            color: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .18);
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s;
            max-width: 190px;
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
            font-size: 1.1rem;
        }

        .float-wa {
            background: #25d366;
        }

        .float-wa .float-btn-icon {
            background: rgba(255, 255, 255, .2);
        }

        .float-call {
            background: var(--primary);
        }

        .float-call .float-btn-icon {
            background: rgba(255, 255, 255, .2);
        }

        @media (max-width: 640px) {
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
                background: transparent !important;
            }

            .site-nav {
                display: none;
            }
        }
    </style>
</head>

<body>
    <header class="site-header" id="siteHeader">
        <a href="{{ route('home') }}" class="site-logo">
            <span class="logo-icon-box">🪑</span>
            <span>{{ config('app.name') }}</span>
        </a>
        <nav class="site-nav">
            <a href="{{ route('home') }}">الرئيسية</a>
            <a href="{{ url('/blog') }}">المدونة</a>
            <a href="{{ route('services.index') }}">الخدمات</a>
            <a href="https://wa.me/{{ config('business.whatsapp') }}" class="nav-wa-btn"
                rel="nofollow noopener noreferrer" target="_blank">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                واتساب
            </a>
        </nav>
    </header>

    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('home') }}">الرئيسية</a>
            <span class="breadcrumb-sep">›</span>
            <a href="{{ url('/blog') }}">المدونة</a>
            <span class="breadcrumb-sep">›</span>
            <span>{{ Str::limit($post->title, 50) }}</span>
        </nav>

        <div class="article-wrap">
            <article>
                {{-- Post Header --}}
                <header class="post-header">
                    @if ($post->categories->isNotEmpty())
                        <div class="post-cats">
                            @foreach ($post->categories as $cat)
                                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                                    class="cat-badge">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    @endif

                    <h1 class="post-title">{{ $post->title }}</h1>

                    <div class="post-meta">
                        @if ($post->author_name)
                            <span>✍ {{ $post->author_name }}</span>
                            <span class="meta-dot"></span>
                        @endif
                        <span>📅 {{ $post->published_at?->format('d F Y') }}</span>
                        @if ($post->reading_time)
                            <span class="meta-dot"></span>
                            <span>⏱ {{ $post->reading_time }} دقائق قراءة</span>
                        @endif
                    </div>
                </header>

                {{-- Featured Image --}}
                @if ($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                        alt="{{ $post->featured_image_alt ?? $post->title }}" class="post-featured-image">
                @endif

                {{-- Post Content --}}
                <div class="post-content">
                    {!! $post->content !!}
                </div>

                {{-- Mid-Article CTA --}}
                <div class="article-cta">
                    <h3>هل تريد بيع أثاثك المستعمل؟</h3>
                    <p>أرسل لنا صور الأثاث عبر الواتساب لتسعير فوري ومجاني — نغطي جميع أحياء جدة.</p>
                    <div class="article-cta-btns">
                        <a href="https://wa.me/{{ config('business.whatsapp') }}" class="btn btn-whatsapp"
                            rel="nofollow noopener noreferrer" data-track="cta_whatsapp_click"
                            data-placement="article_cta" data-target="https://wa.me/{{ config('business.whatsapp') }}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            أرسل الصور الآن
                        </a>
                        <a href="tel:{{ config('business.phone') }}" class="btn btn-light" data-track="cta_call_click"
                            data-placement="article_cta" data-target="tel:{{ config('business.phone') }}">
                            📞 اتصل بنا
                        </a>
                    </div>
                </div>

                {{-- Share Bar --}}
                <div class="share-bar">
                    <span class="share-label">شارك المقال:</span>
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' — ' . $post->getEffectiveCanonical()) }}"
                        class="share-btn share-wa" target="_blank" rel="nofollow noopener noreferrer">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        واتساب
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode($post->getEffectiveCanonical()) }}"
                        class="share-btn share-tw" target="_blank" rel="nofollow noopener noreferrer">
                        𝕏 تويتر
                    </a>
                    <button class="share-btn share-copy" id="copyBtn" onclick="copyLink()">📋 نسخ الرابط</button>
                </div>
            </article>

            {{-- Related Posts --}}
            @if ($relatedPosts->isNotEmpty())
                <section class="related-posts">
                    <h2 class="related-title">📖 مقالات ذات صلة</h2>
                    <div class="related-grid">
                        @foreach ($relatedPosts as $related)
                            <a href="{{ route('blog.show', $related->slug) }}" class="related-card">
                                @if ($related->featured_image)
                                    <img src="{{ asset('storage/' . $related->featured_image) }}"
                                        alt="{{ $related->title }}" loading="lazy">
                                @else
                                    <div class="related-card-placeholder">🪑</div>
                                @endif
                                <div class="related-card-body">
                                    <h3>{{ $related->title }}</h3>
                                    <div class="related-date">{{ $related->published_at?->diffForHumans() }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>

    <footer class="site-footer">
        <p>© {{ date('Y') }} {{ config('app.name') }} — جميع الحقوق محفوظة</p>
    </footer>

    {{-- Floating CTAs --}}
    <div class="floating-cta">
        <a href="https://wa.me/{{ config('business.whatsapp') }}" class="float-btn float-wa"
            rel="nofollow noopener noreferrer" data-track="float_whatsapp_click" data-placement="float"
            data-target="https://wa.me/{{ config('business.whatsapp') }}">
            <span class="float-btn-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
            </span>
            <span>أرسل الصور من هنا</span>
        </a>
        <a href="tel:{{ config('business.phone') }}" class="float-btn float-call" data-track="float_call_click"
            data-placement="float" data-target="tel:{{ config('business.phone') }}">
            <span class="float-btn-icon">📞</span>
            <span>اتصل الآن</span>
        </a>
    </div>

    <script>
        // Header scroll shadow
        const header = document.getElementById('siteHeader');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 20);
        }, {
            passive: true
        });

        // Copy link button
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const btn = document.getElementById('copyBtn');
                btn.textContent = '✅ تم النسخ!';
                setTimeout(() => btn.textContent = '📋 نسخ الرابط', 2000);
            });
        }

        // Tracking
        document.querySelectorAll('[data-track]').forEach(el => {
            el.addEventListener('click', function() {
                const data = {
                    event_type: this.dataset.track,
                    page_url: window.location.href,
                    placement: this.dataset.placement || '',
                    target_url: this.dataset.target || this.href || '',
                };
                if (navigator.sendBeacon) {
                    navigator.sendBeacon('/api/track/click', new Blob([JSON.stringify(data)], {
                        type: 'application/json'
                    }));
                }
            });
        });
    </script>
</body>

</html>
