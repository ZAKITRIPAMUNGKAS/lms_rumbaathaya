<?php

namespace App\Filament\Resources\ClassLevels\Pages;

use App\Filament\Resources\ClassLevels\ClassLevelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageClassLevels extends ManageRecords
{
    protected static string $resource = ClassLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

