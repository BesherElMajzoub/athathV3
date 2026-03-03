<?php

namespace App\Services\Seo;

use App\Models\Post;

class SeoContentAnalyzer
{
    private const WORDS_PER_MINUTE = 200;

    /**
     * Full SEO analysis for a Post model.
     * Returns array of checks with 'pass' boolean and 'message'.
     */
    public function analyze(Post $post): array
    {
        $content = strip_tags($post->content ?? '');
        $html    = $post->content ?? '';
        $words   = str_word_count($content);

        return [
            'word_count' => [
                'value'   => $words,
                'pass'    => $words >= 300,
                'message' => $words >= 300
                    ? "عدد الكلمات مقبول ({$words})"
                    : "المحتوى قصير جداً ({$words} كلمة، الحد الأدنى 300)",
            ],
            'has_h2' => [
                'pass'    => $this->hasH2($html),
                'message' => $this->hasH2($html)
                    ? 'يحتوي على عنوان H2'
                    : 'لا يحتوي على عنوان H2 - أضف قسماً فرعياً',
            ],
            'has_h1' => [
                'pass'    => $this->hasH1($html),
                'message' => $this->hasH1($html)
                    ? 'يحتوي على عنوان H1'
                    : 'لا يحتوي على عنوان H1 (يُستحسن إضافته في المحتوى)',
            ],
            'focus_keyword_in_title' => [
                'pass'    => $this->keywordInTitle($post),
                'message' => $this->keywordInTitle($post)
                    ? 'الكلمة المفتاحية موجودة في العنوان'
                    : 'الكلمة المفتاحية غير موجودة في العنوان',
            ],
            'focus_keyword_in_first_100_words' => [
                'pass'    => $this->keywordInFirst100Words($post),
                'message' => $this->keywordInFirst100Words($post)
                    ? 'الكلمة المفتاحية موجودة في أول 100 كلمة'
                    : 'الكلمة المفتاحية غير موجودة في أول 100 كلمة',
            ],
            'focus_keyword_in_h2' => [
                'pass'    => $this->keywordInH2($post, $html),
                'message' => $this->keywordInH2($post, $html)
                    ? 'الكلمة المفتاحية موجودة في H2'
                    : 'الكلمة المفتاحية غير موجودة في أي H2',
            ],
            'focus_keyword_in_meta_description' => [
                'pass'    => $this->keywordInMeta($post),
                'message' => $this->keywordInMeta($post)
                    ? 'الكلمة المفتاحية موجودة في الوصف'
                    : 'الكلمة المفتاحية غير موجودة في الوصف',
            ],
            'meta_title_length' => [
                'value'   => mb_strlen($post->meta_title ?? ''),
                'pass'    => $this->metaTitleOk($post),
                'message' => $this->metaTitleOk($post)
                    ? 'طول عنوان SEO جيد'
                    : 'عنوان SEO فارغ أو أطول من 60 حرف',
            ],
            'meta_description_length' => [
                'value'   => mb_strlen($post->meta_description ?? ''),
                'pass'    => $this->metaDescOk($post),
                'message' => $this->metaDescOk($post)
                    ? 'طول وصف SEO جيد'
                    : 'وصف SEO فارغ أو أطول من 160 حرف',
            ],
        ];
    }

    public function calculateReadingTime(string $content): int
    {
        $words = str_word_count(strip_tags($content));
        return max(1, (int) ceil($words / self::WORDS_PER_MINUTE));
    }

    // ----------------------------------------------------------------
    // Check Helpers
    // ----------------------------------------------------------------

    private function hasH2(string $html): bool
    {
        return (bool) preg_match('/<h2/i', $html);
    }

    private function hasH1(string $html): bool
    {
        return (bool) preg_match('/<h1/i', $html);
    }

    private function keywordInTitle(Post $post): bool
    {
        if (!$post->focus_keyword) return true; // no keyword set, skip check
        return mb_stripos($post->title ?? '', $post->focus_keyword) !== false;
    }

    private function keywordInFirst100Words(Post $post): bool
    {
        if (!$post->focus_keyword) return true;
        $words = explode(' ', strip_tags($post->content ?? ''));
        $first100 = implode(' ', array_slice($words, 0, 100));
        return mb_stripos($first100, $post->focus_keyword) !== false;
    }

    private function keywordInH2(Post $post, string $html): bool
    {
        if (!$post->focus_keyword) return true;
        preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $html, $matches);
        foreach ($matches[1] as $h2) {
            if (mb_stripos(strip_tags($h2), $post->focus_keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function keywordInMeta(Post $post): bool
    {
        if (!$post->focus_keyword || !$post->meta_description) return true;
        return mb_stripos($post->meta_description, $post->focus_keyword) !== false;
    }

    private function metaTitleOk(Post $post): bool
    {
        $len = mb_strlen($post->meta_title ?? '');
        return $len > 0 && $len <= 60;
    }

    private function metaDescOk(Post $post): bool
    {
        $len = mb_strlen($post->meta_description ?? '');
        return $len > 0 && $len <= 160;
    }
}
