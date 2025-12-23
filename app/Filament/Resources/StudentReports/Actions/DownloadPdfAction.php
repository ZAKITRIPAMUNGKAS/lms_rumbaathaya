<?php

namespace App\Filament\Resources\StudentReports\Actions;

use App\Models\StudentReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Response;

class DownloadPdfAction
{
    public static function make(): Action
    {
        return Action::make('downloadPdf')
            ->label('Download PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->action(function (StudentReport $record) {
                $record->load(['student.user', 'subject']);
                
                $pdf = Pdf::loadView('pdf.student_report', [
                    'report' => $record,
                ]);

                $studentName = $record->student->name ?? ($record->student->user->name ?? 'Siswa');
                $safeName = preg_replace('/[^A-Za-z0-9_]/', '_', $studentName);
                $safePeriod = preg_replace('/[^A-Za-z0-9_]/', '_', $record->period);
                $filename = 'Laporan_Progress_' . $safeName . '_' . $safePeriod . '.pdf';

                return Response::streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, $filename, [
                    'Content-Type' => 'application/pdf',
                ]);
            });
    }
}

