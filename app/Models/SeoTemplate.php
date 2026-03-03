<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTemplate extends Model
{
    protected $table = 'seo_templates';

    protected $fillable = [
        'template_key',
        'language',
        'body',
    ];

    /**
     * Render this template by replacing placeholders with actual values.
     *
     * Supported placeholders: {city}, {district}, {service}, {keyword}, {brand}, {year}
     */
    public function render(array $placeholders): string
    {
        $body = $this->body;
        foreach ($placeholders as $key => $value) {
            $body = str_replace('{' . $key . '}', $value, $body);
        }
        return $body;
    }

    public static function findByKey(string $key, string $language = 'ar'): ?static
    {
        return static::where('template_key', $key)->where('language', $language)->first();
    }
}
