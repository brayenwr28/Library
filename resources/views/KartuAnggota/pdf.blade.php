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
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            background: #f5f5f5;
        }
        
        .ktm-container {
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            padding: 0;
            background: white;
        }
        
        .ktm-card {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .ktm-header {
            background: linear-gradient(to right, #003d7a 0%, #0052a3 100%);
            color: white;
            padding: 25px;
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .ktm-header-logo {
            flex-shrink: 0;
        }
        
        .ktm-logo {
            max-height: 80px;
            width: auto;
            filter: brightness(0) invert(1);
        }
        
        .ktm-header-content {
            flex: 1;
        }
        
        .ktm-title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            line-height: 1.2;
        }
        
        .ktm-subtitle {
            font-size: 10px;
            margin: 3px 0;
            opacity: 0.95;
            line-height: 1.3;
        }
        
        .ktm-contact {
            font-size: 9px;
            margin: 5px 0 0 0;
            opacity: 0.9;
            line-height: 1.2;
        }
        
        .ktm-divider {
            height: 10px;
            background: #ffc107;
        }
        
        .ktm-content {
            display: flex;
            padding: 35px;
            gap: 30px;
            flex: 1;
        }
        
        .ktm-photo-section {
            flex-shrink: 0;
        }
        
        .ktm-photo-box {
            width: 160px;
            height: 200px;
            background: linear-gradient(135deg, #003d7a 0%, #0052a3 100%);
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .ktm-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .ktm-photo-placeholder {
            color: white;
            font-size: 60px;
            opacity: 0.4;
        }
        
        .ktm-info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            gap: 12px;
        }
        
        .ktm-info-item {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }
        
        .ktm-label {
            font-size: 9px;
            color: #666;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .ktm-value {
            font-size: 12px;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
        }
        
        .ktm-footer {
            height: 12px;
            background: linear-gradient(to right, #003d7a 0%, #0052a3 100%);
            margin-top: auto;
        }
        
        @page {
            size: A4;
            margin: 0;
            padding: 0;
        }
        
        @media print {
            body {
                background: white;
            }
            
            .ktm-container {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="ktm-container">
        <div class="ktm-card">
            <!-- Header -->
            <div class="ktm-header">
                <div class="ktm-header-logo">
                    @if(file_exists(public_path('logo/logo-univ.png')))
                        <img class="ktm-logo" src="{{ public_path('logo/logo-univ.png') }}" alt="Logo">
                    @else
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 6px;"></div>
                    @endif
                </div>
                <div class="ktm-header-content">
                    <h1 class="ktm-title">UNIVERSITAS METAMEDIA</h1>
                    <p class="ktm-subtitle">Jl. Khatib Sulaiman Dalam No.1, RT.004/RW.006, Lolong Belanti, Kec. Padang Utara, Kota Padang</p>
                    <p class="ktm-contact">
                        Front Office. 0812 6774 5677 | rektorat@metamedia.ac.id | www.metamedia.ac.id
                    </p>
                </div>
            </div>

            <!-- Divider -->
            <div class="ktm-divider"></div>

            <!-- Content -->
            <div class="ktm-content">
                <!-- Photo -->
                <div class="ktm-photo-section">
                    <div class="ktm-photo-box">
                        @if($member->photo && file_exists(public_path('storage/' . $member->photo)))
                            <img src="{{ public_path('storage/' . $member->photo) }}" alt="Foto Member" class="ktm-photo">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" style="width: 70px; height: 70px; fill: white; opacity: 0.3;">
                                <circle cx="50" cy="35" r="20"/>
                                <ellipse cx="50" cy="70" rx="30" ry="20"/>
                            </svg>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="ktm-info-section">
                    <div class="ktm-info-item">
                        <span class="ktm-label">Nama Lengkap</span>
                        <span class="ktm-value">{{ $member->name }}</span>
                    </div>
                    <div class="ktm-info-item">
                        <span class="ktm-label">Nomor Induk Mahasiswa (NIM)</span>
                        <span class="ktm-value">{{ $member->nim ?? '-' }}</span>
                    </div>
                    <div class="ktm-info-item">
                        <span class="ktm-label">Jenjang - Program Studi</span>
                        <span class="ktm-value">{{ $member->prodi ?? '-' }}</span>
                    </div>
                    <div class="ktm-info-item">
                        <span class="ktm-label">No. Member</span>
                        <span class="ktm-value">{{ $member->member_id }}</span>
                    </div>
                    <div class="ktm-info-item">
                        <span class="ktm-label">Email</span>
                        <span class="ktm-value">{{ $member->email }}</span>
                    </div>
                    <div class="ktm-info-item">
                        <span class="ktm-label">Tanggal Daftar</span>
                        <span class="ktm-value">{{ $member->tgl_daftar ? $member->tgl_daftar->format('d-m-Y') : '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="ktm-footer"></div>
        </div>
    </div>
</body>
</html>
