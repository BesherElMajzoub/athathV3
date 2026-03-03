<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'status',
        'published_at',
        'canonical_url',
        'meta_title',
        'meta_description',
        'focus_keyword',
        'schema_type',
        'schema_faq',
        'reading_time',
        'author_name',
        'enable_auto_internal_links',
    ];

    protected $casts = [
        'published_at'               => 'datetime',
        'schema_faq'                 => 'array',
        'enable_auto_internal_links' => 'boolean',
    ];

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PostCategory::class, 'post_post_category');
    }

    public function slugs(): HasMany
    {
        return $this->hasMany(PostSlug::class);
    }

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', Carbon::now());
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', 'scheduled')
                     ->where('published_at', '>', Carbon::now());
    }

    // ----------------------------------------------------------------
    // Helpers
    // ----------------------------------------------------------------

    public function isPubliclyVisible(): bool
    {
        return $this->status === 'published'
            && $this->published_at !== null
            && $this->published_at->lte(Carbon::now());
    }

    public function getEffectiveMetaTitle(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getEffectiveCanonical(): string
    {
        return $this->canonical_url ?: url('/blog/' . $this->slug);
    }
}
