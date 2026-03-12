<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — الصفحة غير موجودة | {{ config('app.name') }}</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
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
            --mint: #BFE7CF;
            --bg: #F6FBF7;
            --text: #123018;
            --muted: #5D6F62;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            text-align: center;
            overflow: hidden;
        }

        /* Background blobs */
        body::before {
            content: '';
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(191, 231, 207, .35) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            pointer-events: none;
            border-radius: 50%;
        }

        body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(47, 107, 63, .08) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            pointer-events: none;
            border-radius: 50%;
        }

        .page {
            position: relative;
            z-index: 1;
            max-width: 560px;
        }

        /* Big 404 number */
        .error-code {
            font-size: clamp(6rem, 20vw, 10rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, var(--primary) 0%, #6FAF7B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.25rem;
            letter-spacing: -4px;
            animation: fadeInDown 0.6s ease both;
        }

        .error-icon {
            font-size: 4rem;
            display: block;
            margin-bottom: 1.5rem;
            animation: bounce 2s infinite ease-in-out;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

        .error-title {
            font-size: clamp(1.4rem, 4vw, 2rem);
            font-weight: 900;
            color: var(--text);
            margin-bottom: 0.875rem;
            animation: fadeInUp 0.6s ease 0.15s both;
        }

        .error-desc {
            font-size: 1.05rem;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            animation: fadeInUp 0.6s ease 0.25s both;
        }

        .error-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
            animation: fadeInUp 0.6s ease 0.35s both;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.8rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.95rem;
            font-family: inherit;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
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
            background: #245632;
            box-shadow: 0 8px 25px rgba(47, 107, 63, .3);
        }

        .btn-whatsapp {
            background: #25d366;
            color: #fff;
        }

        .btn-whatsapp:hover {
            background: #1fba59;
            box-shadow: 0 8px 25px rgba(37, 211, 102, .3);
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

        /* Suggested links */
        .suggest-title {
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 600;
            margin-bottom: 0.875rem;
            animation: fadeInUp 0.6s ease 0.45s both;
        }

        .suggest-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
            animation: fadeInUp 0.6s ease 0.5s both;
        }

        .suggest-links a {
            background: #fff;
            border: 1px solid rgba(47, 107, 63, .12);
            border-radius: 999px;
            padding: 0.4rem 1rem;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            transition: all 0.15s;
        }

        .suggest-links a:hover {
            background: var(--mint);
            border-color: var(--mint);
        }

        /* Logo */
        .error-logo {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
    </style>
</head>

<body>
    <a href="{{ route('home') }}" class="error-logo">🪑 {{ config('app.name') }}</a>

    <div class="page">
        <span class="error-icon">🔍</span>
        <div class="error-code">404</div>
        <h1 class="error-title">عذراً، الصفحة غير موجودة!</h1>
        <p class="error-desc">
            يبدو أن الصفحة التي تبحث عنها قد نُقلت أو حُذفت أو لم تكن موجودة أصلاً.
            لا تقلق، يمكنك العودة للرئيسية أو تواصل معنا مباشرة.
        </p>

        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn btn-primary">
                🏠 العودة للرئيسية
            </a>
            <a href="https://wa.me/{{ config('business.whatsapp') }}" class="btn btn-whatsapp"
                rel="nofollow noopener noreferrer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                تواصل واتساب
            </a>
            <a href="{{ url('/blog') }}" class="btn btn-outline">📖 المدونة</a>
        </div>

        <p class="suggest-title">أو تصفح إحدى هذه الصفحات:</p>
        <div class="suggest-links">
            <a href="{{ route('services.index') }}">الخدمات</a>
            <a href="{{ route('about') }}">من نحن</a>
            <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
            <a href="{{ route('contact') }}">اتصل بنا</a>
            <a href="{{ route('districts.index') }}">أحياء جدة</a>
        </div>
    </div>
</body>

</html>
