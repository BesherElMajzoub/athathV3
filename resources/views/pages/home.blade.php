@extends('layouts.main')

@section('title', 'شراء أثاث مستعمل بجدة | نشتري جميع أنواع الأثاث والأجهزة')
@section('meta_description', 'أفضل شركة لـ شراء أثاث مستعمل بجدة. تقييم فوري وعادل، ونشتري جميع الأثاث المنزلي والمكتبي
    والأجهزة الكهربائية، مع الدفع نقداً وفوراً.')

    @push('schema')
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "أثاث جدة الموثوق",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@@type": "SearchAction",
    "target": "{{ url('/search?q={search_term_string}') }}",
    "query-input": "required name=search_term_string"
  }
}
</script>
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "مؤسسة شراء الأثاث المستعمل بجدة",
  "image": "{{ asset('images/logo.webp') }}",
  "telephone": "+966500000000",
  "address": {
    "@@type": "PostalAddress",
    "addressLocality": "جدة",
    "addressRegion": "مكة المكرمة",
    "addressCountry": "SA"
  },
  "areaServed": "جدة",
  "description": "متخصصون في تسعير وشراء جميع أنواع الأثاث المستعمل والأجهزة الكهربائية بمدينة جدة بأفضل الأسعار."
}
</script>
    @endpush

@section('content')
    <section class="hero">
        <div class="container">
            <h1>أفضل من يشتري الأثاث المستعمل بجدة</h1>
            <p>نقدم خدمة تسعير عادلة وسريعة لجميع أنواع الأثاث المنزلي والمكتبي والأجهزة الكهربائية المستعملة. راحتك تهمنا،
                نقيم الأثاث عندك وندفع نقداً.</p>
            <div class="flex items-center justify-center gap-4">
                <a href="https://wa.me/966500000000" class="btn btn-whatsapp track-cta" data-cta-type="cta_whatsapp_hero">تواصل
                    واتساب</a>
                <a href="tel:+966500000000" class="btn btn-call track-cta" data-cta-type="cta_call_hero">اتصل الآن</a>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container">
            <div class="text-center" style="margin-bottom:3rem;">
                <h2 class="font-black" style="font-size:2rem;">لماذا تختارنا لبيع أثاثك المستعمل في جدة؟</h2>
            </div>
            <div class="grid grid-cols-3">
                <div class="card text-center">
                    <div style="font-size:3rem;margin-bottom:1rem;">💰</div>
                    <h3 class="font-bold">أفضل الأسعار</h4>
                        <p>نقوم بتقييم أثاثك بما يرضي الله ويضمن لك الحصول على أعلى قيمة ممكنة بالسوق.</p>
                </div>
                <div class="card text-center">
                    <div style="font-size:3rem;margin-bottom:1rem;">⏱️</div>
                    <h3 class="font-bold">سرعة التنفيذ</h4>
                        <p>نصلك في أسرع وقت داخل جميع أحياء جدة، ونفك وننقل الأثاث دون أي تكلفة إضافية عليك.</p>
                </div>
                <div class="card text-center">
                    <div style="font-size:3rem;margin-bottom:1rem;">🤝</div>
                    <h3 class="font-bold">مصداقية وأمان</h4>
                        <p>مؤسسة رسمية تضمن لك التعامل الراقي والموثوقية التامة في تثمين الأجهزة والمفروشات.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 text-center" style="background:#1e3a8a;color:#fff;">
        <div class="container">
            <h2 class="font-black" style="font-size:2rem;margin-bottom:1.5rem;">جاهز لبيع أثاثك اليوم؟</h2>
            <p style="font-size:1.1rem;margin-bottom:2rem;opacity:0.9;">أرسل صور العفش المستعمل عبر واتساب لتسعير فوري.</p>
            <a href="https://wa.me/966500000000" class="btn bg-white text-blue-600 track-cta"
                data-cta-type="cta_whatsapp_bottom">أرسل الصور الآن</a>
        </div>
    </section>
@endsection
