@extends('admin.layouts.app')

@section('title', $post->exists ? 'تعديل: ' . $post->title : 'مقال جديد')
@section('page-title', $post->exists ? 'تعديل المقال' : 'مقال جديد')

@section('topbar-actions')
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">← العودة</a>
@endsection

@push('head')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        .tabs {
            display: flex;
            gap: 0;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }

        .tab-btn {
            padding: 0.75rem 1.25rem;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 0.9rem;
            color: #6b7280;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.15s;
        }

        .tab-btn.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
            font-weight: 600;
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        .seo-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 6px;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
        }

        .seo-check.pass {
            background: #f0fdf4;
            color: #166534;
        }

        .seo-check.fail {
            background: #fef2f2;
            color: #991b1b;
        }

        .faq-item {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.75rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media(max-width:768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <form method="POST" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
        enctype="multipart/form-data" id="post-form">
        @csrf
        @if ($post->exists)
            @method('PUT')
        @endif

        <div style="display:grid;grid-template-columns:1fr 380px;gap:1.5rem;align-items:start;">

            {{-- LEFT: Main Content --}}
            <div>
                {{-- Title --}}
                <div class="card" style="margin-bottom:1rem;">
                    <div class="form-group" style="margin:0;">
                        <label for="title">عنوان المقال <span style="color:red">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                            required placeholder="أدخل عنوان المقال…" oninput="autoSlug(this.value)"
                            style="font-size:1.1rem;font-weight:600;">
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="card">
                    <div class="tabs">
                        <button type="button" class="tab-btn active" onclick="switchTab('content')">📝 المحتوى</button>
                        <button type="button" class="tab-btn" onclick="switchTab('seo')">🔍 SEO</button>
                        <button type="button" class="tab-btn" onclick="switchTab('schema')">📋 Schema</button>
                    </div>

                    {{-- TAB: Content --}}
                    <div class="tab-panel active" id="tab-content">
                        <div class="form-group">
                            <label for="excerpt">المقتطف (Excerpt)</label>
                            <textarea id="excerpt" name="excerpt" rows="3" placeholder="وصف مختصر للمقال…">{{ old('excerpt', $post->excerpt) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="content">المحتوى <span style="color:red">*</span></label>
                            <textarea id="content" name="content" class="tinymce">{{ old('content', $post->content) }}</textarea>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label for="featured_image">الصورة المميزة</label>
                                @if ($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                                        alt="{{ $post->featured_image_alt }}"
                                        style="max-width:100%;height:140px;object-fit:cover;border-radius:6px;margin-bottom:0.5rem;display:block;">
                                @endif
                                <input type="file" id="featured_image" name="featured_image" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="featured_image_alt">Alt text للصورة</label>
                                <input type="text" id="featured_image_alt" name="featured_image_alt"
                                    value="{{ old('featured_image_alt', $post->featured_image_alt) }}"
                                    placeholder="وصف الصورة لمحركات البحث">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="author_name">اسم الكاتب</label>
                            <input type="text" id="author_name" name="author_name"
                                value="{{ old('author_name', $post->author_name) }}">
                        </div>
                    </div>

                    {{-- TAB: SEO --}}
                    <div class="tab-panel" id="tab-seo">
                        @if (isset($seoChecks) && $post->exists)
                            <div style="margin-bottom:1.25rem;">
                                <strong style="font-size:0.85rem;display:block;margin-bottom:0.5rem;">فحوصات SEO:</strong>
                                @foreach ($seoChecks as $key => $check)
                                    <div class="seo-check {{ $check['pass'] ? 'pass' : 'fail' }}">
                                        {{ $check['pass'] ? '✓' : '✗' }} {{ $check['message'] }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="meta_title">عنوان SEO (meta title) <small style="color:#6b7280">— الحد الأقصى 60
                                    حرف</small></label>
                            <input type="text" id="meta_title" name="meta_title" maxlength="70"
                                value="{{ old('meta_title', $post->meta_title) }}"
                                oninput="updateCharCount('meta_title', 60)">
                            <div class="char-counter" id="meta_title_counter">0 / 60</div>
                        </div>

                        <div class="form-group">
                            <label for="meta_description">وصف SEO (meta description) <small style="color:#6b7280">— الحد
                                    الأقصى 160 حرف</small></label>
                            <textarea id="meta_description" name="meta_description" rows="3" maxlength="170"
                                oninput="updateCharCount('meta_description', 160)">{{ old('meta_description', $post->meta_description) }}</textarea>
                            <div class="char-counter" id="meta_description_counter">0 / 160</div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label for="focus_keyword">الكلمة المفتاحية</label>
                                <input type="text" id="focus_keyword" name="focus_keyword"
                                    value="{{ old('focus_keyword', $post->focus_keyword) }}"
                                    placeholder="مثال: شراء أثاث مستعمل جدة">
                            </div>
                            <div class="form-group">
                                <label for="canonical_url">Canonical URL</label>
                                <input type="url" id="canonical_url" name="canonical_url"
                                    value="{{ old('canonical_url', $post->canonical_url) }}"
                                    placeholder="اتركه فارغاً للقيمة الافتراضية">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="enable_auto_internal_links" value="1"
                                    {{ old('enable_auto_internal_links', $post->enable_auto_internal_links ?? true) ? 'checked' : '' }}>
                                تفعيل الربط الداخلي التلقائي
                            </label>
                        </div>
                    </div>

                    {{-- TAB: Schema --}}
                    <div class="tab-panel" id="tab-schema">
                        <div class="form-group">
                            <label for="schema_type">نوع Schema</label>
                            <select id="schema_type" name="schema_type" onchange="toggleFaq(this.value)">
                                @foreach (['Article', 'BlogPosting', 'NewsArticle', 'FAQPage'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('schema_type', $post->schema_type) === $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="faq-builder"
                            style="{{ old('schema_type', $post->schema_type) === 'FAQPage' ? '' : 'display:none' }}">
                            <label style="margin-bottom:0.75rem;display:block;font-weight:600;">بنود FAQ (للـ FAQPage
                                Schema):</label>
                            <div id="faq-items">
                                @foreach (old('schema_faq', $post->schema_faq ?? []) as $i => $faq)
                                    <div class="faq-item" id="faq-{{ $i }}">
                                        <div class="form-group">
                                            <label>السؤال</label>
                                            <input type="text" name="schema_faq[{{ $i }}][question]"
                                                value="{{ $faq['question'] ?? '' }}">
                                        </div>
                                        <div class="form-group" style="margin:0;">
                                            <label>الإجابة</label>
                                            <textarea name="schema_faq[{{ $i }}][answer]" rows="3">{{ $faq['answer'] ?? '' }}</textarea>
                                        </div>
                                        <button type="button" onclick="removeFaq({{ $i }})"
                                            class="btn btn-danger"
                                            style="margin-top:0.5rem;padding:0.25rem 0.6rem;font-size:0.8rem;">حذف</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addFaq()" class="btn btn-secondary">+ إضافة سؤال</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div>
                {{-- Publishing --}}
                <div class="card" style="margin-bottom:1rem;">
                    <strong style="display:block;margin-bottom:1rem;font-size:0.95rem;">النشر والجدولة</strong>

                    <div class="form-group">
                        <label for="status">الحالة</label>
                        <select id="status" name="status" onchange="toggleScheduleField(this.value)">
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>مسودة
                            </option>
                            <option value="scheduled"
                                {{ old('status', $post->status) === 'scheduled' ? 'selected' : '' }}>مجدولة</option>
                            <option value="published"
                                {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>منشور</option>
                        </select>
                    </div>

                    <div class="form-group" id="published_at_group"
                        style="{{ in_array(old('status', $post->status), ['published', 'scheduled']) ? '' : 'display:none' }}">
                        <label for="published_at">تاريخ ووقت النشر</label>
                        <input type="datetime-local" id="published_at" name="published_at"
                            value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                    </div>

                    <div class="form-group">
                        <label for="slug">الرابط (Slug)</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}"
                            placeholder="سيتم توليده تلقائياً">
                        @if ($post->slugs->isNotEmpty())
                            <div style="margin-top:0.5rem;font-size:0.8rem;color:#6b7280;">
                                روابط قديمة (301 redirect):
                                @foreach ($post->slugs as $oldSlug)
                                    <span
                                        style="background:#f3f4f6;padding:0.15rem 0.4rem;border-radius:4px;margin:0.15rem;display:inline-block;">{{ $oldSlug->old_slug }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:0.5rem;">
                        <button type="submit" class="btn btn-primary" style="flex:1;">💾 حفظ</button>
                        @if ($post->exists && $post->status !== 'published')
                            <form method="POST" action="{{ route('admin.posts.publish-now', $post) }}" style="flex:1;">
                                @csrf
                                <button type="submit" class="btn btn-success" style="width:100%;">🚀 نشر الآن</button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Categories --}}
                <div class="card">
                    <strong style="display:block;margin-bottom:1rem;font-size:0.95rem;">التصنيفات</strong>
                    @foreach ($allCategories as $cat)
                        <label
                            style="display:flex;align-items:center;gap:0.5rem;padding:0.35rem 0;margin:0;font-weight:400;">
                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }}>
                            {{ $cat->name }}
                        </label>
                    @endforeach
                    @if ($allCategories->isEmpty())
                        <p style="color:#6b7280;font-size:0.85rem;">لا توجد تصنيفات بعد.</p>
                    @endif
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // TinyMCE
        tinymce.init({
            selector: '.tinymce',
            directionality: 'rtl',
            plugins: 'lists link image table code',
            toolbar: 'undo redo | blocks | bold italic | alignright aligncenter alignleft | bullist numlist | link image | code',
            height: 450,
            promotion: false,
            branding: false,
        });

        // Tabs
        function switchTab(name) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('tab-' + name).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        // Auto slug
        function autoSlug(title) {
            const slugField = document.getElementById('slug');
            if (slugField.dataset.manual === 'true') return;
            slugField.value = title
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^ء-ي0-9a-z\-]/gu, '')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        }
        document.getElementById('slug')?.addEventListener('input', function() {
            this.dataset.manual = 'true';
        });

        // Character counters
        function updateCharCount(fieldId, max) {
            const field = document.getElementById(fieldId);
            const counter = document.getElementById(fieldId + '_counter');
            if (!field || !counter) return;
            const len = field.value.length;
            counter.textContent = len + ' / ' + max;
            counter.className = 'char-counter ' + (len > max ? 'over' : len > max * 0.9 ? 'warn' : 'ok');
        }
        // Init counters
        ['meta_title', 'meta_description'].forEach(id => {
            const field = document.getElementById(id);
            const max = id === 'meta_title' ? 60 : 160;
            if (field) {
                field.dispatchEvent(new Event('input'));
                updateCharCount(id, max);
            }
        });

        // Schedule field toggle
        function toggleScheduleField(status) {
            const group = document.getElementById('published_at_group');
            group.style.display = ['published', 'scheduled'].includes(status) ? 'block' : 'none';
        }

        // FAQ builder
        let faqCount = {{ count(old('schema_faq', $post->schema_faq ?? [])) }};

        function toggleFaq(type) {
            document.getElementById('faq-builder').style.display = type === 'FAQPage' ? 'block' : 'none';
        }

        function addFaq() {
            const container = document.getElementById('faq-items');
            const div = document.createElement('div');
            div.className = 'faq-item';
            div.id = 'faq-' + faqCount;
            div.innerHTML = `
        <div class="form-group">
            <label>السؤال</label>
            <input type="text" name="schema_faq[${faqCount}][question]">
        </div>
        <div class="form-group" style="margin:0;">
            <label>الإجابة</label>
            <textarea name="schema_faq[${faqCount}][answer]" rows="3"></textarea>
        </div>
        <button type="button" onclick="removeFaq(${faqCount})" class="btn btn-danger" style="margin-top:0.5rem;padding:0.25rem 0.6rem;font-size:0.8rem;">حذف</button>
    `;
            container.appendChild(div);
            faqCount++;
        }

        function removeFaq(id) {
            document.getElementById('faq-' + id)?.remove();
        }
    </script>
@endpush
