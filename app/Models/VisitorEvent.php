<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'session_uuid', 'event_type', 'page_url',
        'ip_hash', 'user_agent', 'referrer',
        'meta_data', 'created_at',
    ];

    protected $casts = [
        'meta_data'  => 'array',
        'created_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(VisitorSession::class, 'session_uuid', 'uuid');
    }
}
