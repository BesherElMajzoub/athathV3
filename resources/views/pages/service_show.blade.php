@extends('layouts.main')

@section('title', $service->meta_title ?? $service->title)
@section('meta_description', $service->meta_description)
@section('canonical', $service->getEffectiveCanonical())

@push('schema')
    <script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@@type": "Service",
  "name": "{{ $service->title }}",
  "provider": {
    "@@type": "LocalBusiness",
    "name": "{{ config('app.name') }}",
    "telephone": "{{ config('business.phone') }}"
  },
  "areaServed": "Jeddah",
  "description": "{{ $service->meta_description }}"
}
    </script>
    <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type": "ListItem", "position": 1, "name": "الرئيسية", "item": "{{ url('/') }}"},
    {"@@type": "ListItem", "position": 2, "name": "الخدمات", "item": "{{ route('services.index') }}"},
    {"@@type": "ListItem", "position": 3, "name": "{{ $service->title }}"}
  ]
}
    </script>

    @if (!empty($service->schema_faq))
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    @foreach($service->schema_faq as $ix => $faq)
    {
      "@@type": "Question",
      "name": "{{ $faq['question'] }}",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "{{ $faq['answer'] }}"
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
        </script>
    @endif
@endpush

@push('head')
    <style>
        /* ===== SERVICE PAGE OVERRIDES ===== */

        /* Hero Banner for Service */
        .service-hero {
            background: linear-gradient(135deg, rgba(47, 107, 63, .06) 0%, rgba(191, 231, 207, .2) 100%);
            border-bottom: 1px solid var(--border);
            padding: 2.5rem 0 2rem;
            margin-bottom: 0;
        }

        .service-hero-inner {
            max-width: 860px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .service-hero .breadcrumb {
            padding-top: 0;
            margin-bottom: 1.25rem;
        }

        .service-title-wrap {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
        }

        .service-icon-box {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--mint), #e8f5ed);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(47, 107, 63, .12);
        }

        .service-hero h1 {
            font-size: clamp(1.7rem, 4vw, 2.5rem);
            font-weight: 900;
            color: var(--text);
            line-height: 1.28;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .service-hero-desc {
            font-size: 1rem;
            color: var(--muted);
            line-height: 1.75;
            max-width: 620px;
        }

        /* ===== QUICK CTA BAR ===== */
        .quick-cta-bar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0.875rem 0;
            position: sticky;
            top: 64px;
            z-index: 50;
            box-shadow: 0 2px 8px rgba(18, 48, 24, .05);
        }

        .quick-cta-inner {
            max-width: 860px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .quick-cta-text {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text);
        }

        .quick-cta-text span {
            color: var(--primary);
        }

        .quick-cta-btns {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: .5rem 1.1rem !important;
            font-size: .82rem !important;
            gap: .35rem !important;
        }

        /* ===== CONTENT AREA ===== */
        .service-layout {
            max-width: 860px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }

        /* Featured Image */
        .service-featured-img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-radius: var(--radius);
            margin-bottom: 2.5rem;
            box-shadow: 0 8px 32px rgba(18, 48, 24, .1);
        }

        /* Content */
        .service-content {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 2rem 2.25rem;
            margin-bottom: 2rem;
            font-size: 1.05rem;
            line-height: 1.9;
            color: var(--text);
            box-shadow: var(--shadow);
        }

        .service-content h2 {
            font-size: 1.45rem;
            font-weight: 800;
            margin: 2rem 0 0.875rem;
            color: var(--text);
            border-bottom: 2px solid var(--mint);
            padding-bottom: 0.5rem;
        }

        .service-content h2:first-child {
            margin-top: 0;
        }

        .service-content h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 1.5rem 0 0.6rem;
        }

        .service-content p {
            margin-bottom: 1.25rem;
        }

        .service-content ul,
        .service-content ol {
            padding-right: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .service-content li {
            margin-bottom: 0.5rem;
        }

        .service-content a {
            color: var(--primary);
            font-weight: 500;
        }

        .service-content a:hover {
            text-decoration: underline;
        }

        .service-content blockquote {
            border-right: 4px solid var(--primary);
            background: rgba(191, 231, 207, .2);
            border-radius: 0 12px 12px 0;
            padding: 1rem 1.25rem;
            margin: 1.5rem 0;
            color: var(--primary-hover);
            font-style: italic;
        }

        .service-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .service-content th,
        .service-content td {
            border: 1px solid var(--border);
            padding: 0.7rem 1rem;
            text-align: right;
        }

        .service-content th {
            background: rgba(191, 231, 207, .3);
            font-weight: 700;
            color: var(--primary);
        }

        /* ===== FAQ ===== */
        .service-faq-section {
            margin-bottom: 2rem;
        }

        .service-faq-section h2 {
            font-size: 1.35rem;
            font-weight: 900;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ===== CTA BANNER ===== */
        .service-cta {
            background: linear-gradient(135deg, var(--primary) 0%, #3d8a52 100%);
            border-radius: var(--radius);
            padding: 2.5rem 2rem;
            color: #fff;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 2.5rem;
        }

        .service-cta::before {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            background: rgba(255, 255, 255, .07);
            border-radius: 50%;
            top: -100px;
            left: -60px;
        }

        .service-cta::after {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%;
            bottom: -60px;
            right: 10%;
        }

        .service-cta h2 {
            font-size: 1.5rem;
            font-weight: 900;
            margin-bottom: 0.7rem;
            position: relative;
        }

        .service-cta p {
            font-size: 0.95rem;
            opacity: .9;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .service-cta-btns {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
        }

        /* WhatsApp button custom */
        .btn-wa-official {
            background: #25d366;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: .8rem 1.8rem;
            border-radius: var(--radius-pill);
            font-weight: 700;
            font-size: .95rem;
            font-family: var(--font);
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all .25s ease;
            white-space: nowrap;
        }

        .btn-wa-official:hover {
            background: #1fba59;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, .35);
        }

        .btn-wa-official svg {
            flex-shrink: 0;
        }

        /* ===== INTERNAL LINKS ===== */
        .related-services {
            margin-bottom: 1rem;
        }

        .related-services h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text);
        }

        @media (max-width: 640px) {
            .service-content {
                padding: 1.5rem 1.25rem;
            }

            .service-hero h1 {
                font-size: 1.5rem;
            }

            .service-title-wrap {
                flex-direction: column;
                gap: 0.75rem;
            }

            .quick-cta-text {
                display: none;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Service Hero --}}
    <div class="service-hero">
        <div class="service-hero-inner">
            <nav class="breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}">الرئيسية</a> ›
                <a href="{{ route('services.index') }}">الخدمات</a> ›
                <span>{{ $service->title }}</span>
            </nav>

            <div class="service-title-wrap">
                <div class="service-icon-box">💰</div>
                <div>
                    <h1>{{ $service->title }}</h1>
                    @if ($service->meta_description)
                        <p class="service-hero-desc">{{ Str::limit($service->meta_description, 140) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Quick CTA Bar --}}
    <div class="quick-cta-bar">
        <div class="quick-cta-inner">
            <div class="quick-cta-text">
                🏆 تقييم فوري ودفع نقدي — <span>نغطي جميع أحياء جدة</span>
            </div>
            <div class="quick-cta-btns">
                <a href="https://wa.me/{{ config('business.whatsapp') }}" class="btn btn-whatsapp btn-sm"
                    rel="nofollow noopener noreferrer" data-track="cta_whatsapp_click" data-placement="service_sticky"
                    data-target="https://wa.me/{{ config('business.whatsapp') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    أرسل الصور
                </a>
                <a href="tel:{{ config('business.phone') }}" class="btn btn-primary btn-sm" data-track="cta_call_click"
                    data-placement="service_sticky" data-target="tel:{{ config('business.phone') }}">
                    📞 اتصل
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="service-layout">

        {{-- Featured Image --}}
        @if ($service->og_image)
            <img src="{{ asset('storage/' . $service->og_image) }}" alt="{{ $service->title }}"
                class="service-featured-img">
        @endif

        {{-- Content --}}
        <div class="service-content">
            {!! $service->content !!}
        </div>

        {{-- FAQ --}}
        @if (!empty($service->schema_faq))
            <div class="service-faq-section">
                <h2><span>❓</span> الأسئلة الشائعة</h2>
                <div class="card faq-card">
                    @foreach ($service->schema_faq as $faq)
                        <details>
                            <summary>{{ $faq['question'] }}</summary>
                            <div class="faq-answer">{{ $faq['answer'] }}</div>
                        </details>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CTA Banner --}}
        <div class="service-cta">
            <h2>هل تريد أفضل سعر لـ{{ $service->title }}؟</h2>
            <p>أرسل لنا صور الأثاث أو المعدات عبر الواتساب لتقييم فوري ومجاني — نصلك في نفس اليوم في جميع أحياء جدة.</p>
            <div class="service-cta-btns">
                <a href="https://wa.me/{{ config('business.whatsapp') }}" class="btn-wa-official"
                    rel="nofollow noopener noreferrer" data-track="cta_whatsapp_click" data-placement="service_cta_bottom"
                    data-target="https://wa.me/{{ config('business.whatsapp') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    أرسل الصور الآن
                </a>
                <a href="tel:{{ config('business.phone') }}" class="btn btn-light" data-track="cta_call_click"
                    data-placement="service_cta_bottom" data-target="tel:{{ config('business.phone') }}">
                    📞 اتصل الآن
                </a>
            </div>
        </div>

        {{-- Related Services --}}
        <div class="related-services">
            <h3>🔗 خدمات أخرى قد تهمك</h3>
            <div class="links-bar" style="justify-content:flex-start;">
                <a href="{{ url('/services/شراء-اثاث-مستعمل-بجدة') }}">شراء أثاث مستعمل</a>
                <a href="{{ url('/services/شراء-مكيفات-مستعملة-بجدة') }}">شراء مكيفات</a>
                <a href="{{ url('/services/شراء-مطابخ-مستعملة-بجدة') }}">شراء مطابخ</a>
                <a href="{{ url('/services/شراء-اجهزة-مستعملة-بجدة') }}">شراء أجهزة</a>
                <a href="{{ url('/services/شراء-غرف-نوم-مستعملة-بجدة') }}">شراء غرف نوم</a>
                <a href="{{ url('/services/شراء-كنب-مستعمل-بجدة') }}">شراء كنب</a>
                <a href="{{ url('/services/شراء-عفش-مستعمل-بجدة') }}">شراء عفش</a>
                <a href="{{ url('/services/شراء-معدات-مطاعم-مستعملة-بجدة') }}">معدات مطاعم</a>
                <a href="{{ url('/services/شراء-سكراب-بجدة') }}">شراء سكراب</a>
            </div>
        </div>

    </div>

@endsection
