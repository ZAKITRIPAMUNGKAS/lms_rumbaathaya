<?php

namespace App\Filament\Tutor\Resources\Attendances\Pages;

use App\Filament\Tutor\Resources\Attendances\AttendanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
}
