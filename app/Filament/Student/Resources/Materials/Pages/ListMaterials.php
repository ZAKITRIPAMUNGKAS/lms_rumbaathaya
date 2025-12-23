<?php

namespace App\Filament\Student\Resources\Materials\Pages;

use App\Filament\Student\Resources\Materials\MaterialResource;
use Filament\Resources\Pages\ListRecords;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;
}
