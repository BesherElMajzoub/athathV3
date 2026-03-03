<?php

namespace App\Services\Seo;

use App\Models\Post;
use App\Models\ProgrammaticPage;

class SchemaBuilder
{
    // ----------------------------------------------------------------
    // Blog Post Schema
    // ----------------------------------------------------------------

    public function forPost(Post $post): string
    {
        $schema = match ($post->schema_type) {
            'FAQPage'     => $this->faqPage($post),
            'BlogPosting' => $this->blogPosting($post),
            'NewsArticle' => $this->newsArticle($post),
            default       => $this->article($post),
        };

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    // ----------------------------------------------------------------
    // Programmatic Page Schema
    // ----------------------------------------------------------------

    public function forProgrammaticPage(ProgrammaticPage $page): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebPage',
            'name'     => $page->title,
            'description' => $page->meta_description,
            'url'      => $page->getEffectiveCanonical(),
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    // ----------------------------------------------------------------
    // Breadcrumb Schema
    // ----------------------------------------------------------------

    public function breadcrumb(array $items): string
    {
        $listItems = [];
        foreach ($items as $i => $item) {
            $listItems[] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $item['name'],
                'item'     => $item['url'],
            ];
        }

        $schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    // ----------------------------------------------------------------
    // LocalBusiness Schema (site-wide)
    // ----------------------------------------------------------------

    public function localBusiness(): string
    {
        $schema = [
            '@context'      => 'https://schema.org',
            '@type'         => 'LocalBusiness',
            'name'          => config('app.name'),
            'url'           => url('/'),
            'telephone'     => config('seo.phone', ''),
            'address'       => [
                '@type'           => 'PostalAddress',
                'addressLocality' => 'جدة',
                'addressCountry'  => 'SA',
            ],
            'areaServed'    => 'جدة',
            'priceRange'    => '$$',
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    // ----------------------------------------------------------------
    // Private: Article types
    // ----------------------------------------------------------------

    private function article(Post $post): array
    {
        return $this->baseArticle($post, 'Article');
    }

    private function blogPosting(Post $post): array
    {
        return $this->baseArticle($post, 'BlogPosting');
    }

    private function newsArticle(Post $post): array
    {
        return $this->baseArticle($post, 'NewsArticle');
    }

    private function baseArticle(Post $post, string $type): array
    {
        return [
            '@context'         => 'https://schema.org',
            '@type'            => $type,
            'headline'         => $post->getEffectiveMetaTitle(),
            'description'      => $post->meta_description,
            'url'              => $post->getEffectiveCanonical(),
            'datePublished'    => $post->published_at?->toIso8601String(),
            'dateModified'     => $post->updated_at?->toIso8601String(),
            'author'           => [
                '@type' => 'Person',
                'name'  => $post->author_name ?: config('app.name'),
            ],
            'image'            => $post->featured_image
                ? asset('storage/' . $post->featured_image)
                : null,
        ];
    }

    private function faqPage(Post $post): array
    {
        $faqItems = [];
        foreach ($post->schema_faq ?? [] as $item) {
            if (!empty($item['question']) && !empty($item['answer'])) {
                $faqItems[] = [
                    '@type'          => 'Question',
                    'name'           => $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $item['answer'],
                    ],
                ];
            }
        }

        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $faqItems,
        ];
    }
}
