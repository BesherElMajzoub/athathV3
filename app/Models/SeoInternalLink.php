<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoInternalLink extends Model
{
    protected $fillable = [
        'phrase',
        'target_url',
        'priority',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true)->orderByDesc('priority');
    }
}
