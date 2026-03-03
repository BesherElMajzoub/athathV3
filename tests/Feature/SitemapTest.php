<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\ProgrammaticPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    // ----------------------------------------------------------------
    // Sitemap Index
    // ----------------------------------------------------------------

    public function test_sitemap_index_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $response->assertSee('sitemapindex', false);
    }

    // ----------------------------------------------------------------
    // Blog Sitemap
    // ----------------------------------------------------------------

    public function test_blog_sitemap_includes_published_posts(): void
    {
        $post = Post::factory()->published()->create(['slug' => 'published-test-post']);

        Cache::forget('sitemap:blog');
        $response = $this->get('/sitemaps/blog.xml');
        $response->assertStatus(200);
        $response->assertSee('published-test-post');
    }

    public function test_blog_sitemap_excludes_draft_posts(): void
    {
        $post = Post::factory()->draft()->create(['slug' => 'draft-test-post']);

        Cache::forget('sitemap:blog');
        $response = $this->get('/sitemaps/blog.xml');
        $response->assertStatus(200);
        $response->assertDontSee('draft-test-post');
    }

    public function test_blog_sitemap_excludes_scheduled_future_posts(): void
    {
        $post = Post::factory()->scheduledInFuture()->create(['slug' => 'scheduled-future-post']);

        Cache::forget('sitemap:blog');
        $response = $this->get('/sitemaps/blog.xml');
        $response->assertStatus(200);
        $response->assertDontSee('scheduled-future-post');
    }

    // ----------------------------------------------------------------
    // Programmatic Sitemap
    // ----------------------------------------------------------------

    public function test_programmatic_sitemap_includes_published_indexable_pages(): void
    {
        ProgrammaticPage::factory()->create([
            'slug'      => 'published-indexable-page',
            'status'    => 'published',
            'indexable' => true,
        ]);

        Cache::forget('sitemap:programmatic');
        $response = $this->get('/sitemaps/programmatic.xml');
        $response->assertStatus(200);
        $response->assertSee('published-indexable-page');
    }

    public function test_programmatic_sitemap_excludes_draft_pages(): void
    {
        ProgrammaticPage::factory()->create([
            'slug'      => 'draft-prog-page',
            'status'    => 'draft',
            'indexable' => true,
        ]);

        Cache::forget('sitemap:programmatic');
        $response = $this->get('/sitemaps/programmatic.xml');
        $response->assertStatus(200);
        $response->assertDontSee('draft-prog-page');
    }

    public function test_programmatic_sitemap_excludes_noindex_pages(): void
    {
        ProgrammaticPage::factory()->create([
            'slug'      => 'noindex-prog-page',
            'status'    => 'published',
            'indexable' => false,
        ]);

        Cache::forget('sitemap:programmatic');
        $response = $this->get('/sitemaps/programmatic.xml');
        $response->assertStatus(200);
        $response->assertDontSee('noindex-prog-page');
    }

    // ----------------------------------------------------------------
    // Robots.txt
    // ----------------------------------------------------------------

    public function test_robots_txt_includes_sitemap_directive(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $response->assertSee('Sitemap:');
        $response->assertSee('sitemap.xml');
    }

    public function test_robots_txt_disallows_admin(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertSee('Disallow: /admin');
    }

    // ----------------------------------------------------------------
    // Cache Invalidation
    // ----------------------------------------------------------------

    public function test_post_creation_flushes_sitemap_cache(): void
    {
        Cache::put('sitemap:blog', 'cached_content', 3600);
        Cache::put('sitemap:index', 'cached_content', 3600);

        Post::factory()->create(); // Observer fires

        $this->assertNull(Cache::get('sitemap:blog'));
        $this->assertNull(Cache::get('sitemap:index'));
    }

    public function test_post_update_flushes_sitemap_cache(): void
    {
        $post = Post::factory()->create();
        Cache::put('sitemap:blog', 'cached_content', 3600);

        $post->update(['title' => 'Updated Title']);

        $this->assertNull(Cache::get('sitemap:blog'));
    }

    public function test_programmatic_page_creation_flushes_cache(): void
    {
        Cache::put('sitemap:programmatic', 'cached_content', 3600);
        Cache::put('sitemap:index', 'cached_content', 3600);

        ProgrammaticPage::factory()->create();

        $this->assertNull(Cache::get('sitemap:programmatic'));
        $this->assertNull(Cache::get('sitemap:index'));
    }
}
