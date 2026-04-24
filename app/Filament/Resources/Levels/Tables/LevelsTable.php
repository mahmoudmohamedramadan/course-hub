<?php

namespace App\Filament\Resources\Levels\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LevelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $query->select(['id', 'name', 'slug', 'created_at', 'updated_at']);
            })
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('slug')
                    ->searchable()
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
                                $hasActiveCourses = $record->courses()->where(function ($query) {
                                    $query
                                        ->published()
                                        ->orHas('students')
                                        ->orWhereHas('lessons', fn($query) => $query->published());
                                })->exists();

                                if ($hasActiveCourses) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Level cannot be deleted')
                                        ->body("'{$record->name}' has active courses.")
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
