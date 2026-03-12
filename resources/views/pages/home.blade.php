@extends('layouts.main')

@section('title', 'شراء أثاث مستعمل بجدة | أعلى الأسعار — نشتري ونقيّم ونفك مجاناً')
@section('meta_description',
    'أفضل مؤسسة لشراء الأثاث المستعمل في جدة. نشتري مطابخ، مكيفات، أجهزة، غرف نوم، كنب، عفش.
    تقييم فوري وعادل مع فك ونقل مجاني ودفع نقدي.')
@section('canonical', url('/'))
@section('og_image', asset(config('business.og_image', '/assets/og-default.jpg')))

@push('schema')
    <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "أثاث جدة الموثوق",
  "url": "{{ url('/') }}",
  "potentialAction": {"@@type": "SearchAction","target": "{{ url('/search?q={q}') }}","query-input": "required name=q"}
}
</script>
    <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "مؤسسة شراء الأثاث المستعمل بجدة",
  "image": "{{ asset(config('business.og_image', '/assets/og-default.jpg')) }}",
  "telephone": "{{ config('business.phone') }}",
  "url": "{{ url('/') }}",
  "address": {"@@type": "PostalAddress","addressLocality": "جدة","addressRegion": "مكة المكرمة","addressCountry": "SA"},
  "areaServed": "Jeddah",
  "description": "متخصصون في تسعير وشراء جميع أنواع الأثاث المستعمل والأجهزة الكهربائية بمدينة جدة بأفضل الأسعار."
}
</script>
@endpush

