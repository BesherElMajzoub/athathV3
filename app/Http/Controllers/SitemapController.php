<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ProgrammaticPage;
use App\Models\ServicePage;
use App\Models\DistrictPage;
use App\Models\StaticPage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    private const CACHE_TTL = 86400; // 24 hours (cache is invalidated on events)

    // ----------------------------------------------------------------
    // Sitemap Index
    // ----------------------------------------------------------------

    public function index(): Response
    {
        $content = Cache::remember('sitemap:index', self::CACHE_TTL, function () {
            
            // For sitemap index lastmod, we take the max of what's inside
            $pagesLastmod = StaticPage::max('updated_at') ?? '2025-01-01T00:00:00+00:00';
            $servicesLastmod = ServicePage::where('is_published', true)->max('updated_at') ?? '2025-01-01T00:00:00+00:00';
            $districtsLastmod = DistrictPage::where('is_published', true)->max('updated_at') ?? '2025-01-01T00:00:00+00:00';
            $programmaticLastmod = ProgrammaticPage::published()->indexable()->max('updated_at') ?? '2025-01-01T00:00:00+00:00';
            
            $sitemaps = [
                ['url' => url('/sitemaps/pages.xml'), 'lastmod' => $this->formatDate($pagesLastmod)],
                ['url' => url('/sitemaps/services.xml'), 'lastmod' => $this->formatDate($servicesLastmod)],
                ['url' => url('/sitemaps/districts.xml'), 'lastmod' => $this->formatDate($districtsLastmod)],
                ['url' => url('/sitemaps/programmatic.xml'), 'lastmod' => $this->formatDate($programmaticLastmod)],
                ['url' => url('/sitemaps/blog.xml'), 'lastmod' => $this->latestPostUpdate()],
            ];
            
            return view('sitemaps.index', compact('sitemaps'))->render();
        });

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Pages Sitemap (static pages)
    // ----------------------------------------------------------------

    public function pages(): Response
    {
        $content = Cache::remember('sitemap:pages', self::CACHE_TTL, function () {
            $urls = [];
            $pages = StaticPage::select('slug', 'updated_at')->get();

            // Default fallback if no StaticPage records exist
            if ($pages->isEmpty()) {
                $urls[] = [
                    'loc' => url('/'),
                    'lastmod' => '2025-01-01T00:00:00+00:00',
                    'changefreq' => 'monthly',
                    'priority' => '1.0',
                ];
            } else {
                foreach ($pages as $page) {
                    $urls[] = [
                        'loc' => $page->slug === 'home' ? url('/') : url('/' . $page->slug),
                        'lastmod' => $this->formatDate($page->updated_at),
                        'changefreq' => 'monthly',
                        'priority' => $page->slug === 'home' ? '1.0' : '0.8',
                    ];
                }
            }
            
            // Add blog landing page manually with last mod from posts
            $urls[] = [
                'loc' => url('/blog'),
                'lastmod' => $this->latestPostUpdate(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];

            return view('sitemaps.urlset', compact('urls'))->render();
        });

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Services Sitemap
    // ----------------------------------------------------------------

    public function services(): Response
    {
        $content = Cache::remember('sitemap:services', self::CACHE_TTL, function () {
            $services = ServicePage::where('is_published', true)->select('slug', 'updated_at')->get();
            $urls = $services->map(fn($srv) => [
                'loc' => url('/services/' . $srv->slug),
                'lastmod' => $this->formatDate($srv->updated_at),
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ])->toArray();
            return view('sitemaps.urlset', compact('urls'))->render();
        });

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Districts Sitemap
    // ----------------------------------------------------------------

    public function districts(): Response
    {
        $content = Cache::remember('sitemap:districts', self::CACHE_TTL, function () {
            $districts = DistrictPage::where('is_published', true)->select('slug', 'updated_at')->get();
            $urls = $districts->map(fn($dst) => [
                'loc' => url('/districts/' . $dst->slug),
                'lastmod' => $this->formatDate($dst->updated_at),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ])->toArray();
            return view('sitemaps.urlset', compact('urls'))->render();
        });

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Blog Sitemap
    // ----------------------------------------------------------------

    public function blog(): Response
    {
        $content = Cache::remember('sitemap:blog', self::CACHE_TTL, function () {
            // Chunking for performance if many posts
            $urls = [];
            Post::published()->select('id', 'slug', 'updated_at', 'published_at')
                ->orderByDesc('published_at')
                ->chunk(500, function ($posts) use (&$urls) {
                    foreach ($posts as $post) {
                        // Max of updated_at and published_at
                        $lastmod = max($post->updated_at, $post->published_at);
                        $urls[] = [
                            'loc' => url('/blog/' . $post->slug),
                            'lastmod' => $this->formatDate($lastmod),
                            'changefreq' => 'weekly',
                            'priority' => '0.8',
                        ];
                    }
                });

            return view('sitemaps.urlset', compact('urls'))->render();
        });

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Programmatic Pages Sitemap
    // ----------------------------------------------------------------

    public function programmatic(): Response
    {
        $content = Cache::remember('sitemap:programmatic', self::CACHE_TTL, function () {
            $urls = [];
            ProgrammaticPage::published()->indexable()
                ->select('id', 'slug', 'updated_at')
                ->chunk(500, function ($pages) use (&$urls) {
                    foreach ($pages as $page) {
                        $urls[] = [
                            'loc' => url('/p/' . $page->slug),
                            'lastmod' => $this->formatDate($page->updated_at),
                            'changefreq' => 'monthly',
                            'priority' => '0.7',
                        ];
                    }
                });

            return view('sitemaps.urlset', compact('urls'))->render();
        });

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Helpers
    // ----------------------------------------------------------------

    private function xmlResponse(string $content): Response
    {
        return response($content, 200, [
            'Content-Type'  => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=' . self::CACHE_TTL,
        ]);
    }

    private function latestPostUpdate(): string
    {
        // strictly max(updated_at, published_at) where published
        $latest = Post::published()
            ->selectRaw('GREATEST(updated_at, published_at) as last_activity_at')
            ->orderByDesc('last_activity_at')
            ->value('last_activity_at');

        return $latest ? $this->formatDate($latest) : '2025-01-01T00:00:00+00:00';
    }

    private function formatDate($date)
    {
        if (!$date) {
            return '2025-01-01T00:00:00+00:00';
        }
        
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        return $date->toAtomString();
    }
}
