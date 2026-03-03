@extends('admin.layouts.app')
@section('title', 'تقويم المحتوى')
@section('page-title', 'تقويم المحتوى')

@section('content')
    <div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start;">
        {{-- Calendar List --}}
        <div class="card" style="padding:0;">
            <div style="padding:1rem 1.5rem;border-bottom:1px solid #e5e7eb;display:flex;gap:0.75rem;align-items:center;">
                <strong>العناصر المجدولة</strong>
                <form method="GET" style="margin-right:auto;display:flex;gap:0.5rem;">
                    <select name="status" onchange="this.form.submit()" style="width:auto;">
                        <option value="">كل الحالات</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلق</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>منشور</option>
                        <option value="skipped" {{ request('status') === 'skipped' ? 'selected' : '' }}>متخطى</option>
                    </select>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>النوع</th>
                        <th>موعد النشر</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        @php $entity = $item->getEntity() @endphp
                        <tr>
                            <td>
                                <strong>{{ $entity?->title ?? 'العنصر غير متاح' }}</strong><br>
                                <small
                                    style="color:#6b7280;">{{ $item->type === 'blog_post' ? 'مقال' : 'صفحة برمجية' }}</small>
                            </td>
                            <td>{{ $item->scheduled_for->format('Y-m-d H:i') }}</td>
                            <td>
                                <span
                                    class="badge badge-{{ $item->status === 'published' ? 'published' : ($item->status === 'pending' ? 'draft' : 'scheduled') }}">
                                    {{ match ($item->status) {'pending' => 'معلق','published' => 'منشور','skipped' => 'متخطى'} }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;gap:0.4rem;">
                                    @if ($item->status === 'pending')
                                        <form method="POST" action="{{ route('admin.calendar.publish-now', $item) }}">
                                            @csrf
                                            <button class="btn btn-success"
                                                style="padding:0.25rem 0.6rem;font-size:0.8rem;">نشر</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.calendar.skip', $item) }}">
                                            @csrf
                                            <button class="btn btn-secondary"
                                                style="padding:0.25rem 0.6rem;font-size:0.8rem;">تخطي</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.calendar.destroy', $item) }}">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger" style="padding:0.25rem 0.6rem;font-size:0.8rem;"
                                            onclick="return confirm('حذف؟')">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:2rem;color:#6b7280;">لا توجد عناصر مجدولة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($items->hasPages())
                <div style="padding:1rem 1.5rem;">{{ $items->links() }}</div>
            @endif
        </div>

        {{-- Add Item Form --}}
        <div>
            <div class="card" style="margin-bottom:1rem;">
                <strong style="display:block;margin-bottom:1rem;">إضافة عنصر</strong>
                <form method="POST" action="{{ route('admin.calendar.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>النوع</label>
                        <select name="type" id="calendar-type" onchange="toggleCalendarEntity(this.value)">
                            <option value="blog_post">مقال</option>
                            <option value="programmatic_page">صفحة برمجية</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>العنصر</label>
                        <select name="entity_id" id="entity-blog">
                            @foreach ($posts as $p)
                                <option value="{{ $p->id }}">{{ $p->title }}</option>
                            @endforeach
                        </select>
                        <select name="entity_id" id="entity-programmatic" style="display:none;">
                            @foreach ($programmaticPages as $p)
                                <option value="{{ $p->id }}">{{ $p->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>موعد النشر</label>
                        <input type="datetime-local" name="scheduled_for" required>
                    </div>
                    <div class="form-group">
                        <label>ملاحظات</label>
                        <textarea name="notes" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">إضافة</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleCalendarEntity(type) {
                document.getElementById('entity-blog').style.display = type === 'blog_post' ? 'block' : 'none';
                document.getElementById('entity-programmatic').style.display = type === 'programmatic_page' ? 'block' : 'none';
            }
        </script>
    @endpush
@endsection
