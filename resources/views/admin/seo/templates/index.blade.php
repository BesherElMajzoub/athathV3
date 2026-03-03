@extends('admin.layouts.app')
@section('title', 'قوالب SEO')
@section('page-title', 'قوالب SEO')
@section('topbar-actions')
    <a href="{{ route('admin.seo.templates.create') }}" class="btn btn-primary">+ قالب جديد</a>
@endsection

@section('content')
    <div class="card" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>مفتاح القالب</th>
                    <th>اللغة</th>
                    <th>نموذج المحتوى</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr>
                        <td><code
                                style="background:#f3f4f6;padding:0.2rem 0.5rem;border-radius:4px;">{{ $template->template_key }}</code>
                        </td>
                        <td>{{ $template->language }}</td>
                        <td style="color:#6b7280;font-size:0.875rem;">{{ Str::limit($template->body, 80) }}</td>
                        <td>
                            <div style="display:flex;gap:0.5rem;">
                                <a href="{{ route('admin.seo.templates.edit', $template) }}" class="btn btn-secondary"
                                    style="padding:0.3rem 0.7rem;">تعديل</a>
                                <form method="POST" action="{{ route('admin.seo.templates.destroy', $template) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" style="padding:0.3rem 0.7rem;"
                                        onclick="return confirm('حذف؟')">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:2rem;color:#6b7280;">
                            لا توجد قوالب. أضف قوالب مثل: <code>programmatic_intro</code>, <code>programmatic_faq</code>,
                            <code>cta</code>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($templates->hasPages())
            <div style="padding:1rem 1.5rem;">{{ $templates->links() }}</div>
        @endif
    </div>
@endsection
