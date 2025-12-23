<?php

namespace App\Filament\Student\Resources\Materials\Pages;

use App\Filament\Student\Resources\Materials\MaterialResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewMaterial extends ViewRecord
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download')
                ->label('Download File')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->visible(fn () => !empty($this->record->file_path))
                ->action(function () {
                    if ($this->record->file_path && Storage::disk('public')->exists($this->record->file_path)) {
                        return Storage::disk('public')->download($this->record->file_path);
                    }
                }),
        ];
    }
}
