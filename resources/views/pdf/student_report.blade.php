<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Progress Siswa - {{ $report->student->name ?? ($report->student->user->name ?? 'Siswa') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #2563EB;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2563EB;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .student-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        
        .student-info h2 {
            color: #1E293B;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #2563EB;
            padding-bottom: 8px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 11px;
            margin-bottom: 3px;
        }
        
        .info-value {
            color: #1E293B;
            font-size: 13px;
        }
        
        .report-content {
            margin-top: 25px;
        }
        
        .score-section {
            background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 25px;
        }
        
        .score-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
        }
        
        .score-value {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .score-grade {
            font-size: 18px;
            opacity: 0.9;
        }
        
        .details-section {
            margin-top: 25px;
        }
        
        .details-section h3 {
            color: #1E293B;
            font-size: 16px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
        }
        
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .details-table th {
            background: #2563EB;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }
        
        .details-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        .details-table tr:last-child td {
            border-bottom: none;
        }
        
        .notes-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #2563EB;
            margin-top: 20px;
        }
        
        .notes-section h3 {
            color: #1E293B;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .notes-content {
            color: #333;
            font-size: 12px;
            line-height: 1.8;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #10b981;
            color: white;
        }
        
        .badge-warning {
            background: #f59e0b;
            color: white;
        }
        
        .badge-danger {
            background: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BimbelKu</h1>
        <p>Laporan Progress Belajar Siswa</p>
    </div>

    <div class="student-info">
        <h2>Informasi Siswa</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Siswa</span>
                <span class="info-value">{{ $report->student->name ?? ($report->student->user->name ?? 'N/A') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Mata Pelajaran</span>
                <span class="info-value">{{ $report->subject->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Periode</span>
                <span class="info-value">{{ $report->period }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Laporan</span>
                <span class="info-value">{{ $report->report_date->format('d F Y') }}</span>
            </div>
        </div>
    </div>

    <div class="report-content">
        <div class="score-section">
            <div class="score-label">Nilai Akhir</div>
            <div class="score-value">{{ $report->score }}</div>
            <div class="score-grade">
                @if($report->score >= 75)
                    <span class="badge badge-success">Sangat Baik</span>
                @elseif($report->score >= 50)
                    <span class="badge badge-warning">Cukup</span>
                @else
                    <span class="badge badge-danger">Perlu Perbaikan</span>
                @endif
            </div>
        </div>

        <div class="details-section">
            <h3>Detail Laporan</h3>
            <table class="details-table">
                <thead>
                    <tr>
                        <th>Aspek</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Nilai</strong></td>
                        <td>{{ $report->score }} / 100</td>
                    </tr>
                    @if($report->attendance_count)
                    <tr>
                        <td><strong>Jumlah Kehadiran</strong></td>
                        <td>{{ $report->attendance_count }} kali</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Periode</strong></td>
                        <td>{{ $report->period }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Laporan</strong></td>
                        <td>{{ $report->report_date->format('d F Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($report->notes)
        <div class="notes-section">
            <h3>Catatan & Evaluasi</h3>
            <div class="notes-content">
                {!! nl2br(e($report->notes)) !!}
            </div>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem BimbelKu LMS</p>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
    </div>
</body>
</html>

