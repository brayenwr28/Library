<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengunjung</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; margin-bottom: 5px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header p { margin: 3px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f0f0f0; padding: 8px; text-align: left; font-size: 11px; border: 1px solid #ddd; font-weight: bold; }
        td { padding: 8px; font-size: 10px; border: 1px solid #ddd; }
        .text-center { text-align: center; }
        .stats { margin-top: 20px; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENGUNJUNG PERPUSTAKAAN</h1>
        <p><strong>Perpustakaan Digital</strong></p>
        <p>Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }}</p>
        @if($dari_tanggal && $sampai_tanggal)
            <p>Periode: {{ \Carbon\Carbon::parse($dari_tanggal)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($sampai_tanggal)->translatedFormat('d F Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama</th>
                <th style="width: 15%">NIM/NIDN</th>
                <th style="width: 25%">Tipe Pengunjung</th>
                <th style="width: 30%">Tanggal Kunjung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengunjungs as $key => $pengunjung)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $pengunjung->nama }}</td>
                    <td class="text-center">{{ $pengunjung->nim ?? $pengunjung->nidn ?? '-' }}</td>
                    <td class="text-center">
                        @php
                            $typeLabel = match($pengunjung->tipe_pengunjung) {
                                'mahasiswa' => 'Mahasiswa',
                                'dosen' => 'Dosen',
                                'umum' => 'Umum',
                                default => 'Tidak Diketahui'
                            };
                        @endphp
                        {{ $typeLabel }}
                    </td>
                    <td>{{ $pengunjung->created_at->translatedFormat('d F Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="stats">
        <p><strong>Statistik Pengunjung:</strong></p>
        <p style="margin-left: 20px;">
            • Total Pengunjung: {{ $pengunjungs->count() }}<br>
            • Mahasiswa: {{ $stats['mahasiswa'] ?? 0 }}<br>
            • Dosen: {{ $stats['dosen'] ?? 0 }}<br>
            • Umum: {{ $stats['umum'] ?? 0 }}
        </p>
    </div>

    <div style="position: absolute; bottom: 20px; right: 30px; font-size: 10px;">
        <p>Dicetak oleh: Sistem Perpustakaan Digital</p>
    </div>
</body>
</html>
