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
        try {
            $content = Cache::remember('sitemap:index', self::CACHE_TTL, function () {
                $sitemaps = [];

                // Pages — always present (has at least home page)
                $pagesLastmod = StaticPage::max('updated_at') ?? now();
                $sitemaps[] = [
                    'url'     => url('/sitemaps/pages.xml'),
                    'lastmod' => $this->formatDate($pagesLastmod),
                ];

                // Services — only if there are published services
                $servicesCount = ServicePage::where('is_published', true)->count();
                if ($servicesCount > 0) {
                    $servicesLastmod = ServicePage::where('is_published', true)->max('updated_at');
                    $sitemaps[] = [
                        'url'     => url('/sitemaps/services.xml'),
                        'lastmod' => $this->formatDate($servicesLastmod),
                    ];
                }

                // Districts — only if there are published districts
                $districtsCount = DistrictPage::where('is_published', true)->count();
                if ($districtsCount > 0) {
                    $districtsLastmod = DistrictPage::where('is_published', true)->max('updated_at');
                    $sitemaps[] = [
                        'url'     => url('/sitemaps/districts.xml'),
                        'lastmod' => $this->formatDate($districtsLastmod),
                    ];
                }

                // Blog — only if there are published posts
                $blogCount = Post::published()->count();
                if ($blogCount > 0) {
                    $sitemaps[] = [
                        'url'     => url('/sitemaps/blog.xml'),
                        'lastmod' => $this->latestPostUpdate(),
                    ];
                }

                // Programmatic — only if there are published indexable pages
                $programmaticCount = ProgrammaticPage::published()->indexable()->count();
                if ($programmaticCount > 0) {
                    $programmaticLastmod = ProgrammaticPage::published()->indexable()->max('updated_at');
                    $sitemaps[] = [
                        'url'     => url('/sitemaps/programmatic.xml'),
                        'lastmod' => $this->formatDate($programmaticLastmod),
                    ];
                }

                return view('sitemaps.index', compact('sitemaps'))->render();
            });
        } catch (\Throwable $e) {
            // Fallback: build without cache if cache driver fails on server
            $sitemaps = [
                ['url' => url('/sitemaps/pages.xml'), 'lastmod' => $this->formatDate(now())],
                ['url' => url('/sitemaps/blog.xml'), 'lastmod' => $this->formatDate(now())],
            ];
            $content = view('sitemaps.index', compact('sitemaps'))->render();
        }

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Pages Sitemap (static pages + listing pages)
    // ----------------------------------------------------------------

    public function pages(): Response
    {
        try {
            $content = Cache::remember('sitemap:pages', self::CACHE_TTL, function () {
                $urls = [];
                $pages = StaticPage::select('slug', 'updated_at')->get();

                // Default fallback if no StaticPage records exist
                if ($pages->isEmpty()) {
                    $urls[] = [
                        'loc'        => url('/'),
                        'lastmod'    => $this->formatDate(now()),
                        'changefreq' => 'weekly',
                        'priority'   => '1.0',
                    ];
                } else {
                    foreach ($pages as $page) {
                        $urls[] = [
                            'loc'        => $page->slug === 'home' ? url('/') : url('/' . $page->slug),
                            'lastmod'    => $this->formatDate($page->updated_at),
                            'changefreq' => $page->slug === 'home' ? 'weekly' : 'monthly',
                            'priority'   => $page->slug === 'home' ? '1.0' : '0.8',
                        ];
                    }
                }

                // Services listing page
                if (ServicePage::where('is_published', true)->exists()) {
                    $urls[] = [
                        'loc'        => url('/services'),
                        'lastmod'    => $this->formatDate(ServicePage::where('is_published', true)->max('updated_at')),
                        'changefreq' => 'weekly',
                        'priority'   => '0.9',
                    ];
                }

                // Districts listing page
                if (DistrictPage::where('is_published', true)->exists()) {
                    $urls[] = [
                        'loc'        => url('/districts'),
                        'lastmod'    => $this->formatDate(DistrictPage::where('is_published', true)->max('updated_at')),
                        'changefreq' => 'weekly',
                        'priority'   => '0.8',
                    ];
                }

                // Blog landing page
                $urls[] = [
                    'loc'        => url('/blog'),
                    'lastmod'    => $this->latestPostUpdate(),
                    'changefreq' => 'daily',
                    'priority'   => '0.9',
                ];

                // About page
                $urls[] = [
                    'loc'        => url('/about'),
                    'lastmod'    => $this->formatDate(now()->subMonth()),
                    'changefreq' => 'monthly',
                    'priority'   => '0.6',
                ];

                return view('sitemaps.urlset', compact('urls'))->render();
            });
        } catch (\Throwable $e) {
            $urls = [['loc' => url('/'), 'lastmod' => $this->formatDate(now()), 'changefreq' => 'weekly', 'priority' => '1.0']];
            $content = view('sitemaps.urlset', compact('urls'))->render();
        }

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Services Sitemap
    // ----------------------------------------------------------------

    public function services(): Response
    {
        try {
            $content = Cache::remember('sitemap:services', self::CACHE_TTL, function () {
                $services = ServicePage::where('is_published', true)->select('slug', 'updated_at')->get();
                $urls = $services->map(fn($srv) => [
                    'loc'        => url('/services/' . $srv->slug),
                    'lastmod'    => $this->formatDate($srv->updated_at),
                    'changefreq' => 'monthly',
                    'priority'   => '0.9',
                ])->toArray();
                return view('sitemaps.urlset', compact('urls'))->render();
            });
        } catch (\Throwable $e) {
            $urls = [];
            $content = view('sitemaps.urlset', compact('urls'))->render();
        }

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Districts Sitemap
    // ----------------------------------------------------------------

    public function districts(): Response
    {
        try {
            $content = Cache::remember('sitemap:districts', self::CACHE_TTL, function () {
                $districts = DistrictPage::where('is_published', true)->select('slug', 'updated_at')->get();
                $urls = $districts->map(fn($dst) => [
                    'loc'        => url('/districts/' . $dst->slug),
                    'lastmod'    => $this->formatDate($dst->updated_at),
                    'changefreq' => 'monthly',
                    'priority'   => '0.8',
                ])->toArray();
                return view('sitemaps.urlset', compact('urls'))->render();
            });
        } catch (\Throwable $e) {
            $urls = [];
            $content = view('sitemaps.urlset', compact('urls'))->render();
        }

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Blog Sitemap (with image support for Google Image indexing)
    // ----------------------------------------------------------------

    public function blog(): Response
    {
        try {
            $content = Cache::remember('sitemap:blog', self::CACHE_TTL, function () {
                // Chunking for performance if many posts
                $urls = [];
                Post::published()
                    ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'featured_image_alt', 'updated_at', 'published_at')
                    ->orderByDesc('published_at')
                    ->chunk(500, function ($posts) use (&$urls) {
                        foreach ($posts as $post) {
                            // Safe max: handle NULL published_at
                            $publishedAt = $post->published_at ?? $post->updated_at;
                            $lastmod = $post->updated_at > $publishedAt ? $post->updated_at : $publishedAt;

                            $entry = [
                                'loc'        => url('/blog/' . $post->slug),
                                'lastmod'    => $this->formatDate($lastmod),
                                'changefreq' => 'weekly',
                                'priority'   => '0.8',
                            ];

                            // Add featured image for Google Image indexing
                            if ($post->featured_image) {
                                $imageUrl = $this->resolveImageUrl($post->featured_image);
                                $entry['images'] = [
                                    [
                                        'loc'     => $imageUrl,
                                        'title'   => e($post->featured_image_alt ?: $post->title),
                                        'caption' => e($post->excerpt ? \Illuminate\Support\Str::limit(strip_tags($post->excerpt), 200) : $post->title),
                                    ],
                                ];
                            }

                            $urls[] = $entry;
                        }
                    });

                return view('sitemaps.urlset', compact('urls'))->render();
            });
        } catch (\Throwable $e) {
            $urls = [];
            $content = view('sitemaps.urlset', compact('urls'))->render();
        }

        return $this->xmlResponse($content);
    }

    // ----------------------------------------------------------------
    // Programmatic Pages Sitemap
    // ----------------------------------------------------------------

    public function programmatic(): Response
    {
        try {
            $content = Cache::remember('sitemap:programmatic', self::CACHE_TTL, function () {
                $urls = [];
                ProgrammaticPage::published()->indexable()
                    ->select('id', 'slug', 'updated_at')
                    ->chunk(500, function ($pages) use (&$urls) {
                        foreach ($pages as $page) {
                            $urls[] = [
                                'loc'        => url('/p/' . $page->slug),
                                'lastmod'    => $this->formatDate($page->updated_at),
                                'changefreq' => 'monthly',
                                'priority'   => '0.7',
                            ];
                        }
                    });

                return view('sitemaps.urlset', compact('urls'))->render();
            });
        } catch (\Throwable $e) {
            $urls = [];
            $content = view('sitemaps.urlset', compact('urls'))->render();
        }

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
            'X-Robots-Tag'  => 'noindex',
        ]);
    }

    private function latestPostUpdate(): string
    {
        try {
            // Use COALESCE to handle NULL published_at before GREATEST
            $latest = Post::published()
                ->selectRaw('GREATEST(updated_at, COALESCE(published_at, updated_at)) as last_activity_at')
                ->orderByDesc('last_activity_at')
                ->value('last_activity_at');

            return $latest ? $this->formatDate($latest) : $this->formatDate(now());
        } catch (\Throwable $e) {
            return $this->formatDate(now());
        }
    }

    private function formatDate($date): string
    {
        if (!$date) {
            return now()->toAtomString();
        }

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->toAtomString();
    }

    /**
     * Convert a stored image path to a fully qualified URL.
     * Handles both relative paths (storage/...) and absolute URLs.
     */
    private function resolveImageUrl(string $path): string
    {
        // Already a full URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Strip leading slash if present
        $path = ltrim($path, '/');

        // If it starts with 'storage/', use the storage URL helper
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // Fall back to asset helper
        return asset($path);
    }
}
