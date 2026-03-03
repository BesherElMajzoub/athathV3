<?php

namespace App\Services\Seo;

use App\Models\Post;
use App\Models\ProgrammaticPage;

class SeoGuardrails
{
    private const MIN_WORD_COUNT = 300;

    /**
     * Validate a Post for publishing.
     * Returns array of error messages. Empty = safe to publish.
     */
    public function checkPost(Post $post): array
    {
        $errors = [];
        $content = strip_tags($post->content ?? '');
        $wordCount = str_word_count($content);

        if ($wordCount < self::MIN_WORD_COUNT) {
            $errors[] = "المحتوى قصير جداً ({$wordCount} كلمة). الحد الأدنى " . self::MIN_WORD_COUNT . " كلمة.";
        }

        if (!preg_match('/<h2/i', $post->content ?? '')) {
            $errors[] = 'يجب أن يحتوي المقال على عنوان فرعي H2 على الأقل.';
        }

        if (empty($post->meta_title)) {
            $errors[] = 'عنوان SEO (meta_title) مطلوب قبل النشر.';
        }

        if (empty($post->meta_description)) {
            $errors[] = 'وصف SEO (meta_description) مطلوب قبل النشر.';
        }

        if (empty($post->focus_keyword)) {
            $errors[] = 'الكلمة المفتاحية (focus_keyword) مطلوبة.';
        }

        return $errors;
    }

    /**
     * Validate a ProgrammaticPage for publishing.
     */
    public function checkProgrammaticPage(ProgrammaticPage $page): array
    {
        $errors = [];

        // Word count from content blocks
        $text = '';
        foreach ($page->content_blocks ?? [] as $block) {
            $text .= ' ' . strip_tags($block['content'] ?? '');
            foreach ($block['items'] ?? [] as $item) {
                if (is_string($item)) {
                    $text .= ' ' . $item;
                } elseif (is_array($item)) {
                    $text .= ' ' . ($item['question'] ?? '') . ' ' . ($item['answer'] ?? '');
                }
            }
        }

        $wordCount = str_word_count(trim($text));
        if ($wordCount < self::MIN_WORD_COUNT) {
            $errors[] = "المحتوى قصير جداً ({$wordCount} كلمة). الحد الأدنى " . self::MIN_WORD_COUNT . " كلمة.";
        }

        if (empty($page->meta_title)) {
            $errors[] = 'عنوان SEO (meta_title) مطلوب.';
        }

        if (empty($page->meta_description)) {
            $errors[] = 'وصف SEO (meta_description) مطلوب.';
        }

        if (empty($page->primary_keyword)) {
            $errors[] = 'الكلمة المفتاحية الأساسية مطلوبة.';
        }

        // Check for duplicate meta titles
        $duplicate = ProgrammaticPage::where('meta_title', $page->meta_title)
            ->where('id', '!=', $page->id)
            ->exists();

        if ($duplicate) {
            $errors[] = 'عنوان SEO مكرر مع صفحة أخرى. يرجى تغييره.';
        }

        return $errors;
    }
}
