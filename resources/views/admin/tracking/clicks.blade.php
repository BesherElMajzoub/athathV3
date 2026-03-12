@extends('admin.layouts.app')

@section('title', 'تتبع النقرات')
@section('page-title', 'تتبع النقرات (بدون page_view)')

@section('content')
    {{-- Stats Cards --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
        <div class="card" style="text-align:center;">
            <div style="font-size:2rem;font-weight:900;color:var(--primary);">{{ number_format($totalClicks) }}</div>
            <div style="font-size:.85rem;color:#6b7280;margin-top:.25rem;">إجمالي النقرات</div>
        </div>
        <div class="card">
            <div style="font-size:.8rem;font-weight:600;color:#6b7280;margin-bottom:.5rem;">أفضل 5 صفحات بالنقرات</div>
            @forelse($topPages as $tp)
                <div
                    style="display:flex;justify-content:space-between;font-size:.8rem;padding:.2rem 0;border-bottom:1px solid #f3f4f6;">
                    <span style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                        title="{{ $tp->page_url }}">{{ parse_url($tp->page_url, PHP_URL_PATH) ?: '/' }}</span>
                    <strong>{{ $tp->click_count }}</strong>
                </div>
            @empty
                <span style="font-size:.8rem;color:#9ca3af;">لا توجد بيانات</span>
            @endforelse
        </div>
        <div class="card">
            <div style="font-size:.8rem;font-weight:600;color:#6b7280;margin-bottom:.5rem;">أفضل 5 أحداث</div>
            @forelse($topEvents as $te)
                <div
                    style="display:flex;justify-content:space-between;font-size:.8rem;padding:.2rem 0;border-bottom:1px solid #f3f4f6;">
                    <span>{{ $te->event_type }}</span>
                    <strong>{{ $te->click_count }}</strong>
                </div>
            @empty
                <span style="font-size:.8rem;color:#9ca3af;">لا توجد بيانات</span>
            @endforelse
        </div>
    </div>

    {{-- Filters --}}
    <div class="card" style="margin-bottom:1.5rem;">
        <form method="GET" action="{{ route('admin.tracking.clicks') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-end;">
            <div class="form-group" style="margin-bottom:0;flex:1;min-width:140px;">
                <label for="from">من تاريخ</label>
                <input type="date" id="from" name="from" value="{{ request('from') }}">
            </div>
            <div class="form-group" style="margin-bottom:0;flex:1;min-width:140px;">
                <label for="to">إلى تاريخ</label>
                <input type="date" id="to" name="to" value="{{ request('to') }}">
            </div>
            <div class="form-group" style="margin-bottom:0;flex:1;min-width:160px;">
                <label for="event_type">نوع الحدث</label>
                <select id="event_type" name="event_type">
                    <option value="">الكل</option>
                    <option value="whatsapp" {{ request('event_type') == 'whatsapp' ? 'selected' : '' }}>واتساب</option>
                    <option value="call" {{ request('event_type') == 'call' ? 'selected' : '' }}>اتصال</option>
                    <option value="form" {{ request('event_type') == 'form' ? 'selected' : '' }}>نموذج</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0;flex:2;min-width:200px;">
                <label for="page_url">الصفحة (جزء من الرابط)</label>
                <input type="text" id="page_url" name="page_url" value="{{ request('page_url') }}"
                    placeholder="مثال: services">
            </div>
            <div style="display:flex;gap:.5rem;">
                <button type="submit" class="btn btn-primary">🔍 فلترة</button>
                <a href="{{ route('admin.tracking.clicks') }}" class="btn btn-secondary">مسح</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>نوع الحدث</th>
                    <th>الصفحة</th>
                    <th>بيانات إضافية</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>
                            @if (str_contains($event->event_type, 'whatsapp'))
                                <span class="badge badge-published">💬 {{ $event->event_type }}</span>
                            @elseif(str_contains($event->event_type, 'call'))
                                <span class="badge badge-scheduled">📞 {{ $event->event_type }}</span>
                            @elseif(str_contains($event->event_type, 'form'))
                                <span class="badge badge-draft">📨 {{ $event->event_type }}</span>
                            @else
                                <span class="badge"
                                    style="background:#f3f4f6;color:#374151;">{{ $event->event_type }}</span>
                            @endif
                        </td>
                        <td style="max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                            title="{{ $event->page_url }}">
                            {{ parse_url($event->page_url, PHP_URL_PATH) ?: '/' }}
                        </td>
                        <td
                            style="font-size:.8rem;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            @if ($event->meta_data)
                                @foreach ($event->meta_data as $key => $val)
                                    <span
                                        style="background:#f3f4f6;padding:0.1rem 0.4rem;border-radius:4px;margin-left:0.2rem;">{{ $key }}:
                                        {{ is_string($val) ? Str::limit($val, 30) : '' }}</span>
                                @endforeach
                            @else
                                —
                            @endif
                        </td>
                        <td style="font-size:.85rem;color:#6b7280;white-space:nowrap;">
                            {{ $event->created_at?->format('Y-m-d H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:#9ca3af;">لا توجد أحداث نقر مسجّلة.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($events->hasPages())
            <div style="margin-top:1rem;display:flex;justify-content:center;">
                {{ $events->links() }}
            </div>
        @endif
    </div>
@endsection
