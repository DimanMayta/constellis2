<?php
namespace App\Filament\Resources\TrainingCategoryResource\Pages;
use App\Filament\Resources\TrainingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditTrainingCategory extends EditRecord
{
    protected static string $resource = TrainingCategoryResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
