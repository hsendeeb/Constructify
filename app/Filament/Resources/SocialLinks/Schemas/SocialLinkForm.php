<?php

namespace App\Filament\Resources\SocialLinks\Schemas;

use App\Filament\Support\IconOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Social link')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('platform')
                                ->required()
                                ->maxLength(255),
                            Select::make('icon')
                                ->options(IconOptions::social())
                                ->searchable()
                                ->helperText('Bootstrap Icon shown in the footer.'),
                            TextInput::make('url')
                                ->required()
                                ->maxLength(2048),
                            TextInput::make('sort')
                                ->numeric()
                                ->default(0)
                                ->helperText('Lower numbers appear first.'),
                            Toggle::make('is_active')
                                ->label('Visible in the footer')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }
}
