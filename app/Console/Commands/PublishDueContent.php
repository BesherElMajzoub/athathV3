<?php

namespace App\Console\Commands;

use App\Models\ContentCalendarItem;
use App\Models\Post;
use App\Models\ProgrammaticPage;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class PublishDueContent extends Command
{
    protected $signature   = 'content:publish-due';
    protected $description = 'Publish all content calendar items that are due.';

    public function handle(): int
    {
        $dueItems = ContentCalendarItem::where('status', 'pending')
            ->where('scheduled_for', '<=', Carbon::now())
            ->get();

        if ($dueItems->isEmpty()) {
            $this->info('No items due for publishing.');
            return Command::SUCCESS;
        }

        $published = 0;
        $failed    = 0;

        foreach ($dueItems as $item) {
            try {
                $this->publishItem($item);
                $item->update(['status' => 'published']);
                $published++;
                $this->info("Published {$item->type} ID={$item->entity_id}");
            } catch (\Throwable $e) {
                $failed++;
                $this->error("Failed to publish {$item->type} ID={$item->entity_id}: {$e->getMessage()}");
            }
        }

        // Flush caches after bulk publish
        Cache::forget('sitemap:blog');
        Cache::forget('sitemap:programmatic');
        Cache::forget('sitemap:index');

        $this->info("Done. Published: {$published}, Failed: {$failed}.");

        return Command::SUCCESS;
    }

    private function publishItem(ContentCalendarItem $item): void
    {
        if ($item->type === 'blog_post') {
            $post = Post::findOrFail($item->entity_id);
            $post->update([
                'status'       => 'published',
                'published_at' => $item->scheduled_for,
            ]);
        } elseif ($item->type === 'programmatic_page') {
            $page = ProgrammaticPage::findOrFail($item->entity_id);
            $page->update(['status' => 'published']);
        }
    }
}
