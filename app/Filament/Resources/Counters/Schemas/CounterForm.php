<?php

namespace App\Filament\Resources\Counters\Schemas;

use App\Filament\Support\IconOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CounterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Counter')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('section_key')
                                ->label('Where it appears')
                                ->options([
                                    'hero' => 'Hero ribbon (home page)',
                                    'about' => 'About statistics cards',
                                ])
                                ->required()
                                ->default('hero'),
                            TextInput::make('value')
                                ->required()
                                ->maxLength(50)
                                ->placeholder('850+'),
                            TextInput::make('label')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Projects Completed'),
                            Select::make('icon')
                                ->options(IconOptions::heroicons())
                                ->searchable()
                                ->helperText('Used by the about statistics cards.'),
                            TextInput::make('sort')
                                ->numeric()
                                ->default(0)
                                ->helperText('Lower numbers appear first.'),
                            Toggle::make('is_active')
                                ->label('Visible on the website')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }
}
