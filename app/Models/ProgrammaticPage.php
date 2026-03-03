<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammaticPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'city',
        'district_id',
        'service_id',
        'primary_keyword',
        'title',
        'meta_title',
        'meta_description',
        'canonical_url',
        'status',
        'indexable',
        'content_blocks',
        'last_generated_at',
    ];

    protected $casts = [
        'indexable'          => 'boolean',
        'content_blocks'     => 'array',
        'last_generated_at'  => 'datetime',
    ];

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeIndexable(Builder $query): Builder
    {
        return $query->where('indexable', true);
    }

    // ----------------------------------------------------------------
    // Helpers
    // ----------------------------------------------------------------

    public function isPubliclyVisible(): bool
    {
        return $this->status === 'published';
    }

    public function getEffectiveCanonical(): string
    {
        return $this->canonical_url ?: url('/p/' . $this->slug);
    }

    public function getWordCount(): int
    {
        $text = '';
        foreach ($this->content_blocks ?? [] as $block) {
            $text .= ' ' . strip_tags($block['content'] ?? '');
        }
        return str_word_count(trim($text));
    }
}
