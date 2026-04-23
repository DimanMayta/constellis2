<?php

namespace App\Filament\Resources\PositionCategoryResource\Pages;

use App\Filament\Resources\PositionCategoryResource;
use Filament\Resources\Pages\ListRecords;

class ListPositionCategories extends ListRecords
{
    protected static string $resource = PositionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
