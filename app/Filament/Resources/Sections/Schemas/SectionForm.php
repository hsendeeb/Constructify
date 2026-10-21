<?php

namespace App\Filament\Resources\Sections\Schemas;

use App\Filament\Support\IconOptions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Section content')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('label')
                                        ->required()
                                        ->maxLength(255)
                                        ->helperText('Internal name shown in the admin panel.'),
                                    TextInput::make('key')
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->helperText('Fixed identifier used by the frontend layout.'),
                                    TextInput::make('eyebrow')
                                        ->maxLength(255)
                                        ->helperText('Small uppercase label above the heading.'),
                                    TextInput::make('title')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('title_highlight')
                                        ->maxLength(255)
                                        ->helperText('Optional word rendered in orange after the title.'),
                                    TextInput::make('image_caption')
                                        ->maxLength(255)
                                        ->helperText('Services: heading overlaid on the visual. About: used as image alt text.'),
                                    TextInput::make('badge_text')
                                        ->maxLength(255)
                                        ->visible(fn (Get $get): bool => in_array($get('key'), ['hero', 'about'], true))
                                        ->helperText('Hero: small pill above the heading. About: circular badge over the image, e.g. "25+ Years of Experience".'),
                                    Select::make('badge_icon')
                                        ->options(IconOptions::heroicons())
                                        ->searchable()
                                        ->visible(fn (Get $get): bool => $get('key') === 'hero')
                                        ->helperText('Icon shown inside the hero badge.'),
                                ]),
                                Textarea::make('subtitle')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Primary image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('sections')
                                    ->maxSize(6144)
                                    ->helperText('About: large image on the left. Services: large visual.'),
                                FileUpload::make('secondary_image')
                                    ->label('Secondary image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('sections')
                                    ->maxSize(6144)
                                    ->visible(fn (Get $get): bool => $get('key') === 'about')
                                    ->helperText('About: smaller image that overlaps the bottom-right of the primary image.'),
                                FileUpload::make('background_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('sections')
                                    ->maxSize(6144)
                                    ->visible(fn (Get $get): bool => $get('key') === 'hero')
                                    ->helperText('Full-width hero background. A navy gradient is used until an image is uploaded.'),
                            ]),
                        Tab::make('Buttons')
                            ->icon('heroicon-o-cursor-arrow-rays')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('primary_button_text')->maxLength(255),
                                    TextInput::make('primary_button_url')
                                        ->maxLength(2048)
                                        ->helperText('A path, anchor (#contact), or full URL.'),
                                    TextInput::make('secondary_button_text')->maxLength(255),
                                    TextInput::make('secondary_button_url')
                                        ->maxLength(2048)
                                        ->helperText('Leave both text and URL empty to hide this button.'),
                                ]),
                            ]),
                        Tab::make('Settings')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Visible on the website')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }
}
