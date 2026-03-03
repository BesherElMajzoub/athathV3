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

    {{-- JSON-LD: Post Schema --}}
    <script type="application/ld+json">{!! $schema !!}</script>

    {{-- JSON-LD: Breadcrumb --}}
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
            font-size: 0.95rem;
        }

        nav a:hover {
            color: #2563eb;
        }

        .container {
            max-width: 820px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #9ca3af;
            padding: 1rem 0;
            align-items: center;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: #6b7280;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: #2563eb;
        }

        .post-header {
            padding: 1.5rem 0 2rem;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 2rem;
        }

        .post-cats {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .cat-badge {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
        }

        .post-title {
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            font-weight: 900;
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        .post-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .post-featured-image {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .post-content {
            font-size: 1.05rem;
        }

        .post-content h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 2rem 0 1rem;
        }

        .post-content h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 1.5rem 0 0.75rem;
        }

        .post-content p {
            margin-bottom: 1.25rem;
        }

        .post-content ul,
        .post-content ol {
            padding-right: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .post-content li {
            margin-bottom: 0.4rem;
        }

        .post-content a {
            color: #2563eb;
        }

        .post-content blockquote {
            border-right: 4px solid #2563eb;
            padding: 0.75rem 1rem;
            background: #eff6ff;
            border-radius: 0 8px 8px 0;
            margin: 1.5rem 0;
            font-style: italic;
        }

        .post-content img {
            max-width: 100%;
            border-radius: 8px;
        }

        .post-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }

        .post-content th,
        .post-content td {
            border: 1px solid #e5e7eb;
            padding: 0.6rem 0.875rem;
        }

        .post-content th {
            background: #f3f4f6;
            font-weight: 700;
        }

        .post-tags {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .related-posts {
            margin-top: 3rem;
        }

        .related-posts h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
        }

        .related-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            transition: box-shadow 0.2s;
        }

        .related-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .related-card img {
            width: 100%;
            height: 130px;
            object-fit: cover;
        }

        .related-card-body {
            padding: 1rem;
        }

        .related-card h3 {
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.3;
        }

        .related-card h3 a {
            text-decoration: none;
            color: inherit;
        }

        .related-card h3 a:hover {
            color: #2563eb;
        }

        .site-footer {
            background: #111827;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
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
        {{-- Breadcrumb --}}
        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="/">الرئيسية</a>
            <span>›</span>
            <a href="/blog">المدونة</a>
            <span>›</span>
            <span>{{ $post->title }}</span>
        </nav>

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
                    @endif
                    <span>📅 {{ $post->published_at?->format('d F Y') }}</span>
                    @if ($post->reading_time)
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
        </article>

        {{-- Related Posts --}}
        @if ($relatedPosts->isNotEmpty())
            <section class="related-posts">
                <h2>مقالات ذات صلة</h2>
                <div class="related-grid">
                    @foreach ($relatedPosts as $related)
                        <article class="related-card">
                            @if ($related->featured_image)
                                <img src="{{ asset('storage/' . $related->featured_image) }}"
                                    alt="{{ $related->title }}" loading="lazy">
                            @endif
                            <div class="related-card-body">
                                <h3><a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a></h3>
                                <div style="font-size:0.8rem;color:#9ca3af;margin-top:0.5rem;">
                                    {{ $related->published_at?->diffForHumans() }}</div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <footer class="site-footer">
        <p>© {{ date('Y') }} {{ config('app.name') }} — جميع الحقوق محفوظة</p>
    </footer>
</body>

</html>
