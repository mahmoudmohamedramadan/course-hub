# Filament Navigation Badge Counts

Sidebar resources can show a **numeric badge** next to the nav label (total rows for that resource).

## `HasNavigationBadgeCount` (Filament resources)

**File:** `app/Traits/Filament/HasNavigationBadgeCount.php`

Used on **`Resource`** classes (for example `CategoryResource`). It implements:

* **getNavigationBadge()** — returns a string count from **Cache::rememberForever()**. The cache key is the string `filament:nav-badge:` plus the plural lowercased model class basename (for example `courses`) plus `:count`.
* **getNavigationBadgeColor()** — not read from that cache; it runs a fresh **Model::count()** and maps the result to Filament colors: ≤50 success, ≤100 info, ≤200 warning, above danger.
* **getNavigationBadgeTooltip()** — short static tooltip for the badge.

## Keeping counts fresh: `UpdatesNavigationBadgeCount` (models)

**File:** `app/Traits/Models/UpdatesNavigationBadgeCount.php`

Used on the **same Eloquent models** those resources represent. On **created** / **deleted**, it **Cache::increment** / **Cache::decrement** using a key built as `filament:nav-badge:` plus **getTable()** plus `:count`.

For Laravel’s default table names, that table segment matches the label segment from the resource trait (for example both use `categories`). If you rename a table or use an irregular plural, ensure both traits still target the **same** cache key or badges will drift.

## Where it is used

**Resources:** `CategoryResource`, `CourseResource`, `LevelResource`, `LessonResource`, `InstructorResource`, `UserResource` — each `use HasNavigationBadgeCount`.

**Models:** `Category`, `Course`, `Level`, `Lesson`, `Instructor`, `User` — each `use UpdatesNavigationBadgeCount`.

To add badges for another resource, reuse both traits (resource + model) or adjust the cache key scheme in one place and mirror it in the other.
