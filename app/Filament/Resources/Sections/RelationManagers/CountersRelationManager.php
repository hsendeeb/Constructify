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
        return in_array($ownerRecord->getAttribute('key'), ['about', 'contact', 'tracking'], true)
            && parent::canViewForRecord($ownerRecord, $pageClass);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return match ($ownerRecord->getAttribute('key')) {
            'contact' => 'Contact Cards',
            'tracking' => 'Track Record Stats',
            default => 'About Cards',
        };
    }

    public function form(Schema $schema): Schema
    {
        $isContact = $this->isContactSection();
        $isTracking = $this->isTrackingSection();

        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('value')
                        ->label($isContact ? 'Card label' : ($isTracking ? 'Counter value' : 'Heading'))
                        ->required()
                        ->maxLength(50)
                        ->placeholder($isContact ? 'Call us' : ($isTracking ? '850+' : 'Licensed & Insured'))
                        ->helperText($isContact
                            ? 'Small label shown above the contact detail.'
                            : ($isTracking
                                ? 'Number or short value shown prominently on the card.'
                                : 'Any text shown as the card heading.')),
                    TextInput::make('label')
                        ->label($isContact ? 'Contact detail' : ($isTracking ? 'Caption' : 'Supporting text'))
                        ->required()
                        ->maxLength(255)
                        ->placeholder($isContact
                            ? '+1 (555) 234-6789'
                            : ($isTracking ? 'Projects Delivered' : 'Fully certified with comprehensive coverage.')),
                    Select::make('icon')
                        ->options($isContact ? IconOptions::contact() : IconOptions::heroicons())
                        ->searchable()
                        ->helperText($isTracking
                            ? 'Icon shown next to the counter.'
                            : 'Icon shown at the top of the card.'),
                    TextInput::make('link_url')
                        ->label('Link (optional)')
                        ->maxLength(2048)
                        ->visible($isContact)
                        ->helperText('A "tel:" or "mailto:" link, or any URL. Leave empty to show plain text.'),
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
        $isContact = $this->isContactSection();
        $isTracking = $this->isTrackingSection();

        return $table
            ->recordTitleAttribute('label')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('value')
                    ->label($isContact ? 'Card label' : ($isTracking ? 'Counter value' : 'Heading'))
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('label')
                    ->label($isContact ? 'Contact detail' : ($isTracking ? 'Caption' : 'Supporting text'))
                    ->searchable(),
                TextColumn::make('icon')
                    ->label('Icon')
                    ->placeholder('Default icon'),
                TextColumn::make('link_url')
                    ->label('Link')
                    ->placeholder('None')
                    ->visible($isContact),
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

    protected function isContactSection(): bool
    {
        return $this->getOwnerRecord()->getAttribute('key') === 'contact';
    }

    protected function isTrackingSection(): bool
    {
        return $this->getOwnerRecord()->getAttribute('key') === 'tracking';
    }
}
