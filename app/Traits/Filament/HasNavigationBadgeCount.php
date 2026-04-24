<?php

namespace App\Traits\Filament;

use Illuminate\Support\Facades\Cache;

trait HasNavigationBadgeCount
{
    public static function getNavigationBadge(): ?string
    {
        return Cache::rememberForever(static::getNavigationBadgeCacheKey(), function () {
            return static::getModel()::count();
        });
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = Cache::get(static::getNavigationBadgeCacheKey());

        return match (true) {
            $count <= 50   => 'success',
            $count <= 100  => 'info',
            $count <= 200  => 'warning',
            default => 'danger',
        };
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'The number of ' . static::getModel()::getTableName();
    }

    protected static function getNavigationBadgeCacheKey(): string
    {
        return static::getModel()::getNavBadgeCacheKey();
    }
}
