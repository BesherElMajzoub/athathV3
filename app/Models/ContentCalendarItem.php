<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentCalendarItem extends Model
{
    protected $fillable = [
        'type',
        'entity_id',
        'scheduled_for',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
    ];

    public function getEntity(): Post|ProgrammaticPage|null
    {
        return match ($this->type) {
            'blog_post'         => Post::find($this->entity_id),
            'programmatic_page' => ProgrammaticPage::find($this->entity_id),
            default             => null,
        };
    }
}
