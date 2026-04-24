<?php

namespace App\Filament\Resources\Lessons\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $query
                    ->select(['id', 'course', 'title', 'slug', 'is_published', 'sort_order', 'created_at', 'updated_at'])
                    ->with([
                        'course:id,title'
                    ]);
            })
            ->columns([
                TextColumn::make('course.title')
                    ->label('Course Title')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records, Action $action) {
                            $shouldHalt = false;

                            foreach ($records as $record) {
                                $hasActiveCourses = $record->where(function ($query) {
                                    $query
                                        ->published()
                                        ->orWhereHas('course', fn($query) => $query->published())
                                        ->orWhereHas('course.students');
                                })->exists();

                                if ($hasActiveCourses) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Lesson cannot be deleted')
                                        ->body("'{$record->title}' has active courses.")
                                        ->send();

                                    $shouldHalt = true;

                                    break;
                                }
                            }

                            if ($shouldHalt) {
                                $action->halt();
                            }
                        }),
                ]),
            ]);
    }
}
