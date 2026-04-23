<?php
namespace App\Filament\Resources\ContactOfficeResource\Pages;
use App\Filament\Resources\ContactOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactOffice extends EditRecord
{
    protected static string $resource = ContactOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
