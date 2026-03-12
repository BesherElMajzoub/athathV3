@extends('layouts.main')

@section('title', 'خدمات شراء الأثاث المستعمل في جدة | جميع الأقسام')
@section('meta_description', 'تصفح جميع خدماتنا في شراء الأثاث المستعمل بجدة: أثاث، مطابخ، مكيفات، أجهزة، غرف نوم، كنب،
    عفش، معدات مطاعم، سكراب. تقييم عادل ودفع فوري.')

    @push('schema')
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type": "ListItem", "position": 1, "name": "الرئيسية", "item": "{{ url('/') }}"},
    {"@@type": "ListItem", "position": 2, "name": "الخدمات"}
  ]
}
</script>
    @endpush

@section('content')
    <section class="section">
        <div class="container">
            {{-- Breadcrumb --}}
            <nav class="breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}">الرئيسية</a> ›
                <span>الخدمات</span>
            </nav>

            <div class="text-center" style="margin-bottom:3rem;">
                <span class="section-badge">خدماتنا</span>
                <h1 class="section-title">خدمات شراء الأثاث المستعمل بجدة</h1>
                <p class="section-desc">
                    إذا كنت تبحث عن شركة موثوقة متخصصة في <strong>شراء عفش مستعمل بمدينة جدة</strong>، فنحن نوفر لك باقة
                    شاملة من الخدمات. سواء كنت ترغب في التخلص من غرف نوم قديمة، أو تجديد المطابخ المستعملة، أو بيع الأجهزة
                    الكهربائية، فإننا نغطي جميع هذه الاحتياجات بأسعار عادلة وشفافية.
                </p>
            </div>

            @php
                $icons = [
                    'شراء-اثاث-مستعمل-بجدة' => '🛋️',
                    'شراء-مطابخ-مستعملة-بجدة' => '🍳',
                    'شراء-مكيفات-مستعملة-بجدة' => '❄️',
                    'شراء-اجهزة-مستعملة-بجدة' => '📺',
                    'شراء-غرف-نوم-مستعملة-بجدة' => '🛏️',
                    'شراء-كنب-مستعمل-بجدة' => '🛋️',
                    'شراء-عفش-مستعمل-بجدة' => '📦',
                    'شراء-معدات-مطاعم-مستعملة-بجدة' => '🍽️',
                    'شراء-سكراب-بجدة' => '♻️',
                ];
            @endphp

            <div class="grid grid-3">
                @forelse($services as $service)
                    <a href="{{ route('services.show', $service->slug) }}" class="card service-card card-flat">
                        <div class="card-icon">{{ $icons[$service->slug] ?? '📦' }}</div>
                        <h2 style="font-size:1.05rem;font-weight:700;color:var(--text);margin-bottom:.5rem;">
                            {{ $service->title }}</h2>
                        <p style="font-size:.9rem;color:var(--muted);line-height:1.7;margin-bottom:1rem;">
                            {{ Str::limit(strip_tags($service->content), 120) }}</p>
                        <span class="card-link">عرض التفاصيل ←</span>
                    </a>
                @empty
                    <div class="card" style="grid-column:1/-1;text-align:center;padding:3rem;">
                        <p class="text-muted" style="font-size:1.1rem;">جاري إضافة تفاصيل الخدمات قريباً.</p>
                    </div>
                @endforelse
            </div>

            {{-- Internal Links --}}
            <div style="margin-top:3rem;" class="text-center">
                <h3 style="font-weight:700;margin-bottom:1rem;font-size:1.1rem;">صفحات ذات صلة</h3>
                <div class="links-bar">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('districts.index') }}">أحياء جدة</a>
                    <a href="{{ url('/blog') }}">المدونة</a>
                    <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                    <a href="{{ route('contact') }}">تواصل معنا</a>
                </div>
            </div>
        </div>
    </section>
@endsection
