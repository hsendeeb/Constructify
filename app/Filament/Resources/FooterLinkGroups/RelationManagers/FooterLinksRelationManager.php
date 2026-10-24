<?php

namespace App\Filament\Resources\FooterLinkGroups\RelationManagers;

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

class FooterLinksRelationManager extends RelationManager
{
    protected static string $relationship = 'links';

    protected static ?string $title = 'Links';

    protected static ?string $modelLabel = 'link';

    protected static ?string $pluralModelLabel = 'links';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('label')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('url')
                        ->required()
                        ->maxLength(2048)
                        ->helperText('Use /#section for home page anchors, /projects for the portfolio page, or a full URL.'),
                    Select::make('target')
                        ->options([
                            '_self' => 'Same tab',
                            '_blank' => 'New tab',
                        ])
                        ->default('_self')
                        ->required(),
                    TextInput::make('sort')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first.'),
                    Toggle::make('is_active')
                        ->label('Visible in the footer')
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
                TextColumn::make('label')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('url')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('target')
                    ->badge()
                    ->color('gray'),
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
