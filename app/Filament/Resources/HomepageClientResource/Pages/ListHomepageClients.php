<?php
namespace App\Filament\Resources\HomepageClientResource\Pages;
use App\Filament\Resources\HomepageClientResource;
use Filament\Resources\Pages\ListRecords;
class ListHomepageClients extends ListRecords
{
    protected static string $resource = HomepageClientResource::class;
    protected function getHeaderActions(): array
    {
        return [\Filament\Actions\CreateAction::make()];
    }
}
