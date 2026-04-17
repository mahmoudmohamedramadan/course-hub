<?php

namespace App\Filament\Resources\Levels;

use App\Filament\Resources\Levels\Pages\CreateLevel;
use App\Filament\Resources\Levels\Pages\EditLevel;
use App\Filament\Resources\Levels\Pages\ListLevels;
use App\Filament\Resources\Levels\Schemas\LevelForm;
use App\Filament\Resources\Levels\Tables\LevelsTable;
use App\Models\Level;
use App\Traits\Filament\HasNavigationBadgeCount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LevelResource extends Resource
{
    use HasNavigationBadgeCount;

    protected static ?string $model = Level::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Square3Stack3d;

    protected static string|UnitEnum|null $navigationGroup = 'Courses';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LevelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LevelsTable::configure($table);
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
            'index'  => ListLevels::route('/'),
            'create' => CreateLevel::route('/create'),
            'edit'   => EditLevel::route('/{record}/edit'),
        ];
    }
}
