<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostSlug;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    // ----------------------------------------------------------------
    // Blog Index
    // ----------------------------------------------------------------

    public function test_blog_index_only_shows_published_posts(): void
    {
        Post::factory()->published()->create(['title' => 'Published Post']);
        Post::factory()->draft()->create(['title' => 'Draft Post']);
        Post::factory()->scheduledInFuture()->create(['title' => 'Scheduled Future']);

        $response = $this->get('/blog');
        $response->assertStatus(200);
        $response->assertSee('Published Post');
        $response->assertDontSee('Draft Post');
        $response->assertDontSee('Scheduled Future');
    }

    public function test_blog_index_is_paginated(): void
    {
        Post::factory()->published()->count(25)->create();
        $response = $this->get('/blog');
        $response->assertStatus(200);
    }

    // ----------------------------------------------------------------
    // Blog Show: Published
    // ----------------------------------------------------------------

    public function test_published_post_is_accessible(): void
    {
        $post = Post::factory()->published()->create();

        $this->get('/blog/' . $post->slug)->assertStatus(200)->assertSee($post->title);
    }

    // ----------------------------------------------------------------
    // Blog Show: Draft → 404
    // ----------------------------------------------------------------

    public function test_draft_post_returns_404(): void
    {
        $post = Post::factory()->draft()->create();

        $this->get('/blog/' . $post->slug)->assertStatus(404);
    }

    // ----------------------------------------------------------------
    // Blog Show: Scheduled before publish time → 404
    // ----------------------------------------------------------------

    public function test_scheduled_post_hidden_before_publish_time(): void
    {
        $post = Post::factory()->scheduledInFuture()->create();

        $this->get('/blog/' . $post->slug)->assertStatus(404);
    }

    // ----------------------------------------------------------------
    // 301 Redirect: Old slug → new slug
    // ----------------------------------------------------------------

    public function test_old_slug_redirects_to_current_slug(): void
    {
        $post = Post::factory()->published()->create(['slug' => 'new-slug-value']);

        PostSlug::create([
            'post_id'    => $post->id,
            'old_slug'   => 'old-slug-value',
            'created_at' => now(),
        ]);

        $this->get('/blog/old-slug-value')
            ->assertStatus(301)
            ->assertRedirect('/blog/new-slug-value');
    }

    public function test_old_slug_of_draft_post_does_not_redirect(): void
    {
        $post = Post::factory()->draft()->create(['slug' => 'new-draft-slug']);

        PostSlug::create([
            'post_id'    => $post->id,
            'old_slug'   => 'old-draft-slug',
            'created_at' => now(),
        ]);

        // Should 404 since the target is a draft
        $this->get('/blog/old-draft-slug')->assertStatus(404);
    }

    // ----------------------------------------------------------------
    // Admin: Create Draft Post
    // ----------------------------------------------------------------

    public function test_can_create_draft_post_via_admin(): void
    {
        $response = $this->post('/admin/posts', [
            'title'       => 'Test Draft Post',
            'content'     => '<h2>Section</h2><p>' . str_repeat('word ', 100) . '</p>',
            'status'      => 'draft',
            'meta_title'  => 'Test Draft SEO Title',
            'meta_description' => 'Test meta description for the draft post.',
        ]);

        $this->assertDatabaseHas('posts', [
            'title'  => 'Test Draft Post',
            'status' => 'draft',
        ]);
    }

    // ----------------------------------------------------------------
    // Admin: Publish post
    // ----------------------------------------------------------------

    public function test_publish_now_sets_status_and_published_at(): void
    {
        $post = Post::factory()->draft()->create();

        $this->post('/admin/posts/' . $post->id . '/publish-now')
            ->assertRedirect();

        $post->refresh();
        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    // ----------------------------------------------------------------
    // Admin: Slug change stores old slug
    // ----------------------------------------------------------------

    public function test_slug_change_creates_post_slug_record(): void
    {
        $post = Post::factory()->published()->create(['slug' => 'original-slug']);

        $this->put('/admin/posts/' . $post->id, [
            'title'            => $post->title,
            'slug'             => 'updated-new-slug',
            'content'          => '<h2>Section</h2><p>' . str_repeat('word ', 100) . '</p>',
            'status'           => 'published',
            'published_at'     => now()->format('Y-m-d\TH:i'),
            'meta_title'       => 'SEO Title',
            'meta_description' => 'SEO Description here.',
        ])->assertRedirect();

        $this->assertDatabaseHas('post_slugs', [
            'post_id'  => $post->id,
            'old_slug' => 'original-slug',
        ]);
    }

    // ----------------------------------------------------------------
    // Admin: Schedule post
    // ----------------------------------------------------------------

    public function test_scheduling_a_post(): void
    {
        $post = Post::factory()->draft()->create();
        $publishAt = now()->addDays(3)->format('Y-m-d\TH:i');

        $this->post('/admin/posts/' . $post->id . '/schedule', [
            'publish_at' => $publishAt,
        ])->assertRedirect();

        $post->refresh();
        $this->assertEquals('scheduled', $post->status);
    }
}
