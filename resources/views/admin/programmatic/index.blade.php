@extends('admin.layouts.app')
@section('title', 'الصفحات البرمجية')
@section('page-title', 'الصفحات البرمجية')
@section('topbar-actions')
    <a href="{{ route('admin.programmatic.create') }}" class="btn btn-primary">+ صفحة جديدة</a>
@endsection

@section('content')
    <div class="card" style="padding:0;">
        <div style="padding:1rem 1.5rem;border-bottom:1px solid #e5e7eb;display:flex;gap:0.75rem;align-items:center;">
            <form method="GET" style="display:flex;gap:0.5rem;align-items:center;">
                <select name="status" onchange="this.form.submit()" style="width:auto;">
                    <option value="">كل الحالات</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>منشور</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>مسودة</option>
                </select>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>الكلمة الرئيسية</th>
                    <th>الحالة</th>
                    <th>قابل للفهرسة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>
                            <strong>{{ $page->title }}</strong><br>
                            <small style="color:#6b7280;">/p/{{ $page->slug }}</small>
                        </td>
                        <td>{{ $page->primary_keyword }}</td>
                        <td><span
                                class="badge badge-{{ $page->status }}">{{ $page->status === 'published' ? 'منشور' : 'مسودة' }}</span>
                        </td>
                        <td>{{ $page->indexable ? '✓' : '✗' }}</td>
                        <td>
                            <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
                                <a href="{{ route('admin.programmatic.edit', $page) }}" class="btn btn-secondary"
                                    style="padding:0.3rem 0.7rem;">تعديل</a>
                                @if ($page->status === 'draft')
                                    <form method="POST" action="{{ route('admin.programmatic.publish', $page) }}">
                                        @csrf
                                        <button class="btn btn-success" style="padding:0.3rem 0.7rem;">نشر</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.programmatic.regenerate', $page) }}">
                                    @csrf
                                    <button class="btn btn-secondary" style="padding:0.3rem 0.7rem;">إعادة توليد</button>
                                </form>
                                <form method="POST" action="{{ route('admin.programmatic.destroy', $page) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" style="padding:0.3rem 0.7rem;"
                                        onclick="return confirm('حذف؟')">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:#6b7280;">لا توجد صفحات.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($pages->hasPages())
            <div style="padding:1rem 1.5rem;">{{ $pages->links() }}</div>
        @endif
    </div>
@endsection
