<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoClusterKeyword extends Model
{
    protected $table = 'seo_cluster_keywords';

    protected $fillable = [
        'cluster_id',
        'keyword',
        'search_intent',
        'page_type',
        'target_entity_id',
        'priority',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(SeoKeywordCluster::class, 'cluster_id');
    }
}
