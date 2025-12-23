<?php

namespace App\Filament\Tutor\Resources\Materials\Pages;

use App\Filament\Tutor\Resources\Materials\MaterialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMaterials extends ManageRecords
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
