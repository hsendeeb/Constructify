<?php

namespace App\Filament\Resources\FooterLinkGroups;

use App\Filament\Resources\FooterLinkGroups\Pages\CreateFooterLinkGroup;
use App\Filament\Resources\FooterLinkGroups\Pages\EditFooterLinkGroup;
use App\Filament\Resources\FooterLinkGroups\Pages\ListFooterLinkGroups;
use App\Filament\Resources\FooterLinkGroups\RelationManagers\FooterLinksRelationManager;
use App\Filament\Resources\FooterLinkGroups\Schemas\FooterLinkGroupForm;
use App\Filament\Resources\FooterLinkGroups\Tables\FooterLinkGroupsTable;
use App\Models\FooterLinkGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FooterLinkGroupResource extends Resource
{
    protected static ?string $model = FooterLinkGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?string $navigationLabel = 'Footer Links';

    protected static ?string $modelLabel = 'Footer Collection';

    protected static ?string $pluralModelLabel = 'Footer Collections';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return FooterLinkGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FooterLinkGroupsTable::configure($table);
    }

    /**
     * @return array<class-string>
     */
    public static function getRelations(): array
    {
        return [
            FooterLinksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFooterLinkGroups::route('/'),
            'create' => CreateFooterLinkGroup::route('/create'),
            'edit' => EditFooterLinkGroup::route('/{record}/edit'),
        ];
    }
}
