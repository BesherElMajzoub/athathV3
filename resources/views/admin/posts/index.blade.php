@extends('admin.layouts.app')

@section('title', 'إدارة المقالات')
@section('page-title', 'المقالات')

@section('topbar-actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ مقال جديد</a>
@endsection

@section('content')
    <div class="card" style="padding:0;">
        {{-- Filters --}}
        <div style="padding:1rem 1.5rem;border-bottom:1px solid #e5e7eb;display:flex;gap:1rem;align-items:center;">
            <form method="GET" style="display:flex;gap:0.75rem;align-items:center;flex:1;">
                <input type="text" name="search" placeholder="بحث في العنوان…" value="{{ request('search') }}"
                    style="max-width:260px;">
                <select name="status" style="width:auto;">
                    <option value="">كل الحالات</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>منشور</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>مسودة</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>مجدول</option>
                </select>
                <button type="submit" class="btn btn-secondary">بحث</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">إعادة تعيين</a>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>التصنيفات</th>
                    <th>الحالة</th>
                    <th>تاريخ النشر</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>
                            <strong>{{ $post->title }}</strong>
                            <br><small style="color:#6b7280;">/blog/{{ $post->slug }}</small>
                        </td>
                        <td>
                            @foreach ($post->categories as $cat)
                                <span class="badge" style="background:#e5e7eb;color:#374151;">{{ $cat->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge badge-{{ $post->status }}">
                                {{ match ($post->status) {'published' => 'منشور','draft' => 'مسودة','scheduled' => 'مجدول'} }}
                            </span>
                        </td>
                        <td>{{ $post->published_at?->format('Y-m-d H:i') ?? '—' }}</td>
                        <td>
                            <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-secondary"
                                    style="padding:0.3rem 0.7rem;">تعديل</a>
                                @if ($post->status !== 'published')
                                    <form method="POST" action="{{ route('admin.posts.publish-now', $post) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success" style="padding:0.3rem 0.7rem;"
                                            onclick="return confirm('نشر الآن؟')">نشر</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.posts.duplicate', $post) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary"
                                        style="padding:0.3rem 0.7rem;">تكرار</button>
                                </form>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem;"
                                        onclick="return confirm('حذف المقال؟')">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:#6b7280;">لا توجد مقالات. <a
                                href="{{ route('admin.posts.create') }}">أنشئ أول مقال</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($posts->hasPages())
            <div style="padding:1rem 1.5rem;border-top:1px solid #e5e7eb;">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
