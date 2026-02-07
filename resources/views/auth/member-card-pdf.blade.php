<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        
        .card {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border: 3px solid #334155;
            border-radius: 8px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #334155;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo-area {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .logo-area img {
            max-width: 80px;
            height: auto;
        }
        
        .header h1 {
            font-size: 28px;
            color: #1e293b;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }
        
        .header p {
            font-size: 12px;
            color: #64748b;
        }
        
        .content {
            margin-bottom: 30px;
        }
        
        .row {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #cbd5e1;
        }
        
        .col {
            flex: 1;
        }
        
        .col.half {
            flex: 0.5;
            margin-right: 20px;
        }
        
        .label {
            font-size: 10px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .value {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
        }
        
        .footer {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            border-top: 2px solid #334155;
            padding-top: 30px;
            margin-top: 30px;
            min-height: 120px;
        }
        
        .footer-item {
            text-align: center;
            width: 30%;
        }
        
        .footer-item img {
            max-width: 100%;
            max-height: 80px;
            margin-bottom: 10px;
        }
        
        .line {
            border-bottom: 2px solid #1e293b;
            height: 50px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-end;
        }
        
        .footer-item p {
            font-size: 11px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="card">
    
    <!-- Header -->
    <div class="header">
        <div class="logo-area">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" alt="Logo">
            @endif
        </div>
        <h1>KARTU ANGGOTA</h1>
        <p>Perpustakaan Digital Universitas Metamedia</p>
    </div>
    
    <!-- Content -->
    <div class="content">
        
        <!-- Nomor Anggota & Tanggal -->
        <div class="row">
            <div class="col half">
                <div class="label">Nomor Anggota</div>
                <div class="value">{{ $member->member_id }}</div>
            </div>
            <div class="col half">
                <div class="label">Tanggal Daftar</div>
                <div class="value">{{ \Carbon\Carbon::parse($member->tgl_daftar)->format('d/m/Y') }}</div>
            </div>
        </div>
        
        <!-- Nama Lengkap -->
        <div class="row">
            <div class="col">
                <div class="label">Nama Lengkap</div>
                <div class="value">{{ strtoupper($member->name) }}</div>
            </div>
        </div>
        
        <!-- NIM & Prodi -->
        <div class="row">
            <div class="col half">
                <div class="label">NIM</div>
                <div class="value">{{ $member->nim }}</div>
            </div>
            <div class="col half">
                <div class="label">Program Studi</div>
                <div class="value">{{ $member->prodi }}</div>
            </div>
        </div>
        
    </div>
    
    <!-- Footer -->
    <div class="footer">
        
        <!-- Stempel -->
        <div class="footer-item">
            @if($stempelBase64)
                <img src="{{ $stempelBase64 }}" alt="Stempel">
            @else
                <div class="line"></div>
            @endif
            <p>Stempel</p>
        </div>
        
        <!-- Tanggal -->
        <div class="footer-item">
            <div class="line"></div>
            <p>{{ now()->format('d/m/Y') }}</p>
        </div>
        
        <!-- TTD -->
        <div class="footer-item">
            @if($ttdBase64)
                <img src="{{ $ttdBase64 }}" alt="TTD">
            @else
                <div class="line"></div>
            @endif
            <p>TTD Pustakawan</p>
        </div>
        
    </div>
    
</div>

</body>
</html>

