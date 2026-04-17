<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('level_id')
                    ->required()
                    ->numeric(),
                TextInput::make('instructor_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('short_description'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('target_audience'),
                Toggle::make('is_featured')
                    ->label('Featured')
                    ->required(),
                Toggle::make('is_published')
                    ->label('Published')
                    ->required(),
                TextInput::make('thumbnail_url')
                    ->activeUrl(),
                TextInput::make('cover_image_url')
                    ->activeUrl(),
            ]);
    }
}