@section('content')

    {{-- ======== HERO ======== --}}
    <section class="hero" aria-label="القسم الرئيسي">
        <div class="container">
            <div class="hero-inner">
                <div class="animate-in">
                    <span class="section-badge">🏆 الأول في جدة</span>
                    <h1>شراء <span>أثاث مستعمل</span><br>بأعلى سعر في جدة</h1>
                    <p>مؤسسة متخصصة في شراء جميع أنواع الأثاث والأجهزة المستعملة. تقييم فوري وعادل، فك ونقل مجاني، ودفع نقدي
                        فوري. نغطي جميع أحياء جدة.</p>
                    <div class="hero-btns">
                        <a href="https://wa.me/{{ config('business.whatsapp') }}" class="btn btn-whatsapp"
                            rel="nofollow noopener noreferrer" data-track="cta_whatsapp_click" data-placement="hero"
                            data-target="https://wa.me/{{ config('business.whatsapp') }}">
                            💬 تواصل واتساب
                        </a>
                        <a href="tel:{{ config('business.phone') }}" class="btn btn-call" data-track="cta_call_click"
                            data-placement="hero" data-target="tel:{{ config('business.phone') }}">
                            📞 اتصل الآن
                        </a>
                        <a href="{{ route('services.index') }}" class="btn btn-outline">تصفح خدماتنا</a>
                    </div>
                </div>
                <div class="hero-ring animate-in" style="animation-delay:.2s;">
                    <div class="hero-ring-circle">
                        <div class="hero-ring-inner">🪑</div>
                    </div>
                    <div class="hero-badges" style="top:5%;right:-20px;">
                        <div class="hero-badge">
                            <span class="hero-badge-icon badge-green">✓</span> دفع فوري نقداً
                        </div>
                        <div class="hero-badge" style="margin-right:24px;">
                            <span class="hero-badge-icon badge-mint">🚚</span> فك ونقل مجاني
                        </div>
                        <div class="hero-badge">
                            <span class="hero-badge-icon badge-green">⭐</span> تقييم عادل واحترافي
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======== WHY US ======== --}}
    <section class="section">
        <div class="container text-center">
            <span class="section-badge">لماذا نحن؟</span>
            <h2 class="section-title">لماذا تختارنا لبيع أثاثك المستعمل في جدة؟</h2>
            <p class="section-desc">نقدم لك تجربة بيع سلسة ومريحة من الاتصال الأول وحتى استلام المبلغ نقداً، مع ضمان أعلى
                الأسعار في السوق.</p>
            <div class="grid grid-3">
                <div class="card text-center">
                    <div style="font-size:2.5rem;margin-bottom:1rem;">💰</div>
                    <h3 style="font-weight:700;margin-bottom:.5rem;">أفضل الأسعار</h3>
                    <p class="text-muted" style="font-size:.9rem;">نقيم أثاثك بما يستحقه فعلاً ونضمن لك الحصول على أعلى قيمة
                        ممكنة مقارنة بالسوق.</p>
                </div>
                <div class="card text-center">
                    <div style="font-size:2.5rem;margin-bottom:1rem;">⚡</div>
                    <h3 style="font-weight:700;margin-bottom:.5rem;">سرعة التنفيذ</h3>
                    <p class="text-muted" style="font-size:.9rem;">نصلك في أسرع وقت داخل جميع أحياء جدة، ونفك وننقل الأثاث
                        دون أي تكلفة عليك.</p>
                </div>
                <div class="card text-center">
                    <div style="font-size:2.5rem;margin-bottom:1rem;">🤝</div>
                    <h3 style="font-weight:700;margin-bottom:.5rem;">مصداقية وأمان</h3>
                    <p class="text-muted" style="font-size:.9rem;">مؤسسة رسمية تضمن لك التعامل الراقي والموثوقية التامة في
                        تثمين المفروشات والأجهزة.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ======== SERVICES GRID ======== --}}
    <section class="section" style="background:var(--surface);">
        <div class="container text-center">
            <span class="section-badge">خدماتنا</span>
            <h2 class="section-title">أقسام الخدمات التي نقدمها</h2>
            <p class="section-desc">نشتري كل شيء من الأثاث المنزلي والمكتبي إلى المكيفات والأجهزة والمطابخ ومعدات المطاعم
                والسكراب.</p>

            @php
                $serviceCards = [
                    [
                        'icon' => '🛋️',
                        'title' => 'شراء أثاث مستعمل',
                        'desc' => 'غرف نوم، مجالس، طاولات، وجميع أنواع الأثاث المنزلي.',
                        'slug' => 'شراء-اثاث-مستعمل-بجدة',
                    ],
                    [
                        'icon' => '🍳',
                        'title' => 'شراء مطابخ',
                        'desc' => 'مطابخ ألمنيوم وخشب وحديد بجميع الأحجام مع فك احترافي.',
                        'slug' => 'شراء-مطابخ-مستعملة-بجدة',
                    ],
                    [
                        'icon' => '❄️',
                        'title' => 'شراء مكيفات',
                        'desc' => 'شباك وسبليت ومركزي، حتى العطلانة نشتريها.',
                        'slug' => 'شراء-مكيفات-مستعملة-بجدة',
                    ],
                    [
                        'icon' => '📺',
                        'title' => 'شراء أجهزة مستعملة',
                        'desc' => 'ثلاجات، غسالات، أفران، شاشات وجميع الأجهزة.',
                        'slug' => 'شراء-اجهزة-مستعملة-بجدة',
                    ],
                    [
                        'icon' => '🛏️',
                        'title' => 'شراء غرف نوم',
                        'desc' => 'غرف نوم كاملة وقطع منفصلة: أسرّة، دواليب، تسريحات.',
                        'slug' => 'شراء-غرف-نوم-مستعملة-بجدة',
                    ],
                    [
                        'icon' => '🛋️',
                        'title' => 'شراء كنب',
                        'desc' => 'كنب عصري ومجالس عربية وأطقم جلوس بجميع الأنواع.',
                        'slug' => 'شراء-كنب-مستعمل-بجدة',
                    ],
                    [
                        'icon' => '📦',
                        'title' => 'شراء عفش',
                        'desc' => 'عفش منزلي ومكتبي وفندقي، نشتري المنزل كامل.',
                        'slug' => 'شراء-عفش-مستعمل-بجدة',
                    ],
                    [
                        'icon' => '🍽️',
                        'title' => 'شراء معدات مطاعم',
                        'desc' => 'أفران صناعية، ثلاجات عرض، طاولات ستيل وكافيهات.',
                        'slug' => 'شراء-معدات-مطاعم-مستعملة-بجدة',
                    ],
                    [
                        'icon' => '♻️',
                        'title' => 'شراء سكراب',
                        'desc' => 'حديد، ألمنيوم، نحاس وخردة بأسعار تنافسية.',
                        'slug' => 'شراء-سكراب-بجدة',
                    ],
                ];
            @endphp

            <div class="grid grid-3">
                @foreach ($serviceCards as $sc)
                    <a href="{{ url('/services/' . $sc['slug']) }}" class="card service-card card-flat">
                        <div class="card-icon">{{ $sc['icon'] }}</div>
                        <h3>{{ $sc['title'] }}</h3>
                        <p>{{ $sc['desc'] }}</p>
                        <span class="card-link">تفاصيل الخدمة ←</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======== ABOUT PREVIEW ======== --}}
    <section class="section">
        <div class="container">
            <div class="about-preview">
                <div>
                    <span class="section-badge">🏢 من نحن</span>
                    <h2 class="section-title">مؤسسة سعودية موثوقة منذ سنوات</h2>
                    <p class="text-muted" style="margin-bottom:0;line-height:1.8;">نحن فريق سعودي متخصص في شراء جميع أنواع
                        الأثاث المستعمل بمدينة جدة. مبدأنا الأول هو الشفافية والتسعير العادل — نقيّم الأثاث بحضورك ونقدم
                        سعراً واضحاً بدون ضغط.</p>
                    <div class="about-points">
                        <div class="about-point"><span class="about-point-icon">💰</span> أعلى سعر مضمون وعادل</div>
                        <div class="about-point"><span class="about-point-icon">🚚</span> فك ونقل مجاني من موقعك</div>
                        <div class="about-point"><span class="about-point-icon">⚡</span> دفع نقدي فوري في نفس اليوم</div>
                        <div class="about-point"><span class="about-point-icon">📍</span> نغطي جميع أحياء جدة</div>
                    </div>
                    <a href="{{ route('about') }}" class="btn btn-outline">اقرأ المزيد عنا ←</a>
                </div>
                <div class="about-visual">
                    <span class="about-emoji">🪑</span>
                    <div>
                        <div class="about-stat">+500 <small>عملية شراء شهرياً</small></div>
                        <div class="about-stat">100% <small>رضا العملاء</small></div>
                        <div class="about-stat">24h <small>متوسط إتمام الصفقة</small></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======== YOUTUBE VIDEO ======== --}}
    @if (config('business.youtube_video_id'))
        <section class="section" style="background:var(--surface);">
            <div class="container text-center">
                <span class="section-badge">🎬 شاهد كيف نعمل</span>
                <h2 class="section-title">كيف نقيّم الأثاث المستعمل ونشتريه فوراً؟</h2>
                <p class="section-desc">شاهد العملية كاملة من لحظة الاتصال حتى استلامك المبلغ نقداً في نفس اليوم.</p>

                <div style="max-width:800px;margin:0 auto;">
                    {{-- Lazy YouTube: shows thumbnail, loads iframe only on click --}}
                    <div class="yt-trigger" id="yt-player" role="button" tabindex="0" aria-label="تشغيل الفيديو"
                        data-video-id="{{ config('business.youtube_video_id') }}" onclick="loadYT(this)"
                        onkeydown="if(event.key==='Enter')loadYT(this)">
                        <img src="https://img.youtube.com/vi/{{ config('business.youtube_video_id') }}/maxresdefault.jpg"
                            alt="فيديو يوضح كيف نشتري الأثاث المستعمل في جدة" loading="lazy"
                            onerror="this.src='https://img.youtube.com/vi/{{ config('business.youtube_video_id') }}/hqdefault.jpg'">
                        <div class="yt-play-btn" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <polygon points="5 3 19 12 5 21 5 3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ======== INTERNAL LINKS ======== --}}
    <section class="section-sm">
        <div class="container text-center">
            <h3 style="font-weight:700;margin-bottom:1.25rem;font-size:1.05rem;">روابط مهمة</h3>
            <div class="links-bar">
                <a href="{{ route('services.index') }}">جميع الخدمات</a>
                <a href="{{ route('districts.index') }}">أحياء جدة</a>
                <a href="{{ url('/blog') }}">مدونة أثاث جدة</a>
                <a href="{{ route('faq') }}">الأسئلة الشائعة</a>
                <a href="{{ route('contact') }}">تواصل معنا</a>
                <a href="{{ route('about') }}">من نحن</a>
                <a href="{{ url('/services/شراء-اثاث-مستعمل-بجدة') }}">شراء أثاث مستعمل</a>
                <a href="{{ url('/services/شراء-مكيفات-مستعملة-بجدة') }}">شراء مكيفات</a>
                <a href="{{ url('/services/شراء-عفش-مستعمل-بجدة') }}">شراء عفش</a>
            </div>
        </div>
    </section>

    {{-- ======== FAQ (Home) ======== --}}
    <section class="section" style="background:var(--surface);">
        <div class="container" style="max-width:800px;">
            <div class="text-center" style="margin-bottom:2.5rem;">
                <span class="section-badge">أسئلة شائعة</span>
                <h2 class="section-title">الأسئلة الأكثر شيوعاً</h2>
            </div>
            <div class="card faq-card">
                <details>
                    <summary>كيف يتم تحديد سعر الأثاث المستعمل؟</summary>
                    <div class="faq-answer">يتم تحديد السعر بناءً على عدة عوامل منها حالة الأثاث، جودته، الماركة المصنعة،
                        ومدى استهلاكه الفعلي. نقيم ذلك عبر الصور أو الزيارة الميدانية.</div>
                </details>
                <details>
                    <summary>هل تشترون جميع أنواع الأثاث والأجهزة؟</summary>
                    <div class="faq-answer">نعم، نشتري غرف النوم والمجالس والمطابخ والمكيفات والثلاجات والغسالات وجميع
                        الأثاث المنزلي والمكتبي ومعدات المطاعم والسكراب.</div>
                </details>
                <details>
                    <summary>هل خدمة الفك والنقل مجانية؟</summary>
                    <div class="faq-answer">بكل تأكيد! بمجرد الاتفاق على السعر، يتكفل فريقنا بجميع أعمال الفك والنقل بدون
                        أي تكاليف إضافية.</div>
                </details>
                <details>
                    <summary>ما المناطق التي تغطونها في جدة؟</summary>
                    <div class="faq-answer">نغطي جميع أحياء ومناطق مدينة جدة بدون استثناء: شمال جدة، جنوب جدة، وسط جدة، شرق
                        جدة، والمناطق المحيطة.</div>
                </details>
                <details>
                    <summary>كم يستغرق وقت التسعير؟</summary>
                    <div class="faq-answer">بمجرد إرسال صور الأثاث عبر الواتساب نرد عليك بعرض سعر خلال دقائق. ويمكن إتمام
                        البيع والنقل في نفس اليوم.</div>
                </details>
            </div>
            <div class="text-center" style="margin-top:2rem;">
                <a href="{{ route('faq') }}" class="btn btn-outline">عرض جميع الأسئلة (30+) ←</a>
            </div>
        </div>
    </section>

    {{-- ======== CONTACT SECTION ======== --}}
    <section class="section" id="contact">
        <div class="container">
            <div class="text-center" style="margin-bottom:2.5rem;">
                <span class="section-badge">تواصل معنا</span>
                <h2 class="section-title">جاهزين لخدمتك في أي وقت</h2>
                <p class="section-desc">أرسل لنا صور أثاثك عبر الواتساب أو اتصل بنا مباشرةً للحصول على تسعير فوري ومجاني.
                </p>
            </div>
            <div class="contact-grid">
                <div class="card">
                    <h2 style="font-size:1.5rem;font-weight:900;margin-bottom:1rem;">تواصل مباشر</h2>
                    <p class="text-muted" style="margin-bottom:1.5rem;line-height:1.8;">فريقنا جاهز للرد على استفساراتك
                        وتقديم عروض أسعار فورية لأثاثك المستعمل.</p>
                    <div style="display:flex;flex-direction:column;gap:.75rem;">
                        <a href="https://wa.me/{{ config('business.whatsapp') }}" class="contact-btn contact-btn-wa"
                            rel="nofollow noopener noreferrer" data-track="cta_whatsapp_click" data-placement="contact"
                            data-target="https://wa.me/{{ config('business.whatsapp') }}">
                            <span class="contact-btn-icon" style="background:rgba(37,211,102,.15);">💬</span>
                            <div><strong>واتساب</strong><br><small class="text-muted">أرسل صور الأثاث لتسعير فوري</small>
                            </div>
                        </a>
                        <a href="tel:{{ config('business.phone') }}" class="contact-btn contact-btn-call"
                            data-track="cta_call_click" data-placement="contact"
                            data-target="tel:{{ config('business.phone') }}">
                            <span class="contact-btn-icon" style="background:rgba(47,107,63,.1);">📞</span>
                            <div><strong>اتصال هاتفي</strong><br><small
                                    class="text-muted">{{ config('business.phone') }}</small></div>
                        </a>
                        <a href="{{ route('faq') }}" class="contact-btn contact-btn-faq">
                            <span class="contact-btn-icon" style="background:rgba(191,231,207,.4);">❓</span>
                            <div><strong>الأسئلة الشائعة</strong><br><small class="text-muted">إجابات لأكثر من 30
                                    سؤال</small></div>
                        </a>
                    </div>
                </div>
                <div class="card">
                    <h3 style="font-weight:700;margin-bottom:1.25rem;">أرسل طلبك مباشرة</h3>
                    <form class="contact-form" id="home-contact-form" data-track="contact_form_submit"
                        data-placement="home">
                        @csrf
                        <div class="form-group">
                            <label for="hc_name">الاسم</label>
                            <input type="text" id="hc_name" name="name" placeholder="اسمك الكريم" required>
                        </div>
                        <div class="form-group">
                            <label for="hc_phone">رقم الجوال</label>
                            <input type="tel" id="hc_phone" name="phone" placeholder="05XXXXXXXX" required>
                        </div>
                        <div class="form-group">
                            <label for="hc_message">وصف الأثاث</label>
                            <textarea id="hc_message" name="message" rows="3" placeholder="اكتب وصف مختصر للأثاث الذي تريد بيعه…"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%;">📨 إرسال الطلب</button>
                    </form>
                    <div id="hc-success" style="display:none;text-align:center;padding:2rem 0;">
                        <div style="font-size:3rem;margin-bottom:1rem;">✅</div>
                        <h4 style="font-weight:700;">تم إرسال طلبك!</h4>
                        <p class="text-muted">سنتواصل معك قريباً.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======== CTA BANNER ======== --}}
    <section class="section-sm">
        <div class="container">
            <div class="cta-banner">
                <h2>جاهز لبيع أثاثك اليوم؟</h2>
                <p>أرسل صور العفش المستعمل عبر واتساب لتسعير فوري ومجاني.</p>
                <a href="https://wa.me/{{ config('business.whatsapp') }}" class="btn btn-light"
                    rel="nofollow noopener noreferrer" style="font-size:1.1rem;padding:1rem 2.5rem;position:relative;"
                    data-track="cta_whatsapp_click" data-placement="cta_bottom"
                    data-target="https://wa.me/{{ config('business.whatsapp') }}">
                    💬 أرسل الصور الآن
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        // YouTube lazy loader
        function loadYT(el) {
            var id = el.getAttribute('data-video-id');
            var wrapper = document.createElement('div');
            wrapper.className = 'yt-iframe-wrapper';
            wrapper.innerHTML = '<iframe src="https://www.youtube.com/embed/' + id +
                '?autoplay=1&rel=0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            el.parentNode.replaceChild(wrapper, el);
        }

        // Home contact form
        document.getElementById('home-contact-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this);
            var payload = JSON.stringify({
                event_type: 'contact_form_submit',
                page_url: window.location.href,
                meta_data: {
                    placement: 'home',
                    name: data.get('name'),
                    phone: data.get('phone')
                }
            });
            if (navigator.sendBeacon) {
                navigator.sendBeacon('/api/track/click', new Blob([payload], {
                    type: 'application/json'
                }));
            }
            this.style.display = 'none';
            document.getElementById('hc-success').style.display = 'block';
        });
    </script>
@endpush
