<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengunjung</title>
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

        .stats {
            margin-top: 25px;
            font-size: 11px;
        }

        .ttd {
            width: 200px;
            text-align: center;
            float: right;
            margin-top: 40px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN PENGUNJUNG PERPUSTAKAAN</h1>
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
                <th style="width: 25%">Nama</th>
                <th style="width: 15%">NIM/NIDN</th>
                <th style="width: 20%">Tipe Pengunjung</th>
                <th style="width: 35%">Tanggal Kunjung</th>
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
                    <td class="text-center">
                        {{ $pengunjung->created_at->translatedFormat('d F Y H:i') }}
                    </td>
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
        <p style="margin-left: 15px;">
            • Total Pengunjung: {{ $pengunjungs->count() }} <br>
            • Mahasiswa: {{ $stats['mahasiswa'] ?? 0 }} <br>
            • Dosen: {{ $stats['dosen'] ?? 0 }} <br>
            • Umum: {{ $stats['umum'] ?? 0 }}
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