<?php

namespace App\Filament\Resources\Sections\RelationManagers;

use App\Filament\Support\IconOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CountersRelationManager extends RelationManager
{
    protected static string $relationship = 'counters';

    protected static ?string $title = 'About Cards';

    protected static ?string $modelLabel = 'card';

    protected static ?string $pluralModelLabel = 'cards';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->getAttribute('key') === 'about'
            && parent::canViewForRecord($ownerRecord, $pageClass);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('value')
                        ->label('Heading')
                        ->required()
                        ->maxLength(50)
                        ->placeholder('Licensed & Insured')
                        ->helperText('Any text shown as the card heading.'),
                    TextInput::make('label')
                        ->label('Supporting text')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Fully certified with comprehensive coverage.'),
                    Select::make('icon')
                        ->options(IconOptions::heroicons())
                        ->searchable()
                        ->helperText('Icon shown at the top of the card.'),
                    TextInput::make('sort')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first.'),
                    Toggle::make('is_active')
                        ->label('Visible on the website')
                        ->default(true),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('value')
                    ->label('Heading')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('label')
                    ->label('Supporting text')
                    ->searchable(),
                TextColumn::make('icon')
                    ->label('Icon')
                    ->placeholder('Default icon'),
                IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
