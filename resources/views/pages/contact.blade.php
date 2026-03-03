@extends('layouts.main')

@section('title', $page->meta_title ?? 'تواصل معنا - شراء أثاث مستعمل بجدة')
@section('meta_description', $page->meta_description ?? 'اتصل بنا لتسعير أثاثك المنزلي، المكتبي والأجهزة في جدة بأفضل
    سعر. سرعة بالرد ومعاينة للموقع مجاناً.')

@section('content')
    <div class="container py-16 text-center">
        <h1 class="font-black" style="font-size:3rem;color:#1e3a8a;margin-bottom:1rem;">تواصل معنا</h1>
        <p style="font-size:1.2rem;color:#4b5563;max-width:600px;margin:0 auto 3rem;">
            نسعد بخدمتكم وتلقي طلبات بيع الأثاث المستعمل عبر طرق التواصل أدناه، تقييم مجاني وتسعير فني بالكامل.
        </p>

        <div class="grid grid-cols-3">
            <div class="card" style="padding:2.5rem 1.5rem;">
                <div style="font-size:3rem;margin-bottom:1.5rem;">📱</div>
                <h3 class="font-bold text-xl mb-2">واتساب السريع</h3>
                <p class="mb-4" style="color:#6b7280;margin-bottom:1.5rem;">أرسل صور الأثاث لتحصل على تسعير خلال دقائق.</p>
                <a href="https://wa.me/966500000000" class="btn btn-whatsapp track-cta"
                    data-cta-type="cta_whatsapp_contact">+966 50 000 0000</a>
            </div>
            <div class="card" style="padding:2.5rem 1.5rem;">
                <div style="font-size:3rem;margin-bottom:1.5rem;">📞</div>
                <h3 class="font-bold text-xl mb-2">اتصال هاتفي</h3>
                <p class="mb-4" style="color:#6b7280;margin-bottom:1.5rem;">فريقنا جاهز للرد على استفساراتكم وترتيب موعد
                    الزيارة.</p>
                <a href="tel:+966500000000" class="btn btn-call track-cta" data-cta-type="cta_call_contact">050 000 0000</a>
            </div>
            <div class="card" style="padding:2.5rem 1.5rem;">
                <div style="font-size:3rem;margin-bottom:1.5rem;">📍</div>
                <h3 class="font-bold text-xl mb-2">التغطية</h3>
                <p style="color:#6b7280;">جميع أنحاء ومناطق مدينة جدة (شمال، جنوب، شرق، وأواسط جدة، ومكة المكرمة كخدمة
                    خاصة).</p>
            </div>
        </div>
    </div>
@endsection
