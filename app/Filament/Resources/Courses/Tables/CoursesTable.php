<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $query
                    ->select([
                        'id',
                        'category_id',
                        'level_id',
                        'instructor_id',
                        'title',
                        'slug',
                        'rating',
                        'target_audience',
                        'is_featured',
                        'created_at',
                        'updated_at'
                    ])
                    ->with([
                        'category:id,name',
                        'level:id,name',
                        'instructor:id,name',
                    ]);
            })
            ->columns([
                TextColumn::make('category.name')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('level.name')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('instructor.name')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('rating')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('target_audience')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->toggleable(),
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
                                $isActiveCourse = $record->where(function ($query) {
                                    $query
                                        ->published()
                                        ->orHas('students');
                                })->exists();

                                if ($isActiveCourse) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Course cannot be deleted')
                                        ->body("'{$record->title}' has active enrolled students.")
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
