<?php

namespace App\Services\Seo;

use App\Models\ProgrammaticPage;
use App\Models\SeoTemplate;

class ProgrammaticPageGenerator
{
    private const MIN_WORD_COUNT = 400;

    /**
     * Build content_blocks array for a programmatic page.
     * Returns structured blocks: intro, selling_points, faq, cta
     */
    public function buildContentBlocks(array $data): array
    {
        $placeholders = $this->buildPlaceholders($data);

        $blocks = [];

        // 1. Intro block
        $intro = SeoTemplate::findByKey('programmatic_intro', 'ar');
        $blocks[] = [
            'type'    => 'intro',
            'content' => $intro
                ? $intro->render($placeholders)
                : $this->defaultIntro($placeholders),
        ];

        // 2. Selling points block
        $sellingPoints = SeoTemplate::findByKey('selling_points', 'ar');
        $blocks[] = [
            'type'   => 'selling_points',
            'items'  => $sellingPoints
                ? explode("\n", $sellingPoints->render($placeholders))
                : $this->defaultSellingPoints($placeholders),
        ];

        // 3. FAQ block
        $faqTemplate = SeoTemplate::findByKey('programmatic_faq', 'ar');
        $blocks[] = [
            'type'  => 'faq',
            'items' => $faqTemplate
                ? $this->parseFaqTemplate($faqTemplate->render($placeholders))
                : $this->defaultFaq($placeholders),
        ];

        // 4. CTA block
        $ctaTemplate = SeoTemplate::findByKey('cta', 'ar');
        $blocks[] = [
            'type'    => 'cta',
            'content' => $ctaTemplate
                ? $ctaTemplate->render($placeholders)
                : $this->defaultCta($placeholders),
        ];

        return $blocks;
    }

    /**
     * Get total word count from content_blocks array.
     */
    public function getTotalWordCount(array $blocks): int
    {
        $text = '';
        foreach ($blocks as $block) {
            $text .= ' ' . strip_tags($block['content'] ?? '');
            if (isset($block['items'])) {
                foreach ($block['items'] as $item) {
                    if (is_string($item)) {
                        $text .= ' ' . $item;
                    } elseif (is_array($item)) {
                        $text .= ' ' . ($item['question'] ?? '') . ' ' . ($item['answer'] ?? '');
                    }
                }
            }
        }
        return str_word_count(trim($text));
    }

    public function meetsMinimumWordCount(array $blocks): bool
    {
        return $this->getTotalWordCount($blocks) >= self::MIN_WORD_COUNT;
    }

    /**
     * Validate uniqueness of meta_title and meta_description.
     */
    public function checkUniqueness(string $metaTitle, string $metaDescription, ?int $ignoreId = null): array
    {
        $errors = [];

        $titleQuery = ProgrammaticPage::where('meta_title', $metaTitle);
        if ($ignoreId) $titleQuery->where('id', '!=', $ignoreId);
        if ($titleQuery->exists()) {
            $errors[] = 'meta_title مكرر مع صفحة أخرى';
        }

        $descQuery = ProgrammaticPage::where('meta_description', $metaDescription);
        if ($ignoreId) $descQuery->where('id', '!=', $ignoreId);
        if ($descQuery->exists()) {
            $errors[] = 'meta_description مكرر مع صفحة أخرى';
        }

        return $errors;
    }

    // ----------------------------------------------------------------
    // Private Helpers
    // ----------------------------------------------------------------

    private function buildPlaceholders(array $data): array
    {
        return [
            'city'     => $data['city'] ?? 'جدة',
            'district' => $data['district'] ?? '',
            'service'  => $data['service'] ?? '',
            'keyword'  => $data['primary_keyword'] ?? '',
            'brand'    => config('app.name', 'أثاث'),
            'year'     => now()->year,
        ];
    }

    private function defaultIntro(array $p): string
    {
        return "هل تبحث عن {$p['keyword']} في {$p['city']}؟ نحن في {$p['brand']} نوفر لك أفضل الخدمات "
            . "بأسعار مناسبة وجودة عالية. نخدم جميع أحياء {$p['city']} ونضمن لك تجربة مريحة وآمنة. "
            . "تواصل معنا اليوم للحصول على أفضل عرض في {$p['year']}.";
    }

    private function defaultSellingPoints(array $p): array
    {
        return [
            "خدمة {$p['keyword']} باحترافية عالية في {$p['city']}",
            'أسعار تنافسية مع ضمان الجودة',
            'فريق متخصص وذو خبرة',
            'تقييم مجاني قبل الشراء',
            'خدمة سريعة في نفس اليوم',
        ];
    }

    private function defaultFaq(array $p): array
    {
        return [
            [
                'question' => "كيف يمكنني الاستفادة من خدمة {$p['keyword']}؟",
                'answer'   => "يمكنك التواصل معنا مباشرة عبر الهاتف أو الواتساب وسنصلك في {$p['city']} خلال وقت قصير.",
            ],
            [
                'question' => "ما هي المناطق التي تغطيها خدماتكم في {$p['city']}؟",
                'answer'   => "نغطي جميع أحياء {$p['city']} ونوفر خدماتنا في معظم مناطق المملكة العربية السعودية.",
            ],
            [
                'question' => "هل تقدمون تقييماً مجانياً للأثاث المستعمل؟",
                'answer'   => "نعم، نوفر تقييماً مجانياً وشاملاً قبل أي عملية شراء.",
            ],
        ];
    }

    private function defaultCta(array $p): string
    {
        return "تواصل مع {$p['brand']} الآن للحصول على أفضل سعر لـ {$p['keyword']} في {$p['city']}. "
            . "اتصل بنا أو أرسل واتساب وسنرد عليك فوراً!";
    }

    private function parseFaqTemplate(string $text): array
    {
        // Expected format: Q: question\nA: answer\n\n
        $faqs = [];
        $blocks = array_filter(explode("\n\n", $text));
        foreach ($blocks as $block) {
            $lines = array_values(array_filter(explode("\n", $block)));
            if (count($lines) >= 2) {
                $faqs[] = [
                    'question' => preg_replace('/^Q:\s*/i', '', $lines[0]),
                    'answer'   => preg_replace('/^A:\s*/i', '', $lines[1]),
                ];
            }
        }
        return $faqs;
    }
}
