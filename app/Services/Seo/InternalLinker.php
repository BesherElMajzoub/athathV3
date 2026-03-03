<?php

namespace App\Services\Seo;

use App\Models\SeoInternalLink;
use Illuminate\Support\Facades\Cache;

class InternalLinker
{
    private const MAX_LINKS = 8;
    private const CACHE_KEY = 'seo:internal_links';
    private const CACHE_TTL = 3600;

    /**
     * Process HTML content and inject internal links.
     * - Avoids linking inside existing <a> tags
     * - Limits to MAX_LINKS per processing
     * - Avoids duplicate target URLs
     * - Prioritizes highest-priority phrases
     */
    public function process(string $html): string
    {
        if (empty(trim($html))) {
            return $html;
        }

        $links = $this->getLinks();

        if ($links->isEmpty()) {
            return $html;
        }

        $insertedLinks = 0;
        $usedTargets   = [];

        foreach ($links as $link) {
            if ($insertedLinks >= self::MAX_LINKS) {
                break;
            }

            // Skip if target already used
            if (in_array($link->target_url, $usedTargets)) {
                continue;
            }

            $phrase = $link->phrase;
            $target = htmlspecialchars($link->target_url, ENT_QUOTES, 'UTF-8');

            // Build regex that avoids replacing inside <a> tags
            // Split HTML into segments: <a ...>...</a> vs everything else
            $html = $this->replaceOutsideAnchors($html, $phrase, $target, $insertedLinks, self::MAX_LINKS);

            if ($insertedLinks < self::MAX_LINKS) {
                // Check if replacement happened by comparing
                $testHtml = preg_replace(
                    '/' . preg_quote($phrase, '/') . '/u',
                    '',
                    $html,
                    1
                );
                if ($testHtml !== $html) {
                    // Nothing to count here, handled inside replaceOutsideAnchors
                }
            }

            $usedTargets[] = $link->target_url;
        }

        return $html;
    }

    private function replaceOutsideAnchors(
        string $html,
        string $phrase,
        string $target,
        int &$insertedLinks,
        int $maxLinks
    ): string {
        // Split around <a...>...</a> blocks
        $parts = preg_split('/(<a\b[^>]*>.*?<\/a>)/is', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

        $result = '';
        foreach ($parts as $i => $part) {
            // Odd parts are <a>...</a> blocks — skip
            if ($i % 2 === 1) {
                $result .= $part;
                continue;
            }

            // Replace only the FIRST occurrence of the phrase in this text segment
            if ($insertedLinks < $maxLinks && mb_stripos($part, $phrase) !== false) {
                $replacement = '<a href="' . $target . '">' . $phrase . '</a>';
                $newPart = preg_replace('/' . preg_quote($phrase, '/') . '/u', $replacement, $part, 1);
                if ($newPart !== $part) {
                    $insertedLinks++;
                    $part = $newPart;
                }
            }

            $result .= $part;
        }

        return $result;
    }

    private function getLinks()
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return SeoInternalLink::where('enabled', true)
                ->orderByDesc('priority')
                ->get(['phrase', 'target_url', 'priority']);
        });
    }

    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
