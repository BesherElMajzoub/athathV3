@extends('layouts.main')

@section('title', $district->meta_title ?? $district->title)
@section('meta_description', $district->meta_description)
@section('canonical', $district->getEffectiveCanonical())

@push('schema')
    <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type": "ListItem", "position": 1, "name": "الرئيسية", "item": "{{ url('/') }}"},
    {"@@type": "ListItem", "position": 2, "name": "أحياء جدة", "item": "{{ route('districts.index') }}"},
    {"@@type": "ListItem", "position": 3, "name": "{{ $district->title }}"}
  ]
}
</script>
@endpush

@section('content')
    <section class="section-sm" style="background:var(--surface);">
        <div class="container" style="max-width:860px;">
            <nav class="breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}">الرئيسية</a> ›
                <a href="{{ route('districts.index') }}">أحياء جدة</a> ›
                <span>{{ $district->title }}</span>
            </nav>

            <article>
                <h1 class="section-title" style="font-size:clamp(1.8rem,4vw,2.6rem);margin-bottom:1.5rem;">
                    {{ $district->title }}</h1>

                <div class="card" style="margin-bottom:2.5rem;">
                    <div style="font-size:1.05rem;color:var(--text);line-height:1.9;">
                        {!! $district->content !!}
                    </div>
                </div>

                <div class="cta-banner">
                    <h2>متواجدون في {{ $district->title }} لخدمتكم</h2>
                    <p>نوفر سيارات نقل وعمالة ماهرة لفك ونقل الأثاث المستعمل والأجهزة من موقعكم بسرعة.</p>
                    <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;position:relative;">
                        <a href="https://wa.me/966500000000" class="btn btn-whatsapp track-cta"
                            data-cta-type="cta_whatsapp_district">💬 واتساب</a>
                        <a href="tel:+966500000000" class="btn btn-light track-cta" data-cta-type="cta_call_district">📞
                            اتصل بمندوب الحي</a>
                    </div>
                </div>

                <div style="margin-top:2.5rem;">
                    <h3 style="font-weight:700;margin-bottom:1rem;font-size:1.1rem;">صفحات ذات صلة</h3>
                    <div class="links-bar" style="justify-content:flex-start;">
                        <a href="{{ route('districts.index') }}">جميع أحياء جدة</a>
                        <a href="{{ route('services.index') }}">خدماتنا</a>
                        <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                        <a href="{{ route('contact') }}">تواصل معنا</a>
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
