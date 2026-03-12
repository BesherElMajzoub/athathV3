@extends('admin.layouts.app')

@section('title', 'تحليل النقرات')
@section('page-title', '📈 تتبع النقرات')

@push('head')
    <style>
        /* ===== Clicks Page Styles ===== */
        .clicks-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .clicks-header-info h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .clicks-header-info p {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }

        /* ===== Stats Cards ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: box-shadow 0.2s, transform 0.2s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            border-radius: 0 12px 12px 0;
        }

        .stat-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .stat-card.primary::before {
            background: var(--primary);
        }

        .stat-card.success::before {
            background: var(--success);
        }

        .stat-card.warning::before {
            background: var(--warning);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-card.primary .stat-icon {
            background: #eff6ff;
        }

        .stat-card.success .stat-icon {
            background: #f0fdf4;
        }

        .stat-card.warning .stat-icon {
            background: #fffbeb;
        }

        .stat-info {
            flex: 1;
            min-width: 0;
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ===== Top Lists Grid ===== */
        .top-lists-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }

        @media (max-width: 768px) {
            .top-lists-grid {
                grid-template-columns: 1fr;
            }
        }

        .top-list-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .top-list-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-900);
        }

        .top-list-body {
            padding: 0.75rem 1.25rem;
        }

        .top-list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--gray-100);
            gap: 0.75rem;
            transition: background 0.15s;
        }

        .top-list-item:last-child {
            border-bottom: none;
        }

        .top-list-rank {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--gray-100);
            color: var(--gray-700);
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .top-list-rank.gold {
            background: #fef9c3;
            color: #a16207;
        }

        .top-list-rank.silver {
            background: #f1f5f9;
            color: #475569;
        }

        .top-list-rank.bronze {
            background: #fff7ed;
            color: #c2410c;
        }

        .top-list-text {
            flex: 1;
            font-size: 0.825rem;
            color: var(--gray-700);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            min-width: 0;
        }

        .top-list-badge {
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            flex-shrink: 0;
        }

        .top-list-badge.green {
            background: #f0fdf4;
            color: #15803d;
        }

        /* ===== Filter Panel ===== */
        .filter-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            margin-bottom: 1.75rem;
            overflow: hidden;
        }

        .filter-card-header {
            padding: 0.875rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-700);
            cursor: pointer;
            user-select: none;
            justify-content: space-between;
        }

        .filter-card-header .filter-toggle-icon {
            transition: transform 0.2s;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .filter-card-header.open .filter-toggle-icon {
            transform: rotate(180deg);
        }

        .filter-card-body {
            padding: 1.25rem;
            display: none;
        }

        .filter-card-body.open {
            display: block;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .filter-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.4rem;
            display: block;
        }

        .filter-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        /* ===== Table Card ===== */
        .table-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .table-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-900);
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .table-count-badge {
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 0.2rem 0.75rem;
            border-radius: 9999px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .clicks-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .clicks-table thead th {
            background: var(--gray-50);
            padding: 0.75rem 1rem;
            text-align: right;
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-200);
            white-space: nowrap;
        }

        .clicks-table tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
            color: var(--gray-700);
        }

        .clicks-table tbody tr:last-child td {
            border-bottom: none;
        }

        .clicks-table tbody tr:hover td {
            background: var(--gray-50);
        }

        .event-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #eff6ff;
            color: #1d4ed8;
            white-space: nowrap;
        }

        .event-badge.click {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .event-badge.whatsapp {
            background: #f0fdf4;
            color: #15803d;
        }

        .event-badge.phone {
            background: #fff7ed;
            color: #c2410c;
        }

        .event-badge.form {
            background: #fdf4ff;
            color: #7e22ce;
        }

        .url-cell {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .ip-chip {
            font-family: 'Courier New', monospace;
            font-size: 0.75rem;
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            letter-spacing: 0.05em;
        }

        .date-cell {
            font-size: 0.8rem;
            color: #6b7280;
            white-space: nowrap;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #9ca3af;
        }

        .empty-state-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .empty-state-text {
            font-size: 0.9rem;
            color: #6b7280;
        }

        /* ===== Pagination ===== */
        .pagination-wrapper {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--gray-100);
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper nav {
            display: flex;
            gap: 0.35rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination-wrapper span,
        .pagination-wrapper a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 0.5rem;
            border-radius: 7px;
            font-size: 0.825rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s;
        }

        .pagination-wrapper a {
            color: var(--gray-700);
            border: 1px solid var(--gray-200);
            background: #fff;
        }

        .pagination-wrapper a:hover {
            background: var(--gray-50);
            border-color: var(--primary);
            color: var(--primary);
        }

        .pagination-wrapper span[aria-current="page"] span {
            background: var(--primary);
            color: #fff;
            border: 1px solid var(--primary);
            min-width: 34px;
            height: 34px;
            border-radius: 7px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-wrapper span.disabled {
            color: #d1d5db;
            border: 1px solid var(--gray-200);
            cursor: not-allowed;
            background: var(--gray-50);
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="clicks-header">
        <div class="clicks-header-info">
            <h1>تحليل النقرات</h1>
            <p>سجل النقرات على الأزرار والروابط — لا يشمل زيارات الصفحات</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon">📊</div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($totalClicks) }}</div>
                <div class="stat-label">إجمالي النقرات</div>
            </div>
        </div>

        @if ($topPages->count())
            <div class="stat-card success">
                <div class="stat-icon">🏆</div>
                <div class="stat-info">
                    <div class="stat-value">{{ number_format($topPages->first()->total) }}</div>
                    <div class="stat-label" title="{{ $topPages->first()->page_url }}">أعلى صفحة:
                        {{ Str::limit($topPages->first()->page_url, 28) }}</div>
                </div>
            </div>
        @endif

        @if ($topPlacements->count())
            <div class="stat-card warning">
                <div class="stat-icon">🎯</div>
                <div class="stat-info">
                    <div class="stat-value">{{ number_format($topPlacements->first()->total) }}</div>
                    <div class="stat-label">أفضل موضع: {{ $topPlacements->first()->placement }}</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Top Lists -->
    <div class="top-lists-grid">
        <!-- Top Pages -->
        <div class="top-list-card">
            <div class="top-list-header">
                <span>🌐</span> أفضل الصفحات بالنقرات
            </div>
            <div class="top-list-body">
                @forelse($topPages as $i => $page)
                    @php
                        $rankClass = match ($i) {
                            0 => 'gold',
                            1 => 'silver',
                            2 => 'bronze',
                            default => '',
                        };
                    @endphp
                    <div class="top-list-item">
                        <div class="top-list-rank {{ $rankClass }}">{{ $i + 1 }}</div>
                        <span class="top-list-text" title="{{ $page->page_url }}">{{ $page->page_url }}</span>
                        <span class="top-list-badge">{{ number_format($page->total) }}</span>
                    </div>
                @empty
                    <div style="text-align:center;color:#9ca3af;padding:1.5rem 0;font-size:0.85rem;">لا توجد بيانات</div>
                @endforelse
            </div>
        </div>

        <!-- Top Placements -->
        <div class="top-list-card">
            <div class="top-list-header">
                <span>📍</span> أفضل مواقع الأزرار (Placements)
            </div>
            <div class="top-list-body">
                @forelse($topPlacements as $i => $place)
                    @php
                        $rankClass = match ($i) {
                            0 => 'gold',
                            1 => 'silver',
                            2 => 'bronze',
                            default => '',
                        };
                    @endphp
                    <div class="top-list-item">
                        <div class="top-list-rank {{ $rankClass }}">{{ $i + 1 }}</div>
                        <span class="top-list-text">{{ $place->placement }}</span>
                        <span class="top-list-badge green">{{ number_format($place->total) }}</span>
                    </div>
                @empty
                    <div style="text-align:center;color:#9ca3af;padding:1.5rem 0;font-size:0.85rem;">لا توجد بيانات</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="filter-card">
        <div class="filter-card-header" id="filterToggle" onclick="toggleFilter()">
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <span>🔍</span> تصفية وبحث
                @if (request()->hasAny(['start_date', 'end_date', 'event_type', 'page_url']) &&
                        collect(request()->only(['start_date', 'end_date', 'event_type', 'page_url']))->filter()->isNotEmpty())
                    <span
                        style="font-size:0.7rem;background:#eff6ff;color:#1d4ed8;padding:0.15rem 0.5rem;border-radius:9999px;font-weight:600;">مفعّل</span>
                @endif
            </div>
            <span class="filter-toggle-icon" id="filterToggleIcon">▼</span>
        </div>
        <div class="filter-card-body" id="filterBody">
            <form method="GET" action="{{ route('admin.clicks.index') }}">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="start_date">من تاريخ</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="filter-group">
                        <label for="end_date">إلى تاريخ</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="filter-group">
                        <label for="event_type">نوع الحدث</label>
                        <select id="event_type" name="event_type">
                            <option value="">— الكل —</option>
                            @foreach ($allEventTypes as $et)
                                <option value="{{ $et }}" @selected($et == $eventType)>{{ $et }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="page_url">رابط الصفحة</label>
                        <input type="text" id="page_url" name="page_url" value="{{ $pageUrl }}"
                            placeholder="https://...">
                    </div>
                </div>
                <div class="filter-actions">
                    <a href="{{ route('admin.clicks.index') }}" class="btn btn-secondary">↺ إعادة ضبط</a>
                    <button type="submit" class="btn btn-primary">🔍 تطبيق الفلتر</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Events Table -->
    <div class="table-card">
        <div class="table-card-header">
            <span>📋 سجل النقرات</span>
            <span class="table-count-badge">{{ $events->total() }} نقرة</span>
        </div>

        <div class="table-wrapper">
            <table class="clicks-table">
                <thead>
                    <tr>
                        <th>نوع الحدث</th>
                        <th>الموضع (Placement)</th>
                        <th>صفحة المصدر</th>
                        <th>الرابط الهدف</th>
                        <th>IP Hash</th>
                        <th>التاريخ والوقت</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        @php
                            $evType = strtolower($event->event_type ?? '');
                            $evClass = str_contains($evType, 'whatsapp')
                                ? 'whatsapp'
                                : (str_contains($evType, 'phone') || str_contains($evType, 'call')
                                    ? 'phone'
                                    : (str_contains($evType, 'form')
                                        ? 'form'
                                        : 'click'));
                        @endphp
                        <tr>
                            <td>
                                <span class="event-badge {{ $evClass }}">
                                    @if ($evClass === 'whatsapp')
                                        💬
                                    @elseif($evClass === 'phone')
                                        📞
                                    @elseif($evClass === 'form')
                                        📝
                                    @else
                                        🖱️
                                    @endif
                                    {{ $event->event_type }}
                                </span>
                            </td>
                            <td>
                                @if ($event->placement)
                                    <span
                                        style="font-size:0.825rem;background:var(--gray-100);padding:0.15rem 0.5rem;border-radius:5px;color:var(--gray-700);">
                                        {{ $event->placement }}
                                    </span>
                                @else
                                    <span style="color:#d1d5db;">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $event->page_url }}" target="_blank" class="url-cell"
                                    title="{{ $event->page_url }}"
                                    style="color:var(--primary);text-decoration:none;font-size:0.825rem;">
                                    {{ $event->page_url }}
                                </a>
                            </td>
                            <td>
                                @if ($event->target_url)
                                    <a href="{{ $event->target_url }}" target="_blank" class="url-cell"
                                        title="{{ $event->target_url }}"
                                        style="color:#6b7280;text-decoration:none;font-size:0.825rem;">
                                        {{ $event->target_url }}
                                    </a>
                                @else
                                    <span style="color:#d1d5db;">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="ip-chip">{{ substr($event->ip_hash, 0, 8) }}…</span>
                            </td>
                            <td class="date-cell" dir="ltr">
                                {{ \Carbon\Carbon::parse($event->created_at)->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <div class="empty-state-text">لا توجد نقرات مسجلة بالفلاتر المحددة</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($events->hasPages())
            <div class="pagination-wrapper">
                {{ $events->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Filter toggle
        const filterBody = document.getElementById('filterBody');
        const filterToggle = document.getElementById('filterToggle');
        const toggleIcon = document.getElementById('filterToggleIcon');

        function toggleFilter() {
            const isOpen = filterBody.classList.toggle('open');
            filterToggle.classList.toggle('open', isOpen);
        }

        // Auto-open filter panel if active filters exist
        const activeFilters =
            {{ json_encode(
                collect(request()->only(['start_date', 'end_date', 'event_type', 'page_url']))->filter()->isNotEmpty(),
            ) }};
        if (activeFilters) toggleFilter();
    </script>
@endpush
