<?php
namespace App\Filament\Resources\HomepageClientResource\Pages;
use App\Filament\Resources\HomepageClientResource;
use Filament\Resources\Pages\EditRecord;

class EditHomepageClient extends EditRecord
{
    protected static string $resource = HomepageClientResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
