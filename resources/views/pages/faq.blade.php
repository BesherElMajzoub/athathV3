@extends('layouts.main')

@section('title', $page->meta_title ?? 'الأسئلة الشائعة حول شراء الأثاث المستعمل بجدة')
@section('meta_description', $page->meta_description ?? 'أكثر من 30 سؤال وجواب حول شراء وبيع الأثاث المستعمل والمكيفات
    والمطابخ والأجهزة في جدة. تعرف على التسعير والفك والنقل.')

    @push('schema')
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    {"@@type": "Question", "name": "كيف يتم تحديد سعر الأثاث المستعمل؟", "acceptedAnswer": {"@@type": "Answer", "text": "يتم تحديد السعر بناءً على حالة الأثاث وجودته والماركة المصنعة ومدى استهلاكه. نقيم ذلك عبر الصور أو الزيارة الميدانية لضمان أفضل سعر."}},
    {"@@type": "Question", "name": "هل تشترون جميع أنواع الأثاث؟", "acceptedAnswer": {"@@type": "Answer", "text": "نعم نشتري غرف النوم والمجالس والمطابخ والمكيفات والثلاجات والغسالات وجميع الأثاث المنزلي والمكتبي ومعدات المطاعم والسكراب."}},
    {"@@type": "Question", "name": "هل خدمة الفك والنقل مجانية؟", "acceptedAnswer": {"@@type": "Answer", "text": "بكل تأكيد مجانية! بمجرد الاتفاق على السعر يتكفل فريقنا بجميع أعمال الفك والنقل بدون أي تكاليف إضافية."}},
    {"@@type": "Question", "name": "ما طريقة الدفع؟", "acceptedAnswer": {"@@type": "Answer", "text": "ندفع نقداً فوراً عند الاستلام، أو عبر تحويل بنكي فوري حسب رغبة العميل."}},
    {"@@type": "Question", "name": "كم يستغرق وقت التسعير؟", "acceptedAnswer": {"@@type": "Answer", "text": "بمجرد إرسال صور الأثاث عبر الواتساب نرد عليك بعرض سعر خلال دقائق. ويمكن إتمام البيع والنقل في نفس اليوم."}},
    {"@@type": "Question", "name": "هل تشترون مكيفات عطلانة وخرِبة؟", "acceptedAnswer": {"@@type": "Answer", "text": "نعم نشتري المكيفات العطلانة كسكراب بأسعار مناسبة، والمكيفات العاملة بأسعار أعلى حسب حالتها."}},
    {"@@type": "Question", "name": "هل تشترون من جميع أحياء جدة؟", "acceptedAnswer": {"@@type": "Answer", "text": "نعم نغطي جميع أحياء جدة بدون استثناء: شمال جدة، جنوب جدة، وسط جدة، شرق جدة والمناطق المحيطة."}},
    {"@@type": "Question", "name": "هل تشترون مطابخ ألمنيوم مستعملة؟", "acceptedAnswer": {"@@type": "Answer", "text": "نعم نشتري مطابخ الألمنيوم والخشب والحديد بجميع أنواعها وأحجامها مع خدمة فك احترافية مجانية."}},
    {"@@type": "Question", "name": "هل تشترون معدات مطاعم؟", "acceptedAnswer": {"@@type": "Answer", "text": "نعم نشتري جميع معدات المطاعم والكافيهات من أفران صناعية وثلاجات عرض وطاولات ستيل وماكينات قهوة."}},
    {"@@type": "Question", "name": "كم سعر كيلو الحديد السكراب؟", "acceptedAnswer": {"@@type": "Answer", "text": "أسعار السكراب تتغير حسب السوق يومياً. تواصل معنا واتساب لمعرفة أسعار اليوم الحالية."}}
  ]
}
</script>
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type": "ListItem", "position": 1, "name": "الرئيسية", "item": "{{ url('/') }}"},
    {"@@type": "ListItem", "position": 2, "name": "الأسئلة الشائعة"}
  ]
}
</script>
    @endpush

