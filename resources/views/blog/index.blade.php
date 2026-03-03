@extends('layouts.blog', ['seo' => $seo])

@section('content')
    <style>
        .blog-hero {
            margin-bottom: 3rem;
        }

        .blog-hero h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .blog-hero p {
            color: #6b7280;
            font-size: 1.05rem;
        }

        .blog-layout {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 2.5rem;
        }

        @media(max-width:768px) {
            .blog-layout {
                grid-template-columns: 1fr;
            }
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .post-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
            background: #fff;
        }

        .post-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .post-card-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .post-card-img-placeholder {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #dbeafe, #e0e7ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .post-card-body {
            padding: 1.25rem;
        }

        .post-card-cats {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-bottom: 0.75rem;
        }

        .cat-badge {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
        }

        .cat-badge:hover {
            background: #dbeafe;
        }

        .post-card h2 {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .post-card h2 a {
            text-decoration: none;
            color: inherit;
        }

        .post-card h2 a:hover {
            color: #2563eb;
        }

        .post-card-excerpt {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-card-meta {
            font-size: 0.8rem;
            color: #9ca3af;
            display: flex;
            gap: 0.75rem;
        }

        .sidebar-widget {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .sidebar-widget h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cat-list a {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            text-decoration: none;
            color: #374151;
            font-size: 0.9rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .cat-list a:hover {
            color: #2563eb;
        }
    </style>

    <div class="blog-hero">
        <h1>المدونة</h1>
        <p>نصائح وإرشادات حول شراء وبيع الأثاث المستعمل</p>
    </div>

    <div class="blog-layout">
        {{-- Posts Grid --}}
        <div>
            <div class="posts-grid">
                @forelse($posts as $post)
                    <article class="post-card">
                        @if ($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                alt="{{ $post->featured_image_alt ?? $post->title }}" class="post-card-img" loading="lazy">
                        @else
                            <div class="post-card-img-placeholder">📝</div>
                        @endif
                        <div class="post-card-body">
                            @if ($post->categories->isNotEmpty())
                                <div class="post-card-cats">
                                    @foreach ($post->categories as $cat)
                                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                                            class="cat-badge">{{ $cat->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                            <h2><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
                            @if ($post->excerpt)
                                <p class="post-card-excerpt">{{ $post->excerpt }}</p>
                            @endif
                            <div class="post-card-meta">
                                @if ($post->author_name)
                                    <span>✍ {{ $post->author_name }}</span>
                                @endif
                                <span>📅 {{ $post->published_at->diffForHumans() }}</span>
                                @if ($post->reading_time)
                                    <span>⏱ {{ $post->reading_time }} د قراءة</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#6b7280;">
                        <p style="font-size:3rem;">📭</p>
                        <p>لا توجد مقالات بعد.</p>
                    </div>
                @endforelse
            </div>

            @if ($posts->hasPages())
                <div style="margin-top:2rem;display:flex;justify-content:center;">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside>
            <div class="sidebar-widget">
                <h3>التصنيفات</h3>
                <div class="cat-list">
                    @foreach ($categories as $cat)
                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}">
                            {{ $cat->name }}
                            @if ($cat->posts_count > 0)
                                <span style="color:#9ca3af;">{{ $cat->posts_count }}</span>
                            @endif
                        </a>
                    @endforeach
                    @if ($categories->isEmpty())
                        <p style="color:#9ca3af;font-size:0.85rem;">لا توجد تصنيفات.</p>
                    @endif
                </div>
            </div>
        </aside>
    </div>
@endsection
