<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KTM - {{ $member->member_id }}</title>
    <style>
        @page {
            size: A4;
            margin: 18mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #1f2933;
            font-family: Arial, Helvetica, sans-serif;
        }

        .page-title {
            margin-bottom: 14px;
            text-align: center;
        }

        .page-title h1 {
            margin: 0;
            color: #102a43;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0;
        }

        .page-title p {
            margin: 4px 0 0;
            color: #627d98;
            font-size: 12px;
        }

        .ktm-card {
            width: 170mm;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid #bcccdc;
            background: #ffffff;
        }

        .header {
            width: 100%;
            border-collapse: collapse;
            background: #0b4f8a;
            color: #ffffff;
        }

        .logo-cell {
            width: 27mm;
            padding: 9mm 5mm 8mm 8mm;
            vertical-align: middle;
            text-align: center;
        }

        .logo-img {
            width: 20mm;
            max-height: 20mm;
        }

        .logo-placeholder {
            width: 20mm;
            height: 20mm;
            line-height: 20mm;
            background: #ffffff;
            color: #0b4f8a;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
        }

        .header-text {
            padding: 8mm 8mm 8mm 0;
            vertical-align: middle;
        }

        .university {
            margin: 0 0 3mm;
            font-size: 21px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 0;
        }

        .address,
        .contact {
            margin: 0 0 1.5mm;
            color: #e6f0ff;
            font-size: 11px;
            line-height: 1.35;
        }

        .gold-line {
            height: 4mm;
            background: #f6c343;
        }

        .content {
            width: 100%;
            border-collapse: collapse;
        }

        .photo-cell {
            width: 48mm;
            padding: 10mm 0 10mm 9mm;
            vertical-align: top;
        }

        .photo-frame {
            width: 35mm;
            height: 45mm;
            overflow: hidden;
            border: 1.5px solid #0b4f8a;
            background: #f0f4f8;
            text-align: center;
        }

        .photo-img {
            width: 35mm;
            height: 45mm;
        }

        .photo-placeholder {
            width: 35mm;
            height: 45mm;
            line-height: 45mm;
            color: #829ab1;
            font-size: 11px;
            text-align: center;
        }

        .info-cell {
            padding: 10mm 9mm 10mm 3mm;
            vertical-align: top;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 0 0 4.2mm;
            vertical-align: top;
        }

        .label {
            color: #52606d;
            font-size: 8.5px;
            font-weight: bold;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .value {
            margin-top: 1mm;
            color: #102a43;
            font-size: 14px;
            line-height: 1.25;
            word-break: break-word;
        }

        .footer {
            height: 5mm;
            background: #0b4f8a;
        }
    </style>
</head>
<body>
    <div class="page-title">
        <h1>Kartu Tanda Member (KTM)</h1>
        <p>Universitas Metamedia</p>
    </div>

    <div class="ktm-card">
        <table class="header">
            <tr>
                <td class="logo-cell">
                    @if($logoBase64)
                        <img class="logo-img" src="{{ $logoBase64 }}" alt="Logo">
                    @else
                        <div class="logo-placeholder">LOGO</div>
                    @endif
                </td>
                <td class="header-text">
                    <div class="university">UNIVERSITAS METAMEDIA</div>
                    <p class="address">Jl. Khatib Sulaiman Dalam No.1, RT.004/RW.006, Lolong Belanti, Padang Utara, Kota Padang</p>
                    <p class="contact">0812 6774 5677 | rektorat@metamedia.ac.id | www.metamedia.ac.id</p>
                </td>
            </tr>
        </table>

        <div class="gold-line"></div>

        <table class="content">
            <tr>
                <td class="photo-cell">
                    <div class="photo-frame">
                        @if($photoBase64)
                            <img class="photo-img" src="{{ $photoBase64 }}" alt="Foto Member">
                        @else
                            <div class="photo-placeholder">NO PHOTO</div>
                        @endif
                    </div>
                </td>
                <td class="info-cell">
                    <table class="info-table">
                        <tr>
                            <td>
                                <div class="label">Nama Lengkap</div>
                                <div class="value">{{ $member->name }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label">Nomor Induk Mahasiswa (NIM)</div>
                                <div class="value">{{ $member->nim ?? '-' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label">Program Studi</div>
                                <div class="value">{{ $member->prodi ?? '-' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label">Nomor Member</div>
                                <div class="value">{{ $member->member_id }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label">Email</div>
                                <div class="value">{{ $member->email }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label">Tanggal Daftar</div>
                                <div class="value">{{ $member->tgl_daftar ? $member->tgl_daftar->format('d-m-Y') : '-' }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer"></div>
    </div>
</body>
</html>
