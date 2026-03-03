<?php

namespace Tests\Unit;

use App\Services\Seo\InternalLinker;
use App\Models\SeoInternalLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class InternalLinkerTest extends TestCase
{
    use RefreshDatabase;

    private function makeLinker(): InternalLinker
    {
        Cache::forget('seo:internal_links');
        return new InternalLinker();
    }

    public function test_links_are_inserted_for_matching_phrases(): void
    {
        SeoInternalLink::create(['phrase' => 'أثاث مستعمل', 'target_url' => '/buy', 'priority' => 10, 'enabled' => true]);

        $linker = $this->makeLinker();
        $html = '<p>نبيع أثاث مستعمل في جدة بأفضل الأسعار.</p>';
        $result = $linker->process($html);

        $this->assertStringContainsString('<a href="/buy">أثاث مستعمل</a>', $result);
    }

    public function test_existing_anchor_tags_are_not_double_linked(): void
    {
        SeoInternalLink::create(['phrase' => 'أثاث مستعمل', 'target_url' => '/buy', 'priority' => 10, 'enabled' => true]);

        $linker = $this->makeLinker();
        $html = '<p><a href="/existing">أثاث مستعمل</a> في جدة.</p>';
        $result = $linker->process($html);

        // Should not have nested <a> tags
        $this->assertStringNotContainsString('<a href="/buy">أثاث مستعمل</a>', $result);
        $this->assertStringContainsString('<a href="/existing">أثاث مستعمل</a>', $result);
    }

    public function test_max_8_links_enforced(): void
    {
        // Create 15 different phrases
        for ($i = 1; $i <= 15; $i++) {
            SeoInternalLink::create([
                'phrase'     => "عبارة{$i} مستعملة",
                'target_url' => "/page-{$i}",
                'priority'   => $i,
                'enabled'    => true,
            ]);
        }

        $linker = $this->makeLinker();
        $html = '';
        for ($i = 1; $i <= 15; $i++) {
            $html .= "<p>نص يحتوي على عبارة{$i} مستعملة.</p>";
        }

        $result = $linker->process($html);
        $linkCount = substr_count($result, '<a href=');
        $this->assertLessThanOrEqual(8, $linkCount);
    }

    public function test_disabled_links_are_not_inserted(): void
    {
        SeoInternalLink::create(['phrase' => 'شراء أثاث', 'target_url' => '/buy', 'priority' => 10, 'enabled' => false]);

        $linker = $this->makeLinker();
        $html = '<p>شراء أثاث مستعمل في جدة.</p>';
        $result = $linker->process($html);

        $this->assertStringNotContainsString('<a href=', $result);
    }

    public function test_empty_content_is_returned_unchanged(): void
    {
        $linker = $this->makeLinker();
        $result = $linker->process('');
        $this->assertEquals('', $result);
    }
}
