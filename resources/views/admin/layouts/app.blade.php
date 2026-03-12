<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') - {{ config('app.name') }}</title>
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
            --primary-dark: #1d4ed8;
            --danger: #dc2626;
            --success: #16a34a;
            --warning: #d97706;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-700: #374151;
            --gray-900: #111827;
            --sidebar-w: 260px;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--gray-900);
            color: #fff;
            min-height: 100vh;
            padding: 0;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 1.25rem 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-group-label {
            padding: 0.5rem 1.5rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1.5rem;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            transition: all 0.15s;
            font-size: 0.9rem;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .nav-link .icon {
            width: 18px;
            text-align: center;
            opacity: 0.8;
        }

        .main-content {
            margin-right: var(--sidebar-w);
            flex: 1;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .content-area {
            padding: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            font-weight: 500;
            transition: all 0.15s;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border-color: var(--gray-200);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
        }

        .btn-success {
            background: var(--success);
            color: #fff;
        }

        .badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-published {
            background: #dcfce7;
            color: #166534;
        }

        .badge-draft {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge-scheduled {
            background: #dbeafe;
            color: #1e40af;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid var(--gray-200);
            padding: 1.5rem;
        }

        .alert {
            padding: 0.875rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        th {
            text-align: right;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid var(--gray-200);
            font-weight: 600;
            color: var(--gray-700);
        }

        td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
        }

        tr:hover td {
            background: var(--gray-50);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.4rem;
            font-size: 0.875rem;
        }

        input[type=text],
        input[type=url],
        input[type=datetime-local],
        input[type=date],
        select,
        textarea {
            width: 100%;
            padding: 0.6rem 0.875rem;
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.9rem;
            transition: border 0.15s;
            background: #fff;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .char-counter {
            font-size: 0.75rem;
            text-align: left;
            margin-top: 0.25rem;
        }

        .char-counter.ok {
            color: var(--success);
        }

        .char-counter.warn {
            color: var(--warning);
        }

        .char-counter.over {
            color: var(--danger);
        }
    </style>
    @stack('head')
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-logo">🪑 {{ config('app.name') }}</div>
        <nav class="sidebar-nav">
            <div class="nav-group-label">المحتوى</div>
            <a href="{{ route('admin.posts.index') }}"
                class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <span class="icon">📝</span> المقالات
            </a>
            <a href="{{ route('admin.programmatic.index') }}"
                class="nav-link {{ request()->routeIs('admin.programmatic.*') ? 'active' : '' }}">
                <span class="icon">⚡</span> الصفحات البرمجية
            </a>
            <a href="{{ route('admin.calendar.index') }}"
                class="nav-link {{ request()->routeIs('admin.calendar.*') ? 'active' : '' }}">
                <span class="icon">📅</span> تقويم المحتوى
            </a>

            <div class="nav-group-label">SEO</div>
            <a href="{{ route('admin.seo.clusters.index') }}"
                class="nav-link {{ request()->routeIs('admin.seo.clusters.*') ? 'active' : '' }}">
                <span class="icon">🔑</span> مجموعات الكلمات
            </a>
            <a href="{{ route('admin.seo.templates.index') }}"
                class="nav-link {{ request()->routeIs('admin.seo.templates.*') ? 'active' : '' }}">
                <span class="icon">📄</span> القوالب
            </a>
            <a href="{{ route('admin.seo.reports.index') }}"
                class="nav-link {{ request()->routeIs('admin.seo.reports.*') ? 'active' : '' }}">
                <span class="icon">📊</span> تقارير SEO
            </a>

            <div class="nav-group-label">التتبع</div>
            <a href="{{ route('admin.clicks.index') }}"
                class="nav-link {{ request()->routeIs('admin.clicks.*') ? 'active' : '' }}">
                <span class="icon">📈</span> تتبع النقرات
            </a>

            <div class="nav-group-label">روابط سريعة</div>
            <a href="{{ url('/') }}" target="_blank" class="nav-link"><span class="icon">🏠</span> الموقع</a>
            <a href="{{ url('/blog') }}" target="_blank" class="nav-link"><span class="icon">🌐</span> عرض
                المدونة</a>
            <a href="{{ url('/sitemap.xml') }}" target="_blank" class="nav-link"><span class="icon">🗺️</span>
                Sitemap</a>
        </nav>
    </aside>
    <div class="main-content">
        <div class="topbar">
            <div class="topbar-title">@yield('page-title', 'لوحة التحكم')</div>
            <div>@yield('topbar-actions')</div>
        </div>
        <div class="content-area">
            @if (session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">✗ {{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="list-style:none;padding:0;">
                        @foreach ($errors->all() as $error)
                            <li>✗ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>

</html>
