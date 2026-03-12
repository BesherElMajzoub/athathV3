@extends('layouts.main')

@section('title', 'من نحن - مؤسسة شراء الأثاث المستعمل بجدة')
@section('meta_description', 'تعرف على مؤسستنا المتخصصة في شراء الأثاث المستعمل بجدة. نقدم تقييم عادل، فك ونقل مجاني،
    ودفع فوري نقداً في جميع أحياء جدة.')
@section('canonical', url('/about'))

@push('schema')
    <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "name": "مؤسسة شراء الأثاث المستعمل بجدة",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('assets/og-default.jpg') }}",
  "telephone": "{{ config('business.phone') }}",
  "address": {
    "@@type": "PostalAddress",
    "addressLocality": "جدة",
    "addressRegion": "مكة المكرمة",
    "addressCountry": "SA"
  },
  "areaServed": "Jeddah",
  "description": "مؤسسة سعودية متخصصة في تقييم وشراء جميع أنواع الأثاث والأجهزة المستعملة في مدينة جدة بأعلى الأسعار."
}
</script>
    <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type": "ListItem", "position": 1, "name": "الرئيسية", "item": "{{ url('/') }}"},
    {"@@type": "ListItem", "position": 2, "name": "من نحن"}
  ]
}
</script>
@endpush

