<?php
namespace App\Filament\Resources\HomepageEventResource\Pages;
use App\Filament\Resources\HomepageEventResource;
use Filament\Resources\Pages\ListRecords;
class ListHomepageEvents extends ListRecords
{
    protected static string $resource = HomepageEventResource::class;
    protected function getHeaderActions(): array
    {
        return [\Filament\Actions\CreateAction::make()];
    }
}
