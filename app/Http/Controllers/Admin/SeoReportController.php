<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoReportDaily;
use Illuminate\View\View;

class SeoReportController extends Controller
{
    public function index(): View
    {
        $reports = SeoReportDaily::orderByDesc('date')->limit(30)->get();

        // Calculate trends
        $latest = $reports->first();
        $previous = $reports->skip(1)->first();

        $trends = [];
        if ($latest && $previous) {
            $trends['posts_published']       = $latest->posts_published - $previous->posts_published;
            $trends['programmatic_published'] = $latest->programmatic_published - $previous->programmatic_published;
            $trends['indexable_pages_count']  = $latest->indexable_pages_count - $previous->indexable_pages_count;
        }

        return view('admin.seo.reports.index', compact('reports', 'latest', 'trends'));
    }
}
