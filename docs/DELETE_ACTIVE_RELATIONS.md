# Filament Guarded Deletes

Bulk deletes can break live data (e.g. active courses or enrolled students).
To prevent this, `DeleteBulkAction` uses a **`before()` hook** to validate each selected record.

If a record has **active relations** (published content, enrollments, etc.):

* A danger **notification** is shown
* The action is stopped using **`$action->halt()`**
* Nothing gets deleted

---

## What counts as “active”

* Published courses or lessons
* Courses with enrolled students
* Any related data that shouldn’t be removed

---

## Where it’s implemented

* `CategoriesTable`
* `LevelsTable`
* `CoursesTable`
* `LessonsTable`
* `InstructorsTable`

Path: `app/Filament/Resources/*/Tables/`
