<?php

namespace App\Filament\Resources\FooterLinkGroups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FooterLinkGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Footer collection')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->helperText('Heading shown above this column of links, e.g. "Quick Links".'),
                            TextInput::make('sort')
                                ->numeric()
                                ->default(0)
                                ->helperText('Lower numbers appear further left in the footer.'),
                            Toggle::make('is_active')
                                ->label('Visible in the footer')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }
}
