<?php

namespace App\Traits\Models;

use Illuminate\Support\Facades\Cache;

trait UpdatesNavigationBadgeCount
{
    /**
     * Bootstrap the trait.
     *
     * @return void
     */
    public static function bootUpdatesNavigationBadgeCount(): void
    {
        static::created(function ($model) {
            Cache::increment($model->getNavigationBadgeCacheKey());
        });

        static::deleted(function ($model) {
            Cache::decrement($model->getNavigationBadgeCacheKey());
        });
    }

    /**
     * Get the cache key for the navigation badge count.
     *
     * @return string
     */
    protected function getNavigationBadgeCacheKey(): string
    {
        return sprintf('filament:nav-badge:%s:count', $this->getTable());
    }
}
