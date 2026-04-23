<?php
namespace App\Filament\Resources\SupportedProjectResource\Pages;
use App\Filament\Resources\SupportedProjectResource;
use Filament\Resources\Pages\ListRecords;
class ListSupportedProjects extends ListRecords
{
    protected static string $resource = SupportedProjectResource::class;
    protected function getHeaderActions(): array
    {
        return [\Filament\Actions\CreateAction::make()];
    }
}
