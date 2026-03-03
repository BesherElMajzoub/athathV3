<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePage extends Model
{
    protected $fillable = [
        'slug', 'title', 'content', 'meta_title', 'meta_description',
        'canonical_url', 'og_image', 'schema_faq', 'is_published'
    ];

    protected $casts = [
        'schema_faq' => 'array',
        'is_published' => 'boolean',
    ];

    public function getEffectiveCanonical(): string
    {
        return $this->canonical_url ?: url("/services/{$this->slug}");
    }
}
