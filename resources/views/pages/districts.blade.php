@extends('layouts.main')

@section('title', 'مناطق خدمتنا في جدة | شراء الاثاث المستعمل بكل الأحياء')
@section('meta_description', 'تعرف على الأحياء التي نغطيها لخدمات تقييم وشراء الأثاث المستعمل والأجهزة بمدينة جدة. خدمتك
    حيث كنت وبأسرع وقت.')

@section('content')
    <div class="container py-16">
        <div style="margin-bottom:3rem;border-bottom:1px solid #e5e7eb;padding-bottom:2rem;">
            <h1 class="font-black" style="font-size:2.5rem;color:#1e3a8a;margin-bottom:1rem;">أحياء جدة المشمولة بالخدمة</h1>
            <p style="font-size:1.1rem;color:#4b5563;line-height:1.8;">
                نلتزم بتغطية كافة أحياء جدة لتقديم أسرع استجابة ممكنة عند رغبتك في بيع الأثاث المستعمل بسعر يرضيك. سواء كنت
                في شمال جدة الحديث مثل أبحر، المحمدية، أو النعيم، أو عبر أحياء وسط وشرق وجنوب جدة أمثال الصفا، الجامعة،
                السنابل ومخطط الرياض. سياراتنا وفرق العمل المهنية تتجول يومياً لاستلام وتثمين الاثاث المكتبي والمنزلي،
                المكيفات الخربانة، ومطابخ الألمنيوم وغيرها. سرعة الوصول، التثمين العادل، ونقل الاثاث مباشرة من منزلك بدون
                تحميلك أعباء نقل إضافية هو ديدن عملنا اليومي. نوفر عليك المشقة والبحث الطويل عبر حراج وغيره بتقديم حل جذري
                وسريع لبيع عفش شقتك، فلتك، أو مكتبك فوراً.
            </p>
        </div>

        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
            @forelse($districts as $district)
                <a href="{{ route('districts.show', $district->slug) }}" class="card"
                    style="text-decoration:none;text-align:center;transition:all 0.2s;">
                    <h3 class="font-bold text-blue-600" style="font-size:1.1rem;margin-bottom:0.5rem;">
                        {{ $district->title }}</h3>
                    <span style="font-size:0.85rem;color:#6b7280;">شراء أثاث في الحي</span>
                </a>
            @empty
                <div class="card" style="grid-column:1/-1;text-align:center;">
                    <p>قريباً سيتم إضافة الأحياء.</p>
                    <a href="#" class="font-bold text-blue-600" style="margin-top:1rem;display:inline-block;">مثال: حي
                        الصفا</a>
                    <br>
                    <a href="#" class="font-bold text-blue-600" style="margin-top:1rem;display:inline-block;">مثال:
                        أبحر الشمالية</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
