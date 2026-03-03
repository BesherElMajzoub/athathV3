<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Flush sitemap caches whenever a post is created, updated, or deleted.
     * This ensures the sitemap is always fresh after content changes.
     */
    public function created(Post $post): void
    {
        $this->flushCaches();
    }

    public function updated(Post $post): void
    {
        $this->flushCaches();
    }

    public function deleted(Post $post): void
    {
        $this->flushCaches();
    }

    private function flushCaches(): void
    {
        Cache::forget('sitemap:blog');
        Cache::forget('sitemap:index');
    }
}
