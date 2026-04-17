<?php

namespace App\Filament\Resources\Instructors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InstructorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('title'),
                Textarea::make('bio')
                    ->columnSpanFull(),
                TextInput::make('linkedin_url')
                    ->activeUrl(),
                TextInput::make('avatar_url')
                    ->activeUrl(),
            ]);
    }
}
