<?php
namespace App\Filament\Resources\PositionCategoryResource\Pages;
use App\Filament\Resources\PositionCategoryResource;
use Filament\Resources\Pages\EditRecord;

class EditPositionCategory extends EditRecord
{
    protected static string $resource = PositionCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