@section('content')
    <section class="section">
        <div class="container" style="max-width:860px;">
            {{-- Breadcrumb --}}
            <nav class="breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}">الرئيسية</a> ›
                <span>الأسئلة الشائعة</span>
            </nav>

            <div class="text-center" style="margin-bottom:3rem;">
                <span class="section-badge">❓ أسئلة وأجوبة</span>
                <h1 class="section-title">الأسئلة الشائعة حول شراء الأثاث المستعمل بجدة</h1>
                <p class="section-desc">إجابات شاملة لأكثر من 30 سؤال يطرحها عملاؤنا حول بيع الأثاث والمكيفات والمطابخ
                    والأجهزة والسكراب في جدة.</p>
            </div>

            {{-- أسئلة عامة --}}
            <h2 style="font-weight:700;font-size:1.2rem;margin-bottom:1rem;color:var(--primary);">أسئلة عامة عن الخدمة</h2>
            <div class="card faq-card" style="margin-bottom:2.5rem;">
                <details>
                    <summary>كيف يتم تحديد سعر الأثاث المستعمل؟</summary>
                    <div class="faq-answer">يتم تحديد السعر بناءً على عدة عوامل منها حالة الأثاث، جودته، الماركة المصنعة،
                        ومدى استهلاكه الفعلي. نقيم ذلك عبر الصور التي ترسلها على الواتساب أو من خلال زيارة ميدانية مجانية
                        لضمان إعطائك أفضل سعر عادل ومرضي للطرفين.</div>
                </details>
                <details>
                    <summary>هل تشترون جميع أنواع الأثاث والأجهزة؟</summary>
                    <div class="faq-answer">نعم، نشتري غرف النوم والمجالس العربية والمطابخ والمكيفات والثلاجات والغسالات
                        وأجهزة المطبخ والأثاث المكتبي ومعدات المطاعم والسكراب. باختصار كل ما يمكن إعادة استخدامه أو تدويره
                        نشتريه.</div>
                </details>
                <details>
                    <summary>هل خدمة الفك والنقل مجانية فعلاً؟</summary>
                    <div class="faq-answer">بكل تأكيد مجانية 100%! بمجرد الاتفاق على السعر واستلامك المبلغ نقداً، يتكفل
                        فريقنا المتخصص بجميع أعمال الفك والتغليف والنقل بدون أي رسوم مخفية أو تكاليف إضافية.</div>
                </details>
                <details>
                    <summary>ما طريقة الدفع المتاحة؟</summary>
                    <div class="faq-answer">ندفع نقداً فوراً عند استلام الأثاث، أو عبر تحويل بنكي فوري حسب رغبة العميل.
                        نتعامل بمرونة تامة لتلبية احتياجاتك.</div>
                </details>
                <details>
                    <summary>كم يستغرق وقت الرد على طلبي؟</summary>
                    <div class="faq-answer">نرد على رسائل الواتساب خلال دقائق معدودة. بعد إرسال صور الأثاث نقدم لك عرض سعر
                        فوري، ويمكن إتمام عملية البيع والنقل في نفس اليوم حسب الموقع والكمية.</div>
                </details>
                <details>
                    <summary>هل تشترون من جميع أحياء جدة؟</summary>
                    <div class="faq-answer">نعم، نغطي جميع أحياء ومناطق مدينة جدة بدون استثناء: الحمدانية، الصفا، الروضة،
                        النسيم، الصفا، حي الشاطئ، الربوة، المروة، الفيصلية، وجميع الأحياء الأخرى شمالاً وجنوباً وشرقاً
                        وغرباً.</div>
                </details>
                <details>
                    <summary>هل تشترون الأثاث القديم جداً؟</summary>
                    <div class="faq-answer">نعم، نشتري الأثاث بحالات مختلفة سواء كان بحالة ممتازة أو قديم نسبياً. المهم أن
                        يكون قابلاً للاستخدام. كل قطعة يتم تقييمها على حدة بعدالة.</div>
                </details>
                <details>
                    <summary>هل تشترون قطعة واحدة أم لازم أبيع كل الأثاث؟</summary>
                    <div class="faq-answer">نشتري قطع مفردة وأطقم كاملة حسب رغبتك. سواء كنت تبيع كنبة واحدة أو عفش منزل
                        كامل، نقدم لك عرض سعر عادل لكل قطعة.</div>
                </details>
            </div>

            {{-- أسئلة المكيفات --}}
            <h2 style="font-weight:700;font-size:1.2rem;margin-bottom:1rem;color:var(--primary);">أسئلة عن شراء المكيفات
            </h2>
            <div class="card faq-card" style="margin-bottom:2.5rem;">
                <details>
                    <summary>هل تشترون مكيفات عطلانة وخرِبة؟</summary>
                    <div class="faq-answer">نعم، نشتري المكيفات العطلانة والخرِبة كسكراب بأسعار مناسبة. المكيفات العاملة
                        بحالة جيدة تحصل على أسعار أعلى طبعاً. أرسل صور المكيف لتقييمه.</div>
                </details>
                <details>
                    <summary>هل تفكون مكيفات السبليت بشكل آمن؟</summary>
                    <div class="faq-answer">نعم، لدينا فنيون متخصصون في فك مكيفات السبليت بشكل احترافي مع سحب الفريون وتغطية
                        فتحات الحائط. الخدمة مجانية بالكامل.</div>
                </details>
                <details>
                    <summary>كم سعر المكيف الشباك المستعمل اليوم؟</summary>
                    <div class="faq-answer">يعتمد على الحجم (18 أو 24 وحدة) والحالة والماركة. أسعار المكيفات تتغير موسمياً.
                        تواصل معنا واتساب لمعرفة السعر الحالي.</div>
                </details>
                <details>
                    <summary>ما أفضل وقت لبيع المكيف المستعمل؟</summary>
                    <div class="faq-answer">أفضل وقت هو قبل بداية موسم الصيف (مارس - مايو) حيث يزداد الطلب على المكيفات
                        وترتفع الأسعار. لكن نشتري طوال السنة.</div>
                </details>
            </div>

            {{-- أسئلة المطابخ --}}
            <h2 style="font-weight:700;font-size:1.2rem;margin-bottom:1rem;color:var(--primary);">أسئلة عن شراء المطابخ</h2>
            <div class="card faq-card" style="margin-bottom:2.5rem;">
                <details>
                    <summary>هل تشترون مطابخ ألمنيوم مستعملة؟</summary>
                    <div class="faq-answer">نعم، نشتري مطابخ الألمنيوم بجميع ألوانها وأحجامها. لدينا فريق متخصص في فك
                        المطابخ بشكل احترافي يحافظ على سلامتها.</div>
                </details>
                <details>
                    <summary>هل تشترون المطبخ مع الأجهزة (فرن وشفاط)؟</summary>
                    <div class="faq-answer">نعم يمكننا شراء المطبخ كاملاً مع أجهزته مثل الفرن والشفاط وغسالة الصحون. نقيم كل
                        قطعة على حدة.</div>
                </details>
                <details>
                    <summary>هل يمكن بيع جزء من المطبخ فقط؟</summary>
                    <div class="faq-answer">نعم يمكنك بيع أجزاء معينة مثل الخزائن العلوية أو السفلية بشكل منفصل حسب رغبتك.
                    </div>
                </details>
            </div>

            {{-- أسئلة الأجهزة --}}
            <h2 style="font-weight:700;font-size:1.2rem;margin-bottom:1rem;color:var(--primary);">أسئلة عن شراء الأجهزة
                الكهربائية</h2>
            <div class="card faq-card" style="margin-bottom:2.5rem;">
                <details>
                    <summary>هل تشترون أجهزة خرِبة وعطلانة؟</summary>
                    <div class="faq-answer">نشتري الأجهزة العاملة والعطلانة. الأجهزة العاملة بحالة جيدة تحصل على سعر أعلى.
                        الأجهزة التالفة نشتريها كسكراب.</div>
                </details>
                <details>
                    <summary>هل تشترون غسالات ونشافات مستعملة؟</summary>
                    <div class="faq-answer">نعم نشتري جميع أنواع الغسالات (أوتوماتيك، نصف أوتوماتيك) والنشافات بحالات مختلفة
                        مع نقل مجاني.</div>
                </details>
                <details>
                    <summary>هل تشترون شاشات وتلفزيونات قديمة؟</summary>
                    <div class="faq-answer">نشتري الشاشات الحديثة (LED, LCD, Smart TV) بأحجام مختلفة. الشاشات القديمة جداً
                        (CRT) نشتريها كسكراب فقط.</div>
                </details>
            </div>

            {{-- أسئلة غرف النوم والكنب --}}
            <h2 style="font-weight:700;font-size:1.2rem;margin-bottom:1rem;color:var(--primary);">أسئلة عن غرف النوم والكنب
                والعفش</h2>
            <div class="card faq-card" style="margin-bottom:2.5rem;">
                <details>
                    <summary>هل تشترون غرف نوم أطفال مستعملة؟</summary>
                    <div class="faq-answer">نعم نشتري غرف نوم الأطفال والمراهقين بجميع تصاميمها وأنواعها سواء كانت كاملة أو
                        قطع منفصلة بأسعار مناسبة.</div>
                </details>
                <details>
                    <summary>هل تشترون المراتب المستعملة؟</summary>
                    <div class="faq-answer">لا نشتري المراتب المستعملة لأسباب صحية. لكن نشتري جميع قطع الأثاث الأخرى مثل
                        الأسرّة والدواليب والتسريحات.</div>
                </details>
                <details>
                    <summary>هل تشترون المجالس العربية الأرضية؟</summary>
                    <div class="faq-answer">نعم نشتري المجالس العربية بجميع أنواعها وأحجامها بأسعار ممتازة. المجالس النظيفة
                        بحالة جيدة تحصل على أفضل الأسعار.</div>
                </details>
                <details>
                    <summary>هل تشترون كنب جلد مستعمل؟</summary>
                    <div class="faq-answer">نعم نشتري الكنب الجلد الطبيعي والصناعي. الكنب الجلد بحالة ممتازة يحصل على أسعار
                        تنافسية جداً.</div>
                </details>
                <details>
                    <summary>هل تشترون عفش شقق مفروشة بالكامل؟</summary>
                    <div class="faq-answer">نعم هذا من تخصصاتنا الرئيسية. نقيم ونشتري عفش الشقق والفلل المفروشة كاملاً بسعر
                        جملة مناسب يوفر عليك الوقت والجهد.</div>
                </details>
            </div>

            {{-- أسئلة معدات المطاعم والسكراب --}}
            <h2 style="font-weight:700;font-size:1.2rem;margin-bottom:1rem;color:var(--primary);">أسئلة عن معدات المطاعم
                والسكراب</h2>
            <div class="card faq-card" style="margin-bottom:2.5rem;">
                <details>
                    <summary>هل تشترون معدات مطعم بالكامل عند الإغلاق؟</summary>
                    <div class="faq-answer">بالتأكيد! نشتري معدات المطعم كاملة بسعر جملة مميز. يفضل التواصل معنا قبل الإغلاق
                        لترتيب الأمور وتحديد موعد التقييم.</div>
                </details>
                <details>
                    <summary>هل تشترون ماكينات قهوة احترافية؟</summary>
                    <div class="faq-answer">نعم نشتري ماكينات القهوة الاحترافية والخلاطات الصناعية وجميع أجهزة تحضير
                        المشروبات المستعملة بأسعار جيدة.</div>
                </details>
                <details>
                    <summary>كم سعر كيلو الحديد السكراب اليوم؟</summary>
                    <div class="faq-answer">أسعار السكراب تتغير يومياً حسب أسعار المعادن في السوق العالمي. تواصل معنا واتساب
                        لمعرفة السعر الحالي. نقدم أسعار تنافسية للكميات الكبيرة.</div>
                </details>
                <details>
                    <summary>هل تشترون ألمنيوم شبابيك قديمة كسكراب؟</summary>
                    <div class="faq-answer">نعم نشتري ألمنيوم الشبابيك والأبواب والمطابخ القديمة كسكراب ألمنيوم بالكيلو.
                        نوفر خدمة الفك والنقل المجاني.</div>
                </details>
                <details>
                    <summary>هل تشترون سكراب نحاس وأسلاك كهربائية؟</summary>
                    <div class="faq-answer">نعم نشتري جميع أنواع النحاس بما فيها الأسلاك الكهربائية والمواسير والرادياتير.
                        النحاس من أعلى المعادن سعراً في السكراب.</div>
                </details>
                <details>
                    <summary>هل تتعاملون مع مصانع وورش لشراء السكراب بالجملة؟</summary>
                    <div class="faq-answer">نعم نتعامل مع المصانع والورش والمحلات التجارية. يمكننا ترتيب عقود شراء دورية
                        للكميات المنتظمة مع أسعار مميزة ونقل مجدول.</div>
                </details>
            </div>

            {{-- CTA --}}
            <div class="text-center" style="margin-top:2rem;">
                <p style="font-size:1.1rem;color:var(--muted);margin-bottom:1.5rem;">لديك سؤال آخر؟ تواصل معنا عبر الواتساب
                    في أي وقت.</p>
                <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
                    <a href="https://wa.me/966500000000" class="btn btn-whatsapp track-cta"
                        data-cta-type="cta_whatsapp_faq">💬 اسأل عبر الواتساب</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">تواصل معنا ←</a>
                </div>
            </div>
        </div>
    </section>
@endsection
