@extends('admin.layouts.app')
@section('title', $template->exists ? 'تعديل القالب' : 'قالب جديد')
@section('page-title', $template->exists ? 'تعديل القالب' : 'قالب SEO جديد')
@section('topbar-actions')
    <a href="{{ route('admin.seo.templates.index') }}" class="btn btn-secondary">← العودة</a>
@endsection

@section('content')
    <div class="card">
        <form method="POST"
            action="{{ $template->exists ? route('admin.seo.templates.update', $template) : route('admin.seo.templates.store') }}">
            @csrf
            @if ($template->exists)
                @method('PUT')
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="template_key">مفتاح القالب <code style="font-size:0.75rem;color:#6b7280;">(programmatic_intro,
                            programmatic_faq, selling_points, cta)</code></label>
                    <input type="text" id="template_key" name="template_key"
                        value="{{ old('template_key', $template->template_key) }}" required>
                </div>
                <div class="form-group">
                    <label for="language">اللغة</label>
                    <select id="language" name="language">
                        <option value="ar"
                            {{ old('language', $template->language ?? 'ar') === 'ar' ? 'selected' : '' }}>عربي</option>
                        <option value="en"
                            {{ old('language', $template->language ?? 'ar') === 'en' ? 'selected' : '' }}>إنجليزي</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="body">المحتوى <small style="color:#6b7280;">— متاح: {city}, {district}, {service},
                        {keyword}, {brand}, {year}</small></label>
                <textarea id="body" name="body" rows="12" style="font-family:monospace;font-size:0.875rem;">{{ old('body', $template->body) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">حفظ القالب</button>
        </form>
    </div>
@endsection
