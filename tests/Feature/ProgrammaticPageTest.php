<?php

namespace Tests\Feature;

use App\Models\ContentCalendarItem;
use App\Models\Post;
use App\Models\ProgrammaticPage;
use App\Console\Commands\PublishDueContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProgrammaticPageTest extends TestCase
{
    use RefreshDatabase;

    // ----------------------------------------------------------------
    // Public Access
    // ----------------------------------------------------------------

    public function test_published_programmatic_page_is_accessible(): void
    {
        ProgrammaticPage::factory()->create([
            'slug'           => 'test-prog-page',
            'status'         => 'published',
            'title'          => 'اشتري أثاث مستعمل جدة',
            'content_blocks' => [
                ['type' => 'intro', 'content' => 'نص تعريفي للصفحة.'],
            ],
        ]);

        $this->get('/p/test-prog-page')
            ->assertStatus(200)
            ->assertSee('اشتري أثاث مستعمل جدة');
    }

    public function test_draft_programmatic_page_returns_404(): void
    {
        ProgrammaticPage::factory()->create([
            'slug'   => 'draft-prog-page',
            'status' => 'draft',
        ]);

        $this->get('/p/draft-prog-page')->assertStatus(404);
    }

    // ----------------------------------------------------------------
    // Content Publish Command
    // ----------------------------------------------------------------

    public function test_publish_due_command_publishes_due_blog_post(): void
    {
        $post = Post::factory()->draft()->create();

        ContentCalendarItem::create([
            'type'          => 'blog_post',
            'entity_id'     => $post->id,
            'scheduled_for' => Carbon::now()->subMinutes(5),
            'status'        => 'pending',
        ]);

        Artisan::call('content:publish-due');

        $post->refresh();
        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);

        $this->assertDatabaseHas('content_calendar_items', [
            'entity_id' => $post->id,
            'status'    => 'published',
        ]);
    }

    public function test_publish_due_command_publishes_due_programmatic_page(): void
    {
        $page = ProgrammaticPage::factory()->create(['status' => 'draft']);

        ContentCalendarItem::create([
            'type'          => 'programmatic_page',
            'entity_id'     => $page->id,
            'scheduled_for' => Carbon::now()->subMinutes(1),
            'status'        => 'pending',
        ]);

        Artisan::call('content:publish-due');

        $page->refresh();
        $this->assertEquals('published', $page->status);
    }

    public function test_publish_due_does_not_publish_future_items(): void
    {
        $post = Post::factory()->draft()->create();

        ContentCalendarItem::create([
            'type'          => 'blog_post',
            'entity_id'     => $post->id,
            'scheduled_for' => Carbon::now()->addHours(2),
            'status'        => 'pending',
        ]);

        Artisan::call('content:publish-due');

        $post->refresh();
        $this->assertEquals('draft', $post->status);
    }

    // ----------------------------------------------------------------
    // Thin Content Guardrail
    // ----------------------------------------------------------------

    public function test_thin_content_prevents_publishing_programmatic_page(): void
    {
        $page = ProgrammaticPage::factory()->create([
            'status'         => 'draft',
            'content_blocks' => [['type' => 'intro', 'content' => 'قصير جداً.']], // thin
            'meta_title'     => 'Valid SEO Title Here',
            'meta_description' => 'Valid meta description text here.',
            'primary_keyword' => 'أثاث مستعمل',
        ]);

        $this->post("/admin/programmatic/{$page->id}/publish")
            ->assertRedirect(); // Should redirect back with errors

        $page->refresh();
        $this->assertEquals('draft', $page->status); // Still draft
    }

    // ----------------------------------------------------------------
    // Sitemap includes published indexable programmatic pages
    // ----------------------------------------------------------------

    public function test_sitemap_includes_published_indexable_programmatic_pages(): void
    {
        \Illuminate\Support\Facades\Cache::forget('sitemap:programmatic');

        ProgrammaticPage::factory()->create([
            'slug'      => 'sitemap-prog-test',
            'status'    => 'published',
            'indexable' => true,
        ]);

        $this->get('/sitemaps/programmatic.xml')
            ->assertStatus(200)
            ->assertSee('sitemap-prog-test');
    }
}
