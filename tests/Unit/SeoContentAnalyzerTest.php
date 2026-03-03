<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Services\Seo\SeoContentAnalyzer;
use Tests\TestCase;

class SeoContentAnalyzerTest extends TestCase
{
    private SeoContentAnalyzer $analyzer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->analyzer = new SeoContentAnalyzer();
    }

    public function test_reading_time_calculation(): void
    {
        // 200 words ≈ 1 minute
        $content = '<p>' . str_repeat('word ', 200) . '</p>';
        $time = $this->analyzer->calculateReadingTime($content);
        $this->assertEquals(1, $time);

        // 400 words ≈ 2 minutes
        $content = '<p>' . str_repeat('word ', 400) . '</p>';
        $time = $this->analyzer->calculateReadingTime($content);
        $this->assertEquals(2, $time);
    }

    public function test_h2_presence_check(): void
    {
        $post = new Post([
            'title'            => 'Test Post',
            'content'          => '<h2>Section</h2><p>Content.</p>',
            'focus_keyword'    => null,
            'meta_title'       => 'SEO Title within 60',
            'meta_description' => 'Good description within 160 chars.',
        ]);

        $checks = $this->analyzer->analyze($post);
        $this->assertTrue($checks['has_h2']['pass']);
    }

    public function test_no_h2_fails_check(): void
    {
        $post = new Post([
            'title'   => 'Test Post',
            'content' => '<p>Only paragraphs, no h2 heading.</p>',
        ]);

        $checks = $this->analyzer->analyze($post);
        $this->assertFalse($checks['has_h2']['pass']);
    }

    public function test_focus_keyword_in_title_check(): void
    {
        $post = new Post([
            'title'         => 'شراء أثاث مستعمل في جدة',
            'focus_keyword' => 'أثاث مستعمل',
            'content'       => '<h2>Section</h2><p>Content.</p>',
        ]);

        $checks = $this->analyzer->analyze($post);
        $this->assertTrue($checks['focus_keyword_in_title']['pass']);
    }

    public function test_focus_keyword_missing_from_title_fails(): void
    {
        $post = new Post([
            'title'         => 'مقال عام بدون كلمة مفتاحية',
            'focus_keyword' => 'أثاث مستعمل',
            'content'       => '<h2>Section</h2><p>Content.</p>',
        ]);

        $checks = $this->analyzer->analyze($post);
        $this->assertFalse($checks['focus_keyword_in_title']['pass']);
    }

    public function test_word_count_below_300_fails(): void
    {
        $post = new Post([
            'content' => '<p>قصير جداً.</p>',
        ]);

        $checks = $this->analyzer->analyze($post);
        $this->assertFalse($checks['word_count']['pass']);
    }

    public function test_meta_title_over_60_chars_fails(): void
    {
        $post = new Post([
            'content'    => '<h2>S</h2><p>' . str_repeat('word ', 50) . '</p>',
            'meta_title' => str_repeat('a', 65), // 65 chars
        ]);

        $checks = $this->analyzer->analyze($post);
        $this->assertFalse($checks['meta_title_length']['pass']);
    }
}
