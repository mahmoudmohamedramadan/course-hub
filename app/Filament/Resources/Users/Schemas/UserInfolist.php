<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Course;
use App\Models\User;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->label('Email address'),
                        TextEntry::make('email_verified_at')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('—'),
                    ])
                    ->columnSpan(1),

                Section::make('Enrolled courses')
                    ->description('Published lesson completion for each enrolled course.')
                    ->schema([
                        RepeatableEntry::make('enrolledCourses')
                            ->hiddenLabel()
                            ->placeholder('Not enrolled in any courses yet.')
                            ->table([
                                TableColumn::make('Course'),
                                TableColumn::make('Enrolled at'),
                                TableColumn::make('Progress (published lessons)'),
                            ])
                            ->schema([
                                TextEntry::make('title')
                                    ->hiddenLabel(),
                                TextEntry::make('pivot.created_at')
                                    ->hiddenLabel()
                                    ->dateTime()
                                    ->placeholder('—'),
                                TextEntry::make('lesson_progress_summary')
                                    ->hiddenLabel()
                                    ->getStateUsing(function (TextEntry $component): string {
                                        $course = $component->getContainer()->getRecord();

                                        if (! $course instanceof Course) {
                                            return '—';
                                        }

                                        $livewire = $component->getLivewire();
                                        $user     = $livewire->getRecord();

                                        if (! $user instanceof User) {
                                            return '—';
                                        }

                                        return $user->publishedLessonProgressLabelForCourse($course);
                                    }),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Lesson progress')
                    ->description('Completed lessons (newest first).')
                    ->schema([
                        RepeatableEntry::make('lessonProgress')
                            ->hiddenLabel()
                            ->placeholder('No completed lessons yet.')
                            ->table([
                                TableColumn::make('Course'),
                                TableColumn::make('Lesson'),
                                TableColumn::make('Completed at'),
                            ])
                            ->schema([
                                TextEntry::make('lesson.course.title')
                                    ->hiddenLabel()
                                    ->placeholder('—'),
                                TextEntry::make('lesson.title')
                                    ->hiddenLabel()
                                    ->placeholder('—'),
                                TextEntry::make('completed_at')
                                    ->hiddenLabel()
                                    ->dateTime()
                                    ->placeholder('—'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
