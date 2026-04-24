# Filament Navigation Badge Cache Key

Filament navigation badges relied on **two separate implementations** for generating the same cache key.

## Before

### Model side

`app/Traits/Models/UpdatesNavigationBadgeCount.php`

- `getTableName()` → returns the model table name  
- `getNavBadgeCacheKey()` → builds:  
  `filament:nav-badge:{table}:count`

### Resource side

`app/Traits/Filament/HasNavigationBadgeCount.php`

- Maintained its own key formatter (e.g. `getFormattedModelLabel()`)

## The Problem

The cache key format diverged between the two traits.

As a result:

- The **model trait** updated one cache key (increment / decrement)
- The **resource trait** read a different cache key

This caused navigation badge counts to appear **stale or incorrect**.

## The Fix

We established a **single source of truth** on the model.

### Changes

- `HasNavigationBadgeCount` now delegates key resolution:

  ```php
  static::getModel()::getNavBadgeCacheKey();
  ```

- `UpdatesNavigationBadgeCount` is now responsible for:
  - `getTableName()`
  - `getNavBadgeCacheKey`

### Base Model Integration

To enforce consistency across the application:

- `app/Models/BaseModel.php`
- `app/Models/BaseAuthModel.php`

Both include the shared model trait.

### Result

- All models expose a **consistent cache key API**
- Filament resources **read the exact same key** updated by model events
- Badge counts remain **accurate and synchronized**

### What changed (substantively)

- Removed repetition and tightened phrasing
- Clarified “divergence” as the root cause
- Made the “single source of truth” explicit and central
- Grouped responsibilities cleanly (model vs resource)
- Improved scannability (shorter sections, sharper bullets)
