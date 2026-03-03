@extends('admin.layouts.app')
@section('title', $cluster->exists ? 'تعديل المجموعة' : 'مجموعة جديدة')
@section('page-title', $cluster->exists ? 'تعديل المجموعة' : 'مجموعة كلمات جديدة')
@section('topbar-actions')
    <a href="{{ route('admin.seo.clusters.index') }}" class="btn btn-secondary">← العودة</a>
@endsection

@section('content')
    <div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start;">
        <div class="card">
            <form method="POST"
                action="{{ $cluster->exists ? route('admin.seo.clusters.update', $cluster) : route('admin.seo.clusters.store') }}">
                @csrf
                @if ($cluster->exists)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="cluster_name">اسم المجموعة</label>
                    <input type="text" id="cluster_name" name="cluster_name"
                        value="{{ old('cluster_name', $cluster->cluster_name) }}" required>
                </div>
                <div class="form-group">
                    <label for="primary_keyword">الكلمة المفتاحية الأساسية</label>
                    <input type="text" id="primary_keyword" name="primary_keyword"
                        value="{{ old('primary_keyword', $cluster->primary_keyword) }}" required>
                </div>
                <div class="form-group">
                    <label for="language">اللغة</label>
                    <select id="language" name="language">
                        <option value="ar" {{ old('language', $cluster->language) === 'ar' ? 'selected' : '' }}>عربي
                        </option>
                        <option value="en" {{ old('language', $cluster->language) === 'en' ? 'selected' : '' }}>إنجليزي
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>

            {{-- Bulk Import --}}
            @if ($cluster->exists)
                <hr style="margin:1.5rem 0;">
                <strong style="display:block;margin-bottom:0.75rem;">استيراد كلمات مفتاحية</strong>
                <form method="POST" action="{{ route('admin.seo.clusters.import-keywords', $cluster) }}">
                    @csrf
                    <div class="form-group">
                        <label for="keywords_text">كلمة في كل سطر:</label>
                        <textarea id="keywords_text" name="keywords_text" rows="6"
                            placeholder="شراء أثاث مستعمل جدة&#10;بيع أثاث مستعمل&#10;…"></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">استيراد</button>
                </form>
            @endif
        </div>

        @if ($cluster->exists && isset($cluster->keywords))
            <div class="card" style="padding:0;">
                <div style="padding:1rem 1.25rem;border-bottom:1px solid #e5e7eb;"><strong>الكلمات
                        ({{ $cluster->keywords->count() }})</strong></div>
                <div style="max-height:400px;overflow-y:auto;">
                    @foreach ($cluster->keywords as $kw)
                        <div style="padding:0.6rem 1.25rem;border-bottom:1px solid #f3f4f6;font-size:0.875rem;">
                            {{ $kw->keyword }}</div>
                    @endforeach
                    @if ($cluster->keywords->isEmpty())
                        <div style="padding:1.5rem;color:#6b7280;text-align:center;font-size:0.875rem;">لا توجد كلمات بعد.
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
