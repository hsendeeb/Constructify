<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Support\IconOptions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            Select::make('icon')
                                ->options(IconOptions::heroicons())
                                ->searchable()
                                ->helperText('Icon shown in the service card.'),
                            Textarea::make('description')
                                ->rows(4)
                                ->columnSpanFull(),
                            FileUpload::make('image')
                                ->image()
                                ->disk('public')
                                ->directory('services')
                                ->maxSize(6144)
                                ->helperText('Optional image for the service card.')
                                ->columnSpanFull(),
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
