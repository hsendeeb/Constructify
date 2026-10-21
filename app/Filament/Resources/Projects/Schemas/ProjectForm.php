<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                            Select::make('project_category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('location')
                                ->maxLength(255),
                            TextInput::make('year')
                                ->maxLength(10)
                                ->placeholder('2025'),
                            TextInput::make('sort')
                                ->numeric()
                                ->default(0),
                            Textarea::make('description')
                                ->rows(4)
                                ->columnSpanFull(),
                            FileUpload::make('image')
                                ->image()
                                ->disk('public')
                                ->directory('projects')
                                ->maxSize(6144)
                                ->columnSpanFull(),
                        ]),
                        Grid::make(2)->schema([
                            Toggle::make('is_featured')
                                ->label('Show on the home page')
                                ->default(false),
                            Toggle::make('is_active')
                                ->label('Visible on the website')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }
}
