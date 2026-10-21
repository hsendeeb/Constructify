<?php

namespace App\Filament\Resources\NavigationLinks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NavigationLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Navigation link')
                    ->schema([
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
                                ->label('Visible in the header and footer')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }
}
