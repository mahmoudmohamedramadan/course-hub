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
    public static function bootUpdatesNavigationBadgeCount()
    {
        static::created(fn() => Cache::increment(static::getNavBadgeCacheKey()));

        static::deleted(fn() => Cache::decrement(static::getNavBadgeCacheKey()));
    }

    /**
     * Get the model's database table name.
     *
     * @return string
     */
    public static function getTableName()
    {
        return resolve(static::class)->getTable();
    }

    /**
     * Get the cache key for the Filament navigation badge count.
     *
     * @return string
     */
    public static function getNavBadgeCacheKey()
    {
        return sprintf('filament:nav-badge:%s:count', static::getTableName());
    }
}
