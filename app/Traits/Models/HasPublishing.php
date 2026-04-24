<?php

namespace App\Traits\Models;

trait HasPublishing
{
    /**
     * Scope to get published models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Check if the lesson is published.
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->is_published;
    }
}
