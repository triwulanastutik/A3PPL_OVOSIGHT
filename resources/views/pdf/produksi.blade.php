<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produksi Telur</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 24px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #16a34a;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #14532d;
            text-transform: uppercase;
        }

        .header p {
            margin: 4px 0 0;
            color: #4b5563;
            font-size: 12px;
        }

        .meta {
            margin-bottom: 16px;
            font-size: 12px;
        }

        .meta table {
            width: 100%;
        }

        .meta td {
            padding: 3px 0;
        }

        .summary {
            width: 100%;
            margin-bottom: 18px;
            border-collapse: collapse;
        }

        .summary td {
            width: 25%;
            padding: 10px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }

        .summary .label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .summary .value {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }

        .summary .green {
            color: #16a34a;
        }

        .summary .red {
            color: #dc2626;
        }

        .summary .blue {
            color: #2563eb;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #14532d;
            margin: 18px 0 8px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table.data th {
            background: #14532d;
            color: white;
            padding: 8px;
            border: 1px solid #14532d;
            font-size: 11px;
            text-align: center;
        }

        table.data td {
            padding: 7px;
            border: 1px solid #d1d5db;
            font-size: 11px;
            text-align: center;
        }

        table.data tr:nth-child(even) {
            background: #f9fafb;
        }

        .status-good {
            color: #16a34a;
            font-weight: bold;
        }

        .status-bad {
            color: #dc2626;
            font-weight: bold;
        }

        .footer {
            margin-top: 24px;
            padding-top: 8px;
            border-top: 1px solid #d1d5db;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }

        .note {
            margin-top: 12px;
            padding: 10px;
            background: #f3f4f6;
            border-left: 4px solid #16a34a;
            font-size: 11px;
            color: #374151;
        }
    </style>
</head>

<body>

@php
    use Carbon\Carbon;

    $periodeMulai = $start ? Carbon::parse($start)->format('d M Y') : 'Awal Data';
    $periodeAkhir = $end ? Carbon::parse($end)->format('d M Y') : 'Akhir Data';

    $rekapHarian = $logs->groupBy(function ($log) {
        return Carbon::parse($log->tanggal)->format('Y-m-d');
    })->map(function ($group, $tanggal) {
        $totalHarian = $group->count();
        $layakHarian = $group->where('status', 'layak')->count();
        $tidakHarian = $group->where('status', 'tidak')->count();

        return [
            'tanggal' => $tanggal,
            'total' => $totalHarian,
            'layak' => $layakHarian,
            'tidak' => $tidakHarian,
            'persentase_layak' => $totalHarian > 0 ? round(($layakHarian / $totalHarian) * 100, 2) : 0,
        ];
    })->values();

    $jumlahHariProduksi = $rekapHarian->count() > 0 ? $rekapHarian->count() : 1;
    $rataHarian = round($total / $jumlahHariProduksi);
@endphp

<div class="header">
    <h1>Laporan Produksi Telur</h1>
    <p>OvoSight - Sistem Monitoring Kualitas dan Produksi Telur</p>
</div>

<div class="meta">
    <table>
        <tr>
            <td><strong>Periode Laporan</strong></td>
            <td>: {{ $periodeMulai }} sampai {{ $periodeAkhir }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Cetak</strong></td>
            <td>: {{ Carbon::now()->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Sumber Data</strong></td>
            <td>: Sensor telur OvoSight</td>
        </tr>
    </table>
</div>

<table class="summary">
    <tr>
        <td>
            <div class="label">Total Produksi</div>
            <div class="value green">{{ number_format($total) }}</div>
            <div class="label">butir telur</div>
        </td>

        <td>
            <div class="label">Telur Layak</div>
            <div class="value blue">{{ number_format($layak) }}</div>
            <div class="label">{{ $persentaseLayak ?? 0 }}% dari total</div>
        </td>

        <td>
            <div class="label">Telur Tidak Layak</div>
            <div class="value red">{{ number_format($tidak) }}</div>
            <div class="label">{{ $persentaseTidak ?? 0 }}% dari total</div>
        </td>

        <td>
            <div class="label">Rata-rata Harian</div>
            <div class="value">{{ number_format($rataHarian) }}</div>
            <div class="label">butir per hari produksi</div>
        </td>
    </tr>
</table>

<div class="section-title">Rekap Produksi Harian</div>

<table class="data">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Total Telur</th>
            <th>Layak</th>
            <th>Tidak Layak</th>
            <th>Persentase Layak</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($rekapHarian as $index => $rekap)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ Carbon::parse($rekap['tanggal'])->format('d M Y') }}</td>
                <td>{{ number_format($rekap['total']) }}</td>
                <td class="status-good">{{ number_format($rekap['layak']) }}</td>
                <td class="status-bad">{{ number_format($rekap['tidak']) }}</td>
                <td>{{ $rekap['persentase_layak'] }}%</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Belum ada data produksi pada periode ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="note">
    Laporan ini menampilkan rekap produksi telur berdasarkan data sensor yang tersimpan pada sistem OvoSight.
    Detail pengecekan berdasarkan kandang atau batch dapat dilihat langsung melalui halaman Produksi pada dashboard aplikasi.
</div>

<div class="footer">
    Dicetak otomatis oleh sistem OvoSight.
</div>

</body>
</html>