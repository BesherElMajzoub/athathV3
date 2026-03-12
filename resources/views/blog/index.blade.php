@extends('layouts.blog', ['seo' => $seo])

@push('head')
    <style>
        /* ===== HERO SECTION ===== */
        .blog-hero {
            text-align: center;
            padding: 3.5rem 1rem 3rem;
            position: relative;
            overflow: hidden;
        }

        .blog-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(37, 99, 235, 0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .blog-hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #eff6ff;
            color: #2563eb;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.3rem 0.9rem;
            border-radius: 9999px;
            margin-bottom: 1.25rem;
            letter-spacing: 0.03em;
        }

        .blog-hero h1 {
            font-size: clamp(1.8rem, 4vw, 2.75rem);
            font-weight: 800;
            color: #111827;
            margin-bottom: 0.875rem;
            line-height: 1.25;
            letter-spacing: -0.02em;
        }

        .blog-hero h1 .highlight {
            color: #2563eb;
            position: relative;
        }

        .blog-hero p {
            color: #6b7280;
            font-size: 1.05rem;
            max-width: 560px;
            margin: 0 auto 2rem;
            line-height: 1.7;
        }

        /* ===== FILTER BAR ===== */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .filter-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            color: #4b5563;
            background: #f3f4f6;
            border: 1px solid transparent;
            transition: all 0.15s;
            cursor: pointer;
        }

        .filter-pill:hover {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .filter-pill.active {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }

        .filter-count {
            background: rgba(255, 255, 255, 0.25);
            font-size: 0.7rem;
            padding: 0.05rem 0.4rem;
            border-radius: 9999px;
            font-weight: 700;
        }

        .filter-pill:not(.active) .filter-count {
            background: #e5e7eb;
            color: #6b7280;
        }

        /* ===== POSTS GRID ===== */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.75rem;
        }

        @media (max-width: 700px) {
            .posts-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===== POST CARD ===== */
        .post-card {
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.25s, transform 0.25s, border-color 0.25s;
        }

        .post-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
            border-color: #93c5fd;
        }

        /* Image */
        .post-card-img-wrap {
            position: relative;
            overflow: hidden;
        }

        .post-card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .post-card:hover .post-card-img {
            transform: scale(1.04);
        }

        .post-card-img-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 50%, #fce7f3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
        }

        .post-card-img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.35) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .post-card:hover .post-card-img-overlay {
            opacity: 1;
        }

        .post-card-read-btn {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%) translateY(8px);
            background: #fff;
            color: #2563eb;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.35rem 0.9rem;
            border-radius: 9999px;
            white-space: nowrap;
            opacity: 0;
            transition: all 0.3s;
            pointer-events: none;
        }

        .post-card:hover .post-card-read-btn {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* Categories */
        .post-card-cats {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
            margin-bottom: 0.7rem;
        }

        .cat-badge {
            background: #eff6ff;
            color: #2563eb;
            padding: 0.18rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.15s;
            letter-spacing: 0.02em;
        }

        .cat-badge:hover {
            background: #dbeafe;
        }

        /* Body */
        .post-card-body {
            padding: 1.25rem 1.35rem 1.35rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .post-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
            line-height: 1.45;
            color: #111827;
        }

        .post-card-title a {
            text-decoration: none;
            color: inherit;
            transition: color 0.15s;
        }

        .post-card-title a:hover {
            color: #2563eb;
        }

        .post-card-excerpt {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.65;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1.1rem;
            flex: 1;
        }

        /* Meta */
        .post-card-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.78rem;
            color: #9ca3af;
            flex-wrap: wrap;
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
        }

        .post-card-meta span {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .meta-dot {
            width: 3px;
            height: 3px;
            background: #d1d5db;
            border-radius: 50%;
        }

        /* ===== FEATURED CARD (first post) ===== */
        .post-card.featured {
            grid-column: 1 / -1;
            flex-direction: row;
            border-color: #bfdbfe;
            background: linear-gradient(135deg, #fafeff 0%, #f0f7ff 100%);
        }

        @media (max-width: 700px) {
            .post-card.featured {
                flex-direction: column;
            }
        }

        .post-card.featured .post-card-img-wrap {
            width: 42%;
            flex-shrink: 0;
        }

        @media (max-width: 700px) {
            .post-card.featured .post-card-img-wrap {
                width: 100%;
            }
        }

        .post-card.featured .post-card-img,
        .post-card.featured .post-card-img-placeholder {
            height: 100%;
            min-height: 240px;
        }

        .post-card.featured .post-card-body {
            padding: 2rem;
        }

        .post-card.featured .post-card-title {
            font-size: 1.35rem;
            line-height: 1.4;
        }

        .post-card.featured .post-card-excerpt {
            -webkit-line-clamp: 3;
            font-size: 0.9rem;
        }

        .featured-label {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: #fef9c3;
            color: #a16207;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.2rem 0.65rem;
            border-radius: 9999px;
            margin-bottom: 0.875rem;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 5rem 1rem;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .empty-state h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        /* ===== PAGINATION ===== */
        .pagination-wrap {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .pagination-wrap nav {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .pagination-wrap span,
        .pagination-wrap a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 0.5rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s;
        }

        .pagination-wrap a {
            color: #374151;
            border: 1px solid #e5e7eb;
            background: #fff;
        }

        .pagination-wrap a:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #2563eb;
        }

        .pagination-wrap span[aria-current="page"] span {
            background: #2563eb;
            color: #fff;
            border: 1px solid #2563eb;
            min-width: 40px;
            height: 40px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .pagination-wrap span.disabled {
            color: #d1d5db;
            border: 1px solid #f3f4f6;
            background: #fafafa;
        }

        /* ===== RESULTS BAR ===== */
        .results-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .results-count {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .results-count strong {
            color: #111827;
            font-weight: 700;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .post-card {
            animation: fadeInUp 0.4s ease both;
        }

        .post-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .post-card:nth-child(2) {
            animation-delay: 0.10s;
        }

        .post-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .post-card:nth-child(4) {
            animation-delay: 0.20s;
        }

        .post-card:nth-child(5) {
            animation-delay: 0.25s;
        }

        .post-card:nth-child(6) {
            animation-delay: 0.30s;
        }

        .post-card:nth-child(n+7) {
            animation-delay: 0.35s;
        }
    </style>
@endpush

@section('content')
    {{-- Hero --}}
    <div class="blog-hero">
        <div class="blog-hero-tag">✨ أحدث المقالات</div>
        <h1>نصائح <span class="highlight">الأثاث المستعمل</span></h1>
        <p>دليلك الشامل لشراء وبيع الأثاث المستعمل بأفضل الأسعار — نصائح خبراء، مقارنات، وإرشادات عملية</p>
    </div>

    {{-- Filter Pills (Categories) --}}
    @if (isset($categories) && $categories->isNotEmpty())
        <div class="filter-bar">
            <a href="{{ route('blog.index') }}" class="filter-pill {{ !request('category') ? 'active' : '' }}">
                الكل
                <span class="filter-count">{{ $posts->total() }}</span>
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                    class="filter-pill {{ request('category') == $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                    @if ($cat->posts_count > 0)
                        <span class="filter-count">{{ $cat->posts_count }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

    {{-- Results bar --}}
    @if ($posts->total() > 0)
        <div class="results-bar">
            <span class="results-count">
                عرض <strong>{{ $posts->count() }}</strong> من أصل <strong>{{ $posts->total() }}</strong> مقالة
                @if (request('category'))
                    في تصنيف "<strong>{{ request('category') }}</strong>"
                @endif
            </span>
            @if (request('category'))
                <a href="{{ route('blog.index') }}" style="font-size:0.82rem;color:#6b7280;text-decoration:none;">
                    ✕ إلغاء الفلتر
                </a>
            @endif
        </div>
    @endif

    {{-- Posts Grid --}}
    <div class="posts-grid">
        @forelse($posts as $i => $post)
            <article class="post-card {{ $i === 0 && !request('category') ? 'featured' : '' }}">

                {{-- Image --}}
                <div class="post-card-img-wrap">
                    @if ($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                            alt="{{ $post->featured_image_alt ?? $post->title }}" class="post-card-img"
                            loading="{{ $i < 2 ? 'eager' : 'lazy' }}">
                    @else
                        <div class="post-card-img-placeholder">🪑</div>
                    @endif
                    <div class="post-card-img-overlay"></div>
                    <div class="post-card-read-btn">اقرأ المقال ←</div>
                </div>

                {{-- Body --}}
                <div class="post-card-body">

                    @if ($i === 0 && !request('category'))
                        <div class="featured-label">⭐ مقال مميز</div>
                    @endif

                    @if ($post->categories->isNotEmpty())
                        <div class="post-card-cats">
                            @foreach ($post->categories as $cat)
                                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                                    class="cat-badge">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    @endif

                    <h2 class="post-card-title">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>

                    @if ($post->excerpt)
                        <p class="post-card-excerpt">{{ $post->excerpt }}</p>
                    @endif

                    <div class="post-card-meta">
                        @if ($post->author_name)
                            <span>✍ {{ $post->author_name }}</span>
                            <span class="meta-dot"></span>
                        @endif
                        <span>{{ $post->published_at->diffForHumans() }}</span>
                        @if ($post->reading_time)
                            <span class="meta-dot"></span>
                            <span>⏱ {{ $post->reading_time }} د</span>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div style="grid-column:1/-1;">
                <div class="empty-state">
                    <span class="empty-state-icon">📭</span>
                    <h3>لا توجد مقالات بعد</h3>
                    <p style="font-size:0.9rem;">
                        @if (request('category'))
                            لا توجد مقالات في هذا التصنيف حالياً.
                            <a href="{{ route('blog.index') }}" style="color:#2563eb;">عرض الكل</a>
                        @else
                            سيتم نشر المحتوى قريباً، تابعنا!
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($posts->hasPages())
        <div class="pagination-wrap">
            {{ $posts->withQueryString()->links() }}
        </div>
    @endif
@endsection
