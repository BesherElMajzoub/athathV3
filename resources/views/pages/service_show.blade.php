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
    "name": "أثاث جدة الموثوق",
    "telephone": "+966500000000"
  },
  "areaServed": "Jeddah",
  "description": "{{ $service->meta_description }}"
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

@section('content')
    <div class="container py-16">
        <nav aria-label="breadcrumb" style="font-size:0.9rem;margin-bottom:1.5rem;color:#6b7280;">
            <a href="/" style="color:#2563eb;text-decoration:none;">الرئيسية</a> ›
            <a href="{{ route('services.index') }}" style="color:#2563eb;text-decoration:none;">الخدمات</a> ›
            <span>{{ $service->title }}</span>
        </nav>
        <article>
            <h1 class="font-black" style="font-size:clamp(2rem, 5vw, 3rem);color:#1e3a8a;margin-bottom:2rem;line-height:1.2;">
                {{ $service->title }}</h1>
            @if ($service->og_image)
                <img src="{{ asset('storage/' . $service->og_image) }}" alt="{{ $service->title }}"
                    style="width:100%;max-height:450px;object-fit:cover;border-radius:16px;margin-bottom:2rem;">
            @endif

            <div style="font-size:1.1rem;color:#374151;line-height:1.8;">
                {!! $service->content !!}
            </div>

            <div style="margin-top:4rem;background:#dbeafe;padding:3rem 2rem;border-radius:12px;text-align:center;">
                <h2 class="font-black" style="font-size:1.8rem;margin-bottom:1rem;">هل تبحث عن السعر الأمثل لعفشك؟</h2>
                <p style="margin-bottom:2rem;">تواصل معنا الآن، وسيقوم فريقنا بالرد الفوري وتقييم أثاثك بكل مصداقية في جدة.
                </p>
                <a href="https://wa.me/966500000000" class="btn btn-primary track-cta" data-cta-type="cta_whatsapp_service"
                    style="font-size:1.2rem;padding:1rem 2rem;">💬 اطلب التسعير عبر الواتساب</a>
            </div>
        </article>
    </div>
@endsection
