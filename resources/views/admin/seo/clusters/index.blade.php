@extends('admin.layouts.app')
@section('title', 'مجموعات الكلمات المفتاحية')
@section('page-title', 'مجموعات الكلمات المفتاحية')

@section('topbar-actions')
    <a href="{{ route('admin.seo.clusters.create') }}" class="btn btn-primary">+ مجموعة جديدة</a>
@endsection

@section('content')
    <div class="card" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>اسم المجموعة</th>
                    <th>الكلمة الرئيسية</th>
                    <th>اللغة</th>
                    <th>الكلمات</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clusters as $cluster)
                    <tr>
                        <td><strong>{{ $cluster->cluster_name }}</strong></td>
                        <td>{{ $cluster->primary_keyword }}</td>
                        <td>{{ $cluster->language }}</td>
                        <td>{{ $cluster->keywords_count }}</td>
                        <td>
                            <div style="display:flex;gap:0.5rem;">
                                <a href="{{ route('admin.seo.clusters.edit', $cluster) }}" class="btn btn-secondary"
                                    style="padding:0.3rem 0.7rem;">تعديل</a>
                                <form method="POST" action="{{ route('admin.seo.clusters.destroy', $cluster) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" style="padding:0.3rem 0.7rem;"
                                        onclick="return confirm('حذف المجموعة؟')">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:#6b7280;">لا توجد مجموعات بعد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($clusters->hasPages())
            <div style="padding:1rem 1.5rem;">{{ $clusters->links() }}</div>
        @endif
    </div>
@endsection
