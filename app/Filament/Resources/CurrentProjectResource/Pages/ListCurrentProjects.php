<?php

namespace App\Filament\Resources\CurrentProjectResource\Pages;

use App\Filament\Resources\CurrentProjectResource;
use Filament\Resources\Pages\ListRecords;

class ListCurrentProjects extends ListRecords
{
    protected static string $resource = CurrentProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
