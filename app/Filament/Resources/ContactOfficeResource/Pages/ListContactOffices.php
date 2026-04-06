<?php
namespace App\Filament\Resources\ContactOfficeResource\Pages;
use App\Filament\Resources\ContactOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListContactOffices extends ListRecords
{
    protected static string $resource = ContactOfficeResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
