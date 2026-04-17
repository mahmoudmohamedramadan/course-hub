<?php

namespace App\Traits\Filament;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait HasNavigationBadgeCount
{
    public static function getNavigationBadge(): ?string
    {
        $key = 'filament:nav-badge:' . static::getFormattedModelLabel() . ':count';

        return Cache::rememberForever($key, function () {
            return static::getModel()::count();
        });
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();

        return match (true) {
            $count <= 50   => 'success',
            $count <= 100  => 'info',
            $count <= 200  => 'warning',
            default => 'danger',
        };
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'The number of ' . static::getFormattedModelLabel();
    }

    protected static function getFormattedModelLabel(): string
    {
        return Str::of(static::getModel())
            ->classBasename()
            ->plural()
            ->lower()
            ->toString();
    }
}
