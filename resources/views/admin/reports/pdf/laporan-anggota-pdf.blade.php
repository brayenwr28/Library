<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Anggota</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; margin-bottom: 5px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header p { margin: 3px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f0f0f0; padding: 8px; text-align: left; font-size: 11px; border: 1px solid #ddd; font-weight: bold; }
        td { padding: 8px; font-size: 10px; border: 1px solid #ddd; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA ANGGOTA PERPUSTAKAAN</h1>
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
                <th style="width: 20%">Nama Anggota</th>
                <th style="width: 20%">Email</th>
                <th style="width: 15%">No. Identitas</th>
                <th style="width: 12%">Tipe</th>
                <th style="width: 10%">Peminjaman</th>
                <th style="width: 18%">Tgl Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $key => $member)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $member->name }}</td>
                    <td style="font-size: 9px;">{{ $member->email }}</td>
                    <td class="text-center">{{ $member->no_identitas ?? '-' }}</td>
                    <td class="text-center">{{ $member->tipe_member ?? 'Regular' }}</td>
                    <td class="text-center">{{ number_format($member->peminjamans_count ?? 0) }}</td>
                    <td class="text-center">{{ $member->created_at->translatedFormat('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 11px;">
        <p><strong>Statistik Anggota:</strong></p>
        <p style="margin-left: 20px;">
            • Total Anggota: {{ $stats['total'] ?? 0 }}<br>
            • Aktif: {{ $stats['aktif'] ?? 0 }}<br>
            • Nonaktif: {{ $stats['nonaktif'] ?? 0 }}
        </p>
    </div>

    <div style="position: absolute; bottom: 20px; right: 30px; font-size: 10px;">
        <p>Dicetak oleh: Sistem Perpustakaan Digital</p>
    </div>
</body>
</html>
