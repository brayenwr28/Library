<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
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
        <h1>LAPORAN PEMINJAMAN BUKU</h1>
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
                <th style="width: 10%">No. Antrian</th>
                <th style="width: 20%">Nama Member</th>
                <th style="width: 25%">Judul Buku</th>
                <th style="width: 10%">Tgl Pinjam</th>
                <th style="width: 10%">Tgl Kembali</th>
                <th style="width: 20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $key => $peminjaman)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $peminjaman->nomor_antrian }}</td>
                    <td>{{ $peminjaman->member?->name ?? 'N/A' }}</td>
                    <td>{{ $peminjaman->judul_buku }}</td>
                    <td class="text-center">
                        {{ $peminjaman->tgl_pinjam->translatedFormat('d/m/Y') }}
                    </td>
                    <td class="text-center">
                        {{ $peminjaman->tgl_kembali->translatedFormat('d/m/Y') }}
                    </td>
                    <td class="text-center">
                        {{ $peminjaman->statusLabel }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="stats">
        <p><strong>Statistik Peminjaman:</strong></p>
        <p style="margin-left: 15px;">
            • Total Peminjaman: {{ $peminjamans->count() }}
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