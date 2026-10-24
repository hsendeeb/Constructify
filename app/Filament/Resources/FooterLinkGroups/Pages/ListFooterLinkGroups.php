<?php

namespace App\Filament\Resources\FooterLinkGroups\Pages;

use App\Filament\Resources\FooterLinkGroups\FooterLinkGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFooterLinkGroups extends ListRecords
{
    protected static string $resource = FooterLinkGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
