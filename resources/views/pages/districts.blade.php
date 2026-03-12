@extends('layouts.main')

@section('title', 'مناطق خدمتنا في جدة | شراء الأثاث المستعمل بكل الأحياء')
@section('meta_description', 'تعرف على الأحياء التي نغطيها لخدمات تقييم وشراء الأثاث المستعمل والأجهزة بمدينة جدة. خدمتك
    حيث كنت وبأسرع وقت.')

    @push('schema')
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type": "ListItem", "position": 1, "name": "الرئيسية", "item": "{{ url('/') }}"},
    {"@@type": "ListItem", "position": 2, "name": "أحياء جدة"}
  ]
}
</script>
    @endpush

@section('content')
    <section class="section">
        <div class="container">
            <nav class="breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}">الرئيسية</a> ›
                <span>أحياء جدة</span>
            </nav>

            <div class="text-center" style="margin-bottom:3rem;">
                <span class="section-badge">📍 التغطية</span>
                <h1 class="section-title">أحياء جدة المشمولة بالخدمة</h1>
                <p class="section-desc">نلتزم بتغطية كافة أحياء جدة لتقديم أسرع استجابة ممكنة عند رغبتك في بيع الأثاث
                    المستعمل. فريقنا يتجول يومياً في جميع أحياء المدينة.</p>
            </div>

            <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
                @forelse($districts as $district)
                    <a href="{{ route('districts.show', $district->slug) }}" class="card card-flat text-center service-card"
                        style="text-decoration:none;">
                        <div class="card-icon" style="margin:0 auto 1rem;">📍</div>
                        <h3 style="font-weight:700;color:var(--text);margin-bottom:.3rem;">{{ $district->title }}</h3>
                        <span style="font-size:.85rem;color:var(--muted);">شراء أثاث في الحي</span>
                    </a>
                @empty
                    <div class="card" style="grid-column:1/-1;text-align:center;padding:3rem;">
                        <p class="text-muted" style="font-size:1.1rem;">قريباً سيتم إضافة الأحياء.</p>
                    </div>
                @endforelse
            </div>

            {{-- Internal Links --}}
            <div style="margin-top:3rem;" class="text-center">
                <h3 style="font-weight:700;margin-bottom:1rem;font-size:1.1rem;">صفحات ذات صلة</h3>
                <div class="links-bar">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('services.index') }}">جميع الخدمات</a>
                    <a href="{{ url('/blog') }}">المدونة</a>
                    <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                    <a href="{{ route('contact') }}">تواصل معنا</a>
                </div>
            </div>
        </div>
    </section>
@endsection
