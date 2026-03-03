<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'title'                      => $title,
            'slug'                       => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'excerpt'                    => $this->faker->paragraph(),
            'content'                    => '<h2>' . $this->faker->sentence(4) . '</h2><p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            'featured_image'             => null,
            'featured_image_alt'         => null,
            'status'                     => 'draft',
            'published_at'               => null,
            'canonical_url'              => null,
            'meta_title'                 => Str::limit($title, 55),
            'meta_description'           => $this->faker->text(140),
            'focus_keyword'              => $this->faker->words(3, true),
            'schema_type'                => 'Article',
            'schema_faq'                 => null,
            'reading_time'               => $this->faker->numberBetween(2, 10),
            'author_name'                => $this->faker->name(),
            'enable_auto_internal_links' => true,
        ];
    }

    public function published(): static
    {
        return $this->state(fn() => [
            'status'       => 'published',
            'published_at' => Carbon::now()->subHours(rand(1, 72)),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn() => [
            'status'       => 'draft',
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn() => [
            'status'       => 'scheduled',
            'published_at' => Carbon::now()->addDays(rand(1, 7)),
        ]);
    }

    public function scheduledInFuture(?Carbon $at = null): static
    {
        return $this->state(fn() => [
            'status'       => 'scheduled',
            'published_at' => $at ?? Carbon::now()->addHours(2),
        ]);
    }
}
