<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KTM - {{ $member->member_id }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #111;
            background: #fff;
        }
        .page {
            width: 100%;
            padding: 16px;
            box-sizing: border-box;
        }
        .card {
            width: 100%;
            border: 1px solid #ccc;
            padding: 18px;
            box-sizing: border-box;
        }
        .header-table,
        .content-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-logo {
            width: 90px;
            vertical-align: top;
        }
        .header-logo img {
            display: block;
            max-width: 90px;
            height: auto;
        }
        .header-text {
            padding-left: 12px;
            vertical-align: top;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .subtitle,
        .contact {
            font-size: 11px;
            color: #444;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .separator {
            height: 10px;
            background: #0d437a;
            margin: 14px 0;
        }
        .photo-cell {
            width: 34%;
            padding-right: 14px;
            vertical-align: top;
        }
        .photo-box {
            width: 100%;
            border: 2px solid #0d437a;
            min-height: 220px;
            padding: 6px;
            text-align: center;
        }
        .photo-box img {
            display: block;
            max-width: 100%;
            max-height: 220px;
            margin: 0 auto;
        }
        .placeholder {
            width: 100%;
            min-height: 220px;
            background: #f2f2f2;
            color: #777;
            display: table;
        }
        .placeholder span {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            font-size: 12px;
        }
        .info-cell {
            width: 66%;
            vertical-align: top;
        }
        .info-row {
            margin-bottom: 12px;
        }
        .label {
            font-size: 10px;
            color: #555;
            font-weight: bold;
            text-transform: uppercase;
        }
        .value {
            display: block;
            font-size: 14px;
            color: #111;
            margin-top: 4px;
        }
        .footer-bar {
            margin-top: 16px;
            height: 10px;
            background: #0d437a;
        }
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo">
                    @else
                        <div class="placeholder"><span>Logo</span></div>
                    @endif
                </td>
                <td class="header-text">
                    <div class="title">UNIVERSITAS METAMEDIA</div>
                    <div class="subtitle">Jl. Khatib Sulaiman Dalam No.1, Padang</div>
                    <div class="contact">0812 6774 5677 | rektorat@metamedia.ac.id</div>
                </td>
            </tr>
        </table>
        <div class="separator"></div>
        <table class="content-table">
            <tr>
                <td class="photo-cell">
                    <div class="photo-box">
                        @if($photoBase64)
                            <img src="{{ $photoBase64 }}" alt="Foto Member">
                        @else
                            <div class="placeholder"><span>No Photo</span></div>
                        @endif
                    </div>
                </td>
                <td class="info-cell">
                    <div class="info-row">
                        <div class="label">Nama Lengkap</div>
                        <span class="value">{{ $member->name }}</span>
                    </div>
                    <div class="info-row">
                        <div class="label">NIM</div>
                        <span class="value">{{ $member->nim ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <div class="label">Program Studi</div>
                        <span class="value">{{ $member->prodi ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <div class="label">Nomor Member</div>
                        <span class="value">{{ $member->member_id }}</span>
                    </div>
                    <div class="info-row">
                        <div class="label">Email</div>
                        <span class="value">{{ $member->email }}</span>
                    </div>
                    <div class="info-row">
                        <div class="label">Tanggal Daftar</div>
                        <span class="value">{{ $member->tgl_daftar ? $member->tgl_daftar->format('d-m-Y') : '-' }}</span>
                    </div>
                </td>
            </tr>
        </table>
        <div class="footer-bar"></div>
    </div>
</div>
</body>
</html>
