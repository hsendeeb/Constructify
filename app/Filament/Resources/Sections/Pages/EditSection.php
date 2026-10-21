<?php

namespace App\Filament\Resources\Sections\Pages;

use App\Filament\Resources\Sections\SectionResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditSection extends EditRecord
{
    protected static string $resource = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewSite')
                ->label('View website')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url('/')
                ->openUrlInNewTab(),
        ];
    }
}
