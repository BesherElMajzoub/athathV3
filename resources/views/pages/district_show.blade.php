@extends('layouts.main')

@section('title', $district->meta_title ?? $district->title)
@section('meta_description', $district->meta_description)
@section('canonical', $district->getEffectiveCanonical())

@section('content')
    <div class="container py-16">
        <nav aria-label="breadcrumb" style="font-size:0.9rem;margin-bottom:1.5rem;color:#6b7280;">
            <a href="/" style="color:#2563eb;text-decoration:none;">الرئيسية</a> ›
            <a href="{{ route('districts.index') }}" style="color:#2563eb;text-decoration:none;">أحياء جدة</a> ›
            <span>{{ $district->title }}</span>
        </nav>

        <article>
            <h1 class="font-black" style="font-size:clamp(2rem, 5vw, 3rem);color:#1e3a8a;margin-bottom:2rem;line-height:1.2;">
                {{ $district->title }}</h1>

            <div style="font-size:1.1rem;color:#374151;line-height:1.8;">
                {!! $district->content !!}
            </div>

            <div style="margin-top:4rem;background:#f3f4f6;padding:3rem 2rem;border-radius:12px;text-align:center;">
                <h2 class="font-black" style="font-size:1.8rem;margin-bottom:1rem;">متواجدون في {{ $district->title }}
                    لخدمتكم 24/7</h2>
                <p style="margin-bottom:2rem;">نوفر سيارات نقل وعمالة ماهرة لفك ونقل الأثاث المستعمل والأجهزة من موقعكم
                    بسرعة وبدون إزعاج.</p>
                <a href="tel:+966500000000" class="btn btn-call track-cta" data-cta-type="cta_call_district"
                    style="font-size:1.2rem;padding:1rem 2rem;">📞 اتصل بنادوب لحيّكم الآن</a>
            </div>
        </article>
    </div>
@endsection
