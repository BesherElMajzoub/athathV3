<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoKeywordCluster extends Model
{
    protected $table = 'seo_keyword_clusters';

    protected $fillable = [
        'cluster_name',
        'primary_keyword',
        'language',
    ];

    public function keywords(): HasMany
    {
        return $this->hasMany(SeoClusterKeyword::class, 'cluster_id');
    }
}
