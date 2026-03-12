@extends('layouts.main')

@section('title', $page->meta_title ?? 'تواصل معنا - شراء أثاث مستعمل بجدة')
@section('meta_description', $page->meta_description ?? 'تواصل معنا لتسعير أثاثك المستعمل في جدة. واتساب، اتصال هاتفي،
    أو أرسل طلبك مباشرة. رد سريع وتقييم مجاني.')

    @push('schema')
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type": "ListItem", "position": 1, "name": "الرئيسية", "item": "{{ url('/') }}"},
    {"@@type": "ListItem", "position": 2, "name": "تواصل معنا"}
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
                <span>تواصل معنا</span>
            </nav>

            <div class="text-center" style="margin-bottom:3rem;">
                <span class="section-badge">📨 تواصل معنا</span>
                <h1 class="section-title">نسعد بخدمتك</h1>
                <p class="section-desc">اختر الطريقة المناسبة لك للتواصل معنا. نرد على جميع الاستفسارات بسرعة ونقدم تقييم
                    مجاني لأثاثك المستعمل في جدة.</p>
            </div>

            <div class="contact-grid">
                {{-- Left: Contact Methods --}}
                <div class="card contact-info">
                    <h2 style="font-size:1.6rem;">طرق التواصل المباشر</h2>
                    <p>فريقنا جاهز لاستقبال طلباتكم وتقديم عروض أسعار فورية. تواصلوا معنا بأي طريقة تناسبكم:</p>
                    <div class="contact-btns">
                        <a href="https://wa.me/966500000000" class="contact-btn contact-btn-wa track-cta"
                            data-cta-type="cta_whatsapp_contact">
                            <span class="contact-btn-icon" style="background:rgba(37,211,102,.15);">💬</span>
                            <div>
                                <strong>واتساب السريع</strong><br>
                                <small class="text-muted">أرسل صور الأثاث لتسعير خلال دقائق</small>
                            </div>
                        </a>
                        <a href="tel:+966500000000" class="contact-btn contact-btn-call track-cta"
                            data-cta-type="cta_call_contact">
                            <span class="contact-btn-icon" style="background:rgba(47,107,63,.1);">📞</span>
                            <div>
                                <strong>اتصال هاتفي</strong><br>
                                <small class="text-muted">050 000 0000 - متاح 7 أيام بالأسبوع</small>
                            </div>
                        </a>
                        <a href="{{ route('faq') }}" class="contact-btn contact-btn-faq">
                            <span class="contact-btn-icon" style="background:rgba(191,231,207,.4);">❓</span>
                            <div>
                                <strong>الأسئلة الشائعة</strong><br>
                                <small class="text-muted">إجابات لأكثر من 30 سؤال</small>
                            </div>
                        </a>
                    </div>

                    {{-- Coverage --}}
                    <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--border);">
                        <h3 style="font-weight:700;font-size:1rem;margin-bottom:.75rem;">📍 منطقة التغطية</h3>
                        <p class="text-muted" style="font-size:.9rem;line-height:1.8;">جميع أحياء ومناطق مدينة جدة (شمال،
                            جنوب، شرق، وسط جدة) والمناطق المحيطة. نصلك أينما كنت خلال ساعات.</p>
                    </div>
                </div>

                {{-- Right: Form --}}
                <div class="card">
                    <h3 style="font-weight:700;margin-bottom:.5rem;">أرسل طلبك مباشرة</h3>
                    <p class="text-muted" style="font-size:.9rem;margin-bottom:1.5rem;">املأ النموذج وسنتواصل معك في أقرب
                        وقت ممكن.</p>
                    <form class="contact-form" id="contact-page-form">
                        @csrf
                        <div class="form-group">
                            <label for="cp_name">الاسم <span style="color:red;">*</span></label>
                            <input type="text" id="cp_name" name="name" placeholder="اسمك الكريم" required>
                        </div>
                        <div class="form-group">
                            <label for="cp_phone">رقم الجوال <span style="color:red;">*</span></label>
                            <input type="tel" id="cp_phone" name="phone" placeholder="05XXXXXXXX" required
                                pattern="^05[0-9]{8}$">
                        </div>
                        <div class="form-group">
                            <label for="cp_service">نوع الخدمة</label>
                            <select id="cp_service" name="service"
                                style="width:100%;padding:.75rem 1rem;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:var(--font);font-size:.9rem;background:var(--bg);">
                                <option value="">اختر نوع الخدمة</option>
                                <option value="أثاث مستعمل">شراء أثاث مستعمل</option>
                                <option value="مطابخ">شراء مطابخ</option>
                                <option value="مكيفات">شراء مكيفات</option>
                                <option value="أجهزة كهربائية">شراء أجهزة كهربائية</option>
                                <option value="غرف نوم">شراء غرف نوم</option>
                                <option value="كنب ومجالس">شراء كنب ومجالس</option>
                                <option value="عفش كامل">شراء عفش كامل</option>
                                <option value="معدات مطاعم">شراء معدات مطاعم</option>
                                <option value="سكراب">شراء سكراب</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cp_message">وصف الأثاث</label>
                            <textarea id="cp_message" name="message" rows="4" placeholder="اكتب وصف مختصر للأثاث أو الأجهزة التي تريد بيعها…"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary track-cta" data-cta-type="cta_form_submit_contact"
                            style="width:100%;padding:1rem;">📨 إرسال الطلب</button>
                    </form>
                    <div id="cp-form-success" style="display:none;text-align:center;padding:3rem 0;">
                        <div style="font-size:3.5rem;margin-bottom:1rem;">✅</div>
                        <h4 style="font-weight:700;font-size:1.2rem;">تم إرسال طلبك بنجاح!</h4>
                        <p class="text-muted" style="margin-top:.5rem;">سنتواصل معك في أقرب وقت ممكن إن شاء الله.</p>
                    </div>
                </div>
            </div>

            {{-- Internal Links --}}
            <div style="margin-top:3rem;" class="text-center">
                <h3 style="font-weight:700;margin-bottom:1rem;font-size:1.1rem;">صفحات ذات صلة</h3>
                <div class="links-bar">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('services.index') }}">جميع الخدمات</a>
                    <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                    <a href="{{ route('districts.index') }}">أحياء جدة</a>
                    <a href="{{ url('/blog') }}">المدونة</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.getElementById('contact-page-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const data = new FormData(form);
            fetch('/api/tracking/events', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    event_type: 'form_submit',
                    page_url: window.location.href,
                    meta_data: {
                        name: data.get('name'),
                        phone: data.get('phone'),
                        service: data.get('service'),
                        message: data.get('message')
                    }
                })
            }).catch(() => {});
            form.style.display = 'none';
            document.getElementById('cp-form-success').style.display = 'block';
        });
    </script>
@endpush
