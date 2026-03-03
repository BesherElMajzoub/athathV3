<?php

namespace Database\Factories;

use App\Models\ProgrammaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProgrammaticPageFactory extends Factory
{
    protected $model = ProgrammaticPage::class;

    public function definition(): array
    {
        $keyword = $this->faker->words(3, true);

        return [
            'slug'             => Str::slug($keyword) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'city'             => 'جدة',
            'district_id'      => null,
            'service_id'       => null,
            'primary_keyword'  => $keyword,
            'title'            => 'خدمة ' . $keyword . ' في جدة',
            'meta_title'       => Str::limit('خدمة ' . $keyword . ' في جدة', 55),
            'meta_description' => $this->faker->text(130),
            'canonical_url'    => null,
            'status'           => 'draft',
            'indexable'        => true,
            'content_blocks'   => [
                [
                    'type'    => 'intro',
                    'content' => $this->faker->paragraph(5),
                ],
                [
                    'type'  => 'selling_points',
                    'items' => [
                        'خدمة احترافية بأفضل الأسعار',
                        'فريق متخصص وذو خبرة',
                        'سرعة في التنفيذ',
                    ],
                ],
                [
                    'type'  => 'faq',
                    'items' => [
                        ['question' => 'كيف يمكنني الاستفادة؟', 'answer' => 'تواصل معنا مباشرة.'],
                    ],
                ],
                [
                    'type'    => 'cta',
                    'content' => 'تواصل معنا الآن للحصول على أفضل عرض!',
                ],
            ],
            'last_generated_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn() => ['status' => 'published']);
    }

    public function draft(): static
    {
        return $this->state(fn() => ['status' => 'draft']);
    }

    public function noindex(): static
    {
        return $this->state(fn() => ['indexable' => false]);
    }
}
