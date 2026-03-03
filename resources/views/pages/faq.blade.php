@extends('layouts.main')

@section('title', $page->meta_title ?? 'الأسئلة الشائعة حول شراء الأثاث المستعمل بجدة')
@section('meta_description', $page->meta_description ?? 'كل ما تود معرفته عن عملية بيع الأثاث المستعمل بجدة، وكيفية
    التسعير والنقل المباشر من مؤسستنا.')

    @push('schema')
        <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    {
      "@@type": "Question",
      "name": "كيف يتم تحديد سعر الأثاث المستعمل؟",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "يتم تحديد السعر بناءً على عدة عوامل منها حالة الأثاث، جودته، الماركة المصنعة، ومدى استهلاكه الفعلي. نقيم ذلك عبر الصور أو الزيارة الميدانية لضمان إعطاء أفضل سعر."
      }
    },
    {
      "@@type": "Question",
      "name": "هل تشترون جميع أنواع الأثاث؟",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "نعم، نشتري غرف النوم والمجالس والمطابخ والأجهزة الكهربائية كالمكيفات والثلاجات، إضافة إلى الأثاث المكتبي ومعدات المطاعم في حال توفرها."
      }
    },
    {
      "@@type": "Question",
      "name": "هل خدمة الفك والنقل مجانية؟",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "بكل تأكيد، بمجرد الاتفاق على السعر، تتكفل مؤسستنا بجميع أعمال ਫك ونقل الأثاث لضمان راحتك من دون أي تكاليف مخفية."
      }
    }
  ]
}
</script>
    @endpush

@section('content')
    <div class="container py-16" style="max-width: 800px;">
        <h1 class="font-black text-center" style="font-size:3rem;color:#1e3a8a;margin-bottom:3rem;">الأسئلة الشائعة</h1>

        <div style="background:#fff;border-radius:12px;padding:2rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);">
            <details style="margin-bottom:1rem;border-bottom:1px solid #e5e7eb;padding-bottom:1rem;">
                <summary class="font-bold" style="cursor:pointer;font-size:1.25rem;color:#1f2937;">كيف يتم تحديد سعر الأثاث
                    المستعمل؟</summary>
                <p style="margin-top:1rem;color:#4b5563;line-height:1.8;">يتم تحديد السعر بناءً على عدة عوامل منها حالة
                    الأثاث، جودته، الماركة المصنعة، ومدى استهلاكه الفعلي. نقيم ذلك عبر الصور التي ترسلها للواتساب، أو من
                    خلال زيارة ميدانية لضمان إعطائك أفضل سعر عادل ومرضي للطرفين في جدة.</p>
            </details>

            <details style="margin-bottom:1rem;border-bottom:1px solid #e5e7eb;padding-bottom:1rem;">
                <summary class="font-bold" style="cursor:pointer;font-size:1.25rem;color:#1f2937;">هل تشترون جميع أنواع
                    الأثاث والمكيفات العطلانة؟</summary>
                <p style="margin-top:1rem;color:#4b5563;line-height:1.8;">نعم، نشتري غرف النوم، المجالس العربية، الموكيت،
                    المطابخ الألومينيوم والخشب. كما نشتري الأجهزة الكهربائية المستعملة والخرِبة كمكيفات الشباك والاسبليت
                    والثلاجات والغسالات.</p>
            </details>

            <details style="padding-bottom:1rem;">
                <summary class="font-bold" style="cursor:pointer;font-size:1.25rem;color:#1f2937;">هل خدمة الفك والنقل علينا
                    أم عليكم؟</summary>
                <p style="margin-top:1rem;color:#4b5563;line-height:1.8;">بكل تأكيد مجانية وحصرياً على فريقنا! فبمجرد
                    الاتفاق واستلامك للمبلغ نقداً، يتكفل الفنيون والعمال بمهام فك الخزائن والاسرة والمكيفات وتنزيلها
                    للصناديق بسيارات النقل بلا أي رسوم مخفية، نضمن لك بيئة نظيفة وراحة تامة.</p>
            </details>
        </div>

        <div style="margin-top:4rem;text-align:center;">
            <p style="font-size:1.1rem;color:#4b5563;margin-bottom:1.5rem;">لديك سؤال آخر؟ نرحب باستفساراتك على الواتساب على
                مدار الساعة.</p>
            <a href="https://wa.me/966500000000" class="btn btn-primary track-cta" data-cta-type="cta_whatsapp_faq">طرح سؤال
                الآن</a>
        </div>
    </div>
@endsection
