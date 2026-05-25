<?php

namespace App\Filament\Resources\CurrentProjectResource\Pages;

use App\Filament\Resources\CurrentProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrentProject extends EditRecord
{
    protected static string $resource = CurrentProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
