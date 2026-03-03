@extends('layouts.main')

@section('title', 'خدمات شراء الأثاث المستعمل في جدة | جميع الأقسام')
@section('meta_description', 'تصفح جميع خدماتنا في شراء وبيع الأثاث المستعمل، غرف النوم، المطابخ، الأجهزة، والمجالس
    بجدة. نضمن لك تقييماً عادلاً لجميع معروضاتك.')

@section('content')
    <div class="container py-16">
        {{-- SEO Natural 100-word intro --}}
        <div style="margin-bottom:3rem;border-bottom:1px solid #e5e7eb;padding-bottom:2rem;">
            <h1 class="font-black" style="font-size:2.5rem;color:#1e3a8a;margin-bottom:1rem;">خدماتنا في شراء الأثاث المستعمل
                بجدة</h1>
            <p style="font-size:1.1rem;color:#4b5563;line-height:1.8;">
                إذا كنت تبحث عن شركة موثوقة متخصصة في <strong>شراء عفش مستعمل بمدينة جدة</strong>، فنحن نوفر لك باقة شاملة
                من الخدمات. سواء كنت ترغب في التخلص من غرف نوم قديمة، التجديد والتخلص من المطابخ المستعملة والمتهالكة، أو
                بيع الأجهزة الكهربائية التي تأخذ حيزاً كبيراً في منزلك، فإننا نغطي جميع هذه الاحتياجات. نهدف لتقديم أسعار
                عادلة تتناسب مع جودة وحالة القطع بنزاهة وشفافية. يقوم فريقنا المتخصص بفحص الأثاث وتقديم تقييم احترافي وسريع،
                مما يضمن لك تجربة بيع مريحة بدءاً من الاتصال وحتى وصول فريق الفك والنقل إلى باب بيتك.
            </p>
        </div>

        <div class="grid grid-cols-3">
            @forelse($services as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="card"
                    style="text-decoration:none;display:block;transition:all 0.2s;">
                    <h2>{{ $service->title }}</h2>
                    <p>{{ Str::limit(strip_tags($service->content), 100) }}</p>
                    <span class="text-blue-600"
                        style="font-size:0.85rem;margin-top:1rem;display:inline-block;font-weight:700;">عرض التفاصيل
                        ←</span>
                </a>
            @empty
                <div class="card" style="grid-column:1/-1;text-align:center;">
                    <p>قريباً سيتم إضافة تفاصيل الخدمات.</p>
                    <!-- For test data: -->
                    <a href="#" class="font-bold text-blue-600" style="margin-top:1rem;display:inline-block;">مثال:
                        شراء غرف نوم مستعملة</a>
                    <br>
                    <a href="#" class="font-bold text-blue-600" style="margin-top:1rem;display:inline-block;">مثال:
                        شراء مكيفات خربانة</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
