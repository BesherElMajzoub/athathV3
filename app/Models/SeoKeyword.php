<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoKeyword extends Model
{
    protected $fillable = [
        'keyword',
        'intent',
        'page_type',
        'target_slug',
        'synonyms',
    ];

    protected $casts = [
        'synonyms' => 'array',
    ];
}
