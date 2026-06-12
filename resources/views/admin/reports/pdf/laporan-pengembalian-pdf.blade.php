<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
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

        tfoot td {
            background-color: #f2f2f2;
            font-weight: bold;
        }

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
        <h1>LAPORAN PENGEMBALIAN BUKU</h1>
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
                <th style="width: 20%">Judul Buku</th>
                <th style="width: 10%">Kondisi</th>
                <th style="width: 12%">Denda</th>
                <th style="width: 13%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengembalians as $key => $pengembalian)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $pengembalian->peminjaman?->nomor_antrian }}</td>
                    <td>{{ $pengembalian->peminjaman?->member?->name ?? '-' }}</td>
                    <td>{{ $pengembalian->peminjaman?->judul_buku ?? '-' }}</td>
                    <td class="text-center">
                        @php
                            $kondisiLabel = match($pengembalian->kondisi_buku) {
                                'baik' => 'Baik',
                                'rusak_ringan' => 'Rusak Ringan',
                                'rusak_berat' => 'Rusak Berat',
                                default => 'Tidak Diketahui'
                            };
                        @endphp
                        {{ $kondisiLabel }}
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($pengembalian->denda ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        {{ ucfirst(str_replace('_', ' ', $pengembalian->status)) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5" class="text-right" style="border-top: 2px solid #000;">
                    TOTAL DENDA:
                </td>
                <td class="text-right" style="border-top: 2px solid #000;">
                    Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="stats">
        <p><strong>Statistik Pengembalian:</strong></p>
        <p style="margin-left: 15px;">
            • Total Pengembalian: {{ $pengembalians->count() }}
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