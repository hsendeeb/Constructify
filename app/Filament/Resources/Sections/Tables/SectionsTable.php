<?php

namespace App\Filament\Resources\Sections\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('label')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('key')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn (string $state): string => str($state)->headline()),
                TextColumn::make('title')
                    ->limit(50)
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->since()
                    ->label('Updated'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Visibility')
                    ->placeholder('All sections')
                    ->trueLabel('Visible only')
                    ->falseLabel('Hidden only'),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
