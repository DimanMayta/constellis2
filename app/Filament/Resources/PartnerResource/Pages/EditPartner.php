<?php
namespace App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource;
use Filament\Resources\Pages\EditRecord;
class EditPartner extends EditRecord
{
    protected static string $resource = PartnerResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
