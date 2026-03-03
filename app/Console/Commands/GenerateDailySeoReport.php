<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\ProgrammaticPage;
use App\Models\SeoReportDaily;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateDailySeoReport extends Command
{
    protected $signature   = 'seo:daily-report';
    protected $description = 'Generate a daily SEO report and store it in seo_reports_daily.';

    public function handle(): int
    {
        $today = Carbon::today()->toDateString();

        $data = [
            'date'                    => $today,
            'posts_published'         => Post::where('status', 'published')->count(),
            'programmatic_published'  => ProgrammaticPage::where('status', 'published')->count(),
            'drafts_count'            => Post::where('status', 'draft')->count()
                                        + ProgrammaticPage::where('status', 'draft')->count(),
            'indexable_pages_count'   => Post::where('status', 'published')->count()
                                        + ProgrammaticPage::published()->indexable()->count(),
            'sitemap_urls_count'      => Post::published()->count()
                                        + ProgrammaticPage::published()->indexable()->count()
                                        + 3, // static pages
        ];

        SeoReportDaily::updateOrCreate(['date' => $today], $data);

        $this->info('Daily SEO report generated for ' . $today);
        $this->table(
            ['Metric', 'Value'],
            collect($data)->except('date')->map(fn($v, $k) => [$k, $v])->values()->toArray()
        );

        return Command::SUCCESS;
    }
}
