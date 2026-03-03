<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorSession extends Model
{
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // Using custom first_seen_at / last_seen_at

    protected $fillable = [
        'uuid', 'ip_hash', 'user_agent', 'referrer',
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid',
        'first_seen_at', 'last_seen_at', 'pageviews', 'duration_seconds'
    ];

    protected $casts = [
        'first_seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'pageviews' => 'integer',
        'duration_seconds' => 'integer',
    ];

    public function events()
    {
        return $this->hasMany(VisitorEvent::class, 'session_uuid', 'uuid');
    }
}