@section('content')
    <section class="section">
        <div class="container" style="max-width:900px;">
            <nav class="breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}">الرئيسية</a> ›
                <span>من نحن</span>
            </nav>

            <div class="text-center" style="margin-bottom:3rem;">
                <span class="section-badge">🏢 من نحن</span>
                <h1 class="section-title">مؤسسة شراء الأثاث المستعمل بجدة</h1>
                <p class="section-desc">خدمة موثوقة، تسعير عادل، ووجع راسك يمشي منك في يوم واحد.</p>
            </div>

            {{-- Main Story --}}
            <div class="card" style="margin-bottom:2rem;">
                <div style="font-size:1.05rem;line-height:2;color:var(--text);">
                    <p style="margin-bottom:1.25rem;">
                        بدأت مؤسستنا من قناعة راسخة: <strong>المواطن في جدة يستحق خدمة شراء أثاث مريحة وعادلة</strong>،
                        بعيداً عن الإزعاج والتفاوض الطويل أو انتظار مشترين من حراج.
                    </p>
                    <p style="margin-bottom:1.25rem;">
                        نحن فريق سعودي متخصص في <strong>شراء جميع أنواع الأثاث المستعمل</strong> في مدينة جدة — من غرف النوم
                        والمجالس والمطابخ، وصولاً للمكيفات والأجهزة الكهربائية ومعدات المطاعم والسكراب. نعمل يومياً في جميع
                        أحياء جدة شمالاً وجنوباً وشرقاً وغرباً.
                    </p>
                    <p>
                        مبدأنا الأول هو <strong>الشفافية والتسعير العادل</strong>: نقيّم الأثاث بحضورك ونقدم لك سعراً واضحاً
                        بدون ضغط أو مراوغة. إذا اتفقنا، فريقنا يفك وينقل كل شيء على حسابنا ويسلّمك المبلغ نقداً في نفس
                        اليوم.
                    </p>
                </div>
            </div>

            {{-- Values Grid --}}
            <div class="grid grid-2" style="margin-bottom:2.5rem;">
                <div class="card card-flat" style="display:flex;gap:1rem;align-items:flex-start;">
                    <div style="font-size:2rem;flex-shrink:0;">💰</div>
                    <div>
                        <h3 style="font-weight:700;margin-bottom:.4rem;">أعلى سعر ممكن</h3>
                        <p class="text-muted" style="font-size:.9rem;line-height:1.7;">نعتمد على أسعار السوق الحالية ونضمن
                            لك عرضاً تنافسياً يفوق ما تجده في المنصات الإلكترونية.</p>
                    </div>
                </div>
                <div class="card card-flat" style="display:flex;gap:1rem;align-items:flex-start;">
                    <div style="font-size:2rem;flex-shrink:0;">🚚</div>
                    <div>
                        <h3 style="font-weight:700;margin-bottom:.4rem;">فك ونقل مجاني</h3>
                        <p class="text-muted" style="font-size:.9rem;line-height:1.7;">فريق فني متخصص يصل لمنزلك ويتولى الفك
                            والتغليف والنقل بدون أي تكاليف إضافية عليك.</p>
                    </div>
                </div>
                <div class="card card-flat" style="display:flex;gap:1rem;align-items:flex-start;">
                    <div style="font-size:2rem;flex-shrink:0;">⚡</div>
                    <div>
                        <h3 style="font-weight:700;margin-bottom:.4rem;">دفع فوري نقداً</h3>
                        <p class="text-muted" style="font-size:.9rem;line-height:1.7;">لا تأخير ولا وعود. المبلغ المتفق عليه
                            يُسلَّم نقداً أو تحويل بنكي فور الاستلام.</p>
                    </div>
                </div>
                <div class="card card-flat" style="display:flex;gap:1rem;align-items:flex-start;">
                    <div style="font-size:2rem;flex-shrink:0;">📍</div>
                    <div>
                        <h3 style="font-weight:700;margin-bottom:.4rem;">تغطية كاملة لجدة</h3>
                        <p class="text-muted" style="font-size:.9rem;line-height:1.7;">سياراتنا تتجول يومياً في جميع أحياء
                            جدة — الصفا، الروضة، المروة، العزيزية، النزهة، وكل الأحياء.</p>
                    </div>
                </div>
                <div class="card card-flat" style="display:flex;gap:1rem;align-items:flex-start;">
                    <div style="font-size:2rem;flex-shrink:0;">🤝</div>
                    <div>
                        <h3 style="font-weight:700;margin-bottom:.4rem;">تعامل احترافي وراقٍ</h3>
                        <p class="text-muted" style="font-size:.9rem;line-height:1.7;">الاحترام والمصداقية قيمتان أساسيتان
                            في فريقنا. نتعامل مع عفش بيتك كأنه بيتنا.</p>
                    </div>
                </div>
                <div class="card card-flat" style="display:flex;gap:1rem;align-items:flex-start;">
                    <div style="font-size:2rem;flex-shrink:0;">♻️</div>
                    <div>
                        <h3 style="font-weight:700;margin-bottom:.4rem;">مسؤولية بيئية</h3>
                        <p class="text-muted" style="font-size:.9rem;line-height:1.7;">نعيد تدوير ما يمكن تدويره ونُعيد
                            توزيع الأثاث الصالح بدل التخلص منه في مكبات النفايات.</p>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <div class="cta-banner">
                <h2>جاهزون لخدمتك اليوم</h2>
                <p>تواصل معنا الآن لتحديد موعد التقييم المجاني وبيع أثاثك بأفضل الأسعار في جدة.</p>
                <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;position:relative;">
                    <a href="https://wa.me/{{ config('business.whatsapp') }}" class="btn btn-whatsapp"
                        data-track="cta_whatsapp_click" data-placement="about"
                        data-target="https://wa.me/{{ config('business.whatsapp') }}">
                        💬 تواصل واتساب
                    </a>
                    <a href="tel:{{ config('business.phone') }}" class="btn btn-light" data-track="cta_call_click"
                        data-placement="about" data-target="tel:{{ config('business.phone') }}">
                        📞 اتصل الآن
                    </a>
                </div>
            </div>

            {{-- Internal Links --}}
            <div style="margin-top:2.5rem;" class="text-center">
                <h3 style="font-weight:700;margin-bottom:1rem;font-size:1.1rem;">استكشف المزيد</h3>
                <div class="links-bar">
                    <a href="{{ route('services.index') }}">خدماتنا</a>
                    <a href="{{ route('districts.index') }}">أحياء جدة</a>
                    <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                    <a href="{{ route('contact') }}">تواصل معنا</a>
                    <a href="{{ url('/blog') }}">المدونة</a>
                </div>
            </div>
        </div>
    </section>
@endsection
