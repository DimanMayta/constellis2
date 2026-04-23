<?php
namespace App\Filament\Resources\SupportedProjectResource\Pages;
use App\Filament\Resources\SupportedProjectResource;
use Filament\Resources\Pages\EditRecord;

class EditSupportedProject extends EditRecord
{
    protected static string $resource = SupportedProjectResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
