<?php

namespace App\Filament\Resources\StudentReports\Pages;

use App\Filament\Resources\StudentReports\StudentReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStudentReports extends ManageRecords
{
    protected static string $resource = StudentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

