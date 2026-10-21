<?php

namespace App\Filament\Resources\Counters\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CountersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('section_key')
                    ->label('Placement')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hero' => 'Hero ribbon',
                        'about' => 'About cards',
                        default => str($state)->headline()->toString(),
                    })
                    ->color('warning'),
                TextColumn::make('value')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('label')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('section_key')
                    ->label('Placement')
                    ->options([
                        'hero' => 'Hero ribbon',
                        'about' => 'About cards',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Visibility'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
