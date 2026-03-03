<?php

namespace App\Observers;

use App\Models\ProgrammaticPage;
use Illuminate\Support\Facades\Cache;

class ProgrammaticPageObserver
{
    public function created(ProgrammaticPage $page): void
    {
        $this->flushCaches();
    }

    public function updated(ProgrammaticPage $page): void
    {
        $this->flushCaches();
    }

    public function deleted(ProgrammaticPage $page): void
    {
        $this->flushCaches();
    }

    private function flushCaches(): void
    {
        Cache::forget('sitemap:programmatic');
        Cache::forget('sitemap:index');
    }
}
