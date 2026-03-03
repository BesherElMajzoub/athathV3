@extends('admin.layouts.app')
@section('title', 'تقارير SEO')
@section('page-title', 'تقارير SEO اليومية')

@section('content')
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 1.25rem;
            text-align: center;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: 900;
            color: #2563eb;
        }

        .stat-card .label {
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .stat-card .trend {
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .trend-up {
            color: #16a34a;
        }

        .trend-down {
            color: #dc2626;
        }
    </style>

    @if ($latest)
        <div class="stats-grid">
            <div class="stat-card">
                <div class="value">{{ $latest->posts_published }}</div>
                <div class="label">مقالات منشورة</div>
                @if (isset($trends['posts_published']))
                    <div class="trend {{ $trends['posts_published'] >= 0 ? 'trend-up' : 'trend-down' }}">
                        {{ $trends['posts_published'] >= 0 ? '+' : '' }}{{ $trends['posts_published'] }} من أمس
                    </div>
                @endif
            </div>
            <div class="stat-card">
                <div class="value">{{ $latest->programmatic_published }}</div>
                <div class="label">صفحات برمجية</div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $latest->drafts_count }}</div>
                <div class="label">مسودات</div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $latest->indexable_pages_count }}</div>
                <div class="label">صفحات قابلة للفهرسة</div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $latest->sitemap_urls_count }}</div>
                <div class="label">روابط في Sitemap</div>
            </div>
        </div>
    @endif

    <div class="card" style="padding:0;">
        <div
            style="padding:1rem 1.5rem;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center;">
            <strong>آخر 30 يوم</strong>
            <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn btn-secondary" style="font-size:0.8rem;">فتح
                Sitemap</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>مقالات منشورة</th>
                    <th>صفحات برمجية</th>
                    <th>مسودات</th>
                    <th>صفحات مفهرسة</th>
                    <th>Sitemap URLs</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->date->format('Y-m-d') }}</td>
                        <td>{{ $report->posts_published }}</td>
                        <td>{{ $report->programmatic_published }}</td>
                        <td>{{ $report->drafts_count }}</td>
                        <td>{{ $report->indexable_pages_count }}</td>
                        <td>{{ $report->sitemap_urls_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2rem;color:#6b7280;">
                            لا توجد تقارير بعد. شغّل: <code>php artisan seo:daily-report</code>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
