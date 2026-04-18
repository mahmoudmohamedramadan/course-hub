<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->getRecord()->loadMissing([
            'enrolledCourses' => fn($query) => $query->orderBy('title'),
            'lessonProgress'  => fn($query) => $query
                ->with(['lesson.course'])
                ->orderByDesc('completed_at'),
        ]);
    }
}
