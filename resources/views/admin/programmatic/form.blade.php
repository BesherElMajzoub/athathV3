@extends('admin.layouts.app')
@section('title', $page->exists ? 'تعديل الصفحة' : 'صفحة برمجية جديدة')
@section('page-title', $page->exists ? 'تعديل الصفحة البرمجية' : 'صفحة برمجية جديدة')
@section('topbar-actions')
    <a href="{{ route('admin.programmatic.index') }}" class="btn btn-secondary">← العودة</a>
@endsection

@section('content')
    <form method="POST"
        action="{{ $page->exists ? route('admin.programmatic.update', $page) : route('admin.programmatic.store') }}">
        @csrf
        @if ($page->exists)
            @method('PUT')
        @endif

        <div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;">
            <div class="card">
                <div class="form-group">
                    <label for="title">العنوان الرئيسي *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $page->title) }}" required>
                </div>
                <div class="form-group">
                    <label for="slug">Slug (رابط) *</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $page->slug) }}" required
                        placeholder="service-district-city">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label for="primary_keyword">الكلمة الرئيسية *</label>
                        <input type="text" id="primary_keyword" name="primary_keyword"
                            value="{{ old('primary_keyword', $page->primary_keyword) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="city">المدينة</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $page->city ?? 'جدة') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="meta_title">عنوان SEO * <small style="color:#6b7280">60 حرف</small></label>
                    <input type="text" id="meta_title" name="meta_title"
                        value="{{ old('meta_title', $page->meta_title) }}" maxlength="70" required>
                </div>
                <div class="form-group">
                    <label for="meta_description">وصف SEO * <small style="color:#6b7280">160 حرف</small></label>
                    <textarea id="meta_description" name="meta_description" rows="3" maxlength="170" required>{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="canonical_url">Canonical URL</label>
                    <input type="url" id="canonical_url" name="canonical_url"
                        value="{{ old('canonical_url', $page->canonical_url) }}">
                </div>
            </div>

            <div>
                <div class="card" style="margin-bottom:1rem;">
                    <strong style="display:block;margin-bottom:1rem;">النشر</strong>
                    <div class="form-group">
                        <label for="status">الحالة</label>
                        <select id="status" name="status">
                            <option value="draft"
                                {{ old('status', $page->status ?? 'draft') === 'draft' ? 'selected' : '' }}>مسودة</option>
                            <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>
                                منشورة</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="indexable" value="1"
                                {{ old('indexable', $page->indexable ?? true) ? 'checked' : '' }}>
                            قابلة للفهرسة (indexable)
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="auto_generate" value="1">
                            توليد المحتوى تلقائياً من القوالب
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">حفظ</button>
                </div>
            </div>
        </div>
    </form>
@endsection
