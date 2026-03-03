<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoReportDaily extends Model
{
    protected $table = 'seo_reports_daily';

    protected $fillable = [
        'date',
        'posts_published',
        'programmatic_published',
        'drafts_count',
        'indexable_pages_count',
        'sitemap_urls_count',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
