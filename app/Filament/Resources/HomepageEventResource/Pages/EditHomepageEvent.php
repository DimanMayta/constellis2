<?php
namespace App\Filament\Resources\HomepageEventResource\Pages;
use App\Filament\Resources\HomepageEventResource;
use Filament\Resources\Pages\EditRecord;

class EditHomepageEvent extends EditRecord
{
    protected static string $resource = HomepageEventResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
