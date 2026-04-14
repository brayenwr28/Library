
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KTM - {{ $member->member_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background: white;
        }
        
        @page {
            size: A4;
            margin: 10mm 10mm 10mm 10mm;
        }
        
        .page-wrapper {
            width: 100%;
            margin: 0;
            page-break-after: always;
        }
        
        .page-title {
            text-align: center;
            margin: 0 0 20px 0;
            padding: 0;
        }
        
        .page-title h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 0 0 5px 0;
        }
        
        .page-title p {
            font-size: 14px;
            color: #999;
            margin: 0;
        }
        
        .ktm-card {
            width: 100%;
            background: white;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        
        .ktm-header {
            background: #003d7a;
            color: white;
            padding: 25px;
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        
        .header-logo-cell {
            display: table-cell;
            width: 100px;
            vertical-align: top;
            padding-right: 20px;
        }
        
        .ktm-logo {
            max-width: 85px;
            height: auto;
            filter: brightness(0) invert(1);
        }
        
        .header-content-cell {
            display: table-cell;
            vertical-align: top;
            width: calc(100% - 100px);
        }
        
        .ktm-title {
            font-size: 22px;
            font-weight: bold;
            margin: 0 0 8px 0;
            padding: 0;
            line-height: 1.2;
            letter-spacing: 1px;
        }
        
        .ktm-subtitle {
            font-size: 11px;
            margin: 0 0 6px 0;
            padding: 0;
            line-height: 1.4;
            opacity: 0.95;
        }
        
        .ktm-contact {
            font-size: 10px;
            margin: 0;
            padding: 0;
            line-height: 1.3;
            opacity: 0.9;
        }
        
        .ktm-divider {
            height: 8px;
            background: #ffc107;
            width: 100%;
            display: block;
        }
        
        .ktm-content {
            padding: 30px;
            display: table;
            width: 100%;
            table-layout: fixed;
            min-height: 320px;
        }
        
        .photo-cell {
            display: table-cell;
            width: 180px;
            vertical-align: top;
            padding-right: 35px;
        }
        
        .ktm-photo-box {
            width: 160px;
            height: 200px;
            background: #003d7a;
            border: 2px solid #003d7a;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        
        .ktm-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .info-cell {
            display: table-cell;
            vertical-align: top;
            width: auto;
            padding-top: 5px;
        }
        
        .info-group {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }
        
        .info-group:last-child {
            margin-bottom: 0;
        }
        
        .ktm-label {
            font-size: 9px;
            color: #888;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            padding: 0;
            display: block;
            line-height: 1.1;
        }
        
        .ktm-value {
            font-size: 13px;
            font-weight: 600;
            color: #000;
            margin: 3px 0 0 0;
            padding: 0;
            display: block;
            line-height: 1.4;
            word-wrap: break-word;
        }
        
        .ktm-footer {
            height: 8px;
            background: #003d7a;
            width: 100%;
            display: block;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- Title -->
        <div class="page-title">
            <h2>Kartu Tanda Member (KTM)</h2>
            <p>Universitas Metamedia</p>
        </div>

        <!-- KTM Card -->
        <div class="ktm-card">
            <!-- Header -->
            <div class="ktm-header">
                <div class="header-logo-cell">
                    @if($logoBase64)
                        <img class="ktm-logo" src="{{ $logoBase64 }}" alt="Logo">
                    @else
                        <div style="width: 85px; height: 85px; background: rgba(255,255,255,0.2); border-radius: 8px;"></div>
                    @endif
                </div>
                <div class="header-content-cell">
                    <h1 class="ktm-title">UNIVERSITAS METAMEDIA</h1>
                    <p class="ktm-subtitle">Jl. Khatib Sulaiman Dalam No.1, RT.004/RW.006, Lolong Belanti, Kec. Padang Utara, Kota Padang</p>
                    <p class="ktm-contact">Kantor Dekan. 0812 6774 5677 | rektorat@metamedia.ac.id | www.metamedia.ac.id</p>
                </div>
            </div>

            <!-- Divider -->
            <div class="ktm-divider"></div>

            <!-- Content -->
            <div class="ktm-content">
                <!-- Photo -->
                <div class="photo-cell">
                    <div class="ktm-photo-box">
                        @if($photoBase64)
                            <img src="{{ $photoBase64 }}" alt="Foto Member">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" style="width: 50px; height: 50px; fill: white; opacity: 0.3;">
                                    <circle cx="50" cy="35" r="20"/>
                                    <ellipse cx="50" cy="70" rx="30" ry="20"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="info-cell">
                    <div class="info-group">
                        <span class="ktm-label">Nama Lengkap</span>
                        <span class="ktm-value">{{ $member->name }}</span>
                    </div>
                    <div class="info-group">
                        <span class="ktm-label">Nomor Induk Mahasiswa (NIM)</span>
                        <span class="ktm-value">{{ $member->nim ?? '-' }}</span>
                    </div>
                    <div class="info-group">
                        <span class="ktm-label">Jenjang - Program Studi</span>
                        <span class="ktm-value">{{ $member->prodi ?? '-' }}</span>
                    </div>
                    <div class="info-group">
                        <span class="ktm-label">Nomor Member</span>
                        <span class="ktm-value">{{ $member->member_id }}</span>
                    </div>
                    <div class="info-group">
                        <span class="ktm-label">Email</span>
                        <span class="ktm-value">{{ $member->email }}</span>
                    </div>
                    <div class="info-group">
                        <span class="ktm-label">Tanggal Daftar</span>
                        <span class="ktm-value">Tanggal {{ $member->tgl_daftar ? $member->tgl_daftar->format('d-m-Y') : '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="ktm-footer"></div>
        </div>
    </div>
</body>
</html>