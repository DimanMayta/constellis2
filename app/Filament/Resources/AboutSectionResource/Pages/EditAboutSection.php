<?php
namespace App\Filament\Resources\AboutSectionResource\Pages;
use App\Filament\Resources\AboutSectionResource;
use Filament\Resources\Pages\EditRecord;

class EditAboutSection extends EditRecord
{
    protected static string $resource = AboutSectionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
