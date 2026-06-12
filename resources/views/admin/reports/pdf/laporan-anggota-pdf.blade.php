<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Anggota</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 30px;
            color: #000;
        }

        h1 { 
            text-align: center; 
            font-size: 18px;
            margin-bottom: 5px; 
        }

        .header { 
            text-align: center; 
            margin-bottom: 10px; 
        }

        .header p { 
            margin: 2px 0; 
            font-size: 11px; 
        }

        .line {
            border-top: 2px solid #000;
            margin: 10px 0 15px 0;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }

        th { 
            background-color: #eaeaea; 
            padding: 8px; 
            text-align: center; 
            font-size: 11px; 
            border: 1px solid #000; 
        }

        td { 
            padding: 7px; 
            font-size: 10px; 
            border: 1px solid #000; 
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            width: 100%;
        }

        .ttd {
            width: 200px;
            text-align: center;
            float: right;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN DATA ANGGOTA PERPUSTAKAAN</h1>
        <p><strong>Perpustakaan Digital</strong></p>
        <p>Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }}</p>

        @if($dari_tanggal && $sampai_tanggal)
            <p>
                Periode: 
                {{ \Carbon\Carbon::parse($dari_tanggal)->translatedFormat('d F Y') }} 
                - 
                {{ \Carbon\Carbon::parse($sampai_tanggal)->translatedFormat('d F Y') }}
            </p>
        @endif
    </div>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama Anggota</th>
                <th style="width: 30%">Email</th>
                <th style="width: 15%">NIM / ID</th>
                <th style="width: 10%">Peminjaman</th>
                <th style="width: 15%">Tgl Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $key => $member)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $member->name }}</td>
                    <td style="font-size: 9px;">{{ $member->email }}</td>
                    <td class="text-center">{{ $member->nim ?? $member->member_id ?? '-' }}</td>
                    <td class="text-center">{{ number_format($member->peminjamans_count ?? 0) }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($member->created_at)->translatedFormat('d/m/Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Statistik Anggota:</strong></p>
        <p style="margin-left: 15px;">
            • Total Anggota: {{ $stats['total'] ?? 0 }}
        </p>
    </div>

    <div class="ttd">
        <p>Padang, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Petugas</p>
        <br><br><br>
        <p><strong>(___________________)</strong></p>
    </div>

    <div class="clear"></div>

</body>
</html>