<?php

namespace App\Filament\Resources\Instructors;

use App\Filament\Resources\Instructors\Pages\CreateInstructor;
use App\Filament\Resources\Instructors\Pages\EditInstructor;
use App\Filament\Resources\Instructors\Pages\ListInstructors;
use App\Filament\Resources\Instructors\Schemas\InstructorForm;
use App\Filament\Resources\Instructors\Tables\InstructorsTable;
use App\Models\Instructor;
use App\Traits\Filament\HasNavigationBadgeCount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InstructorResource extends Resource
{
    use HasNavigationBadgeCount;

    protected static ?string $model = Instructor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Briefcase;

    protected static string|UnitEnum|null $navigationGroup = 'Courses';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InstructorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstructorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInstructors::route('/'),
            'create' => CreateInstructor::route('/create'),
            'edit'   => EditInstructor::route('/{record}/edit'),
        ];
    }
}
