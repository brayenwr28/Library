<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>KTM - {{ $member->member_id }}</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #eee;
}

/* CENTER HALAMAN */
.wrapper {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD BESAR */
.ktm-container {
    width: 900px; /* DIPERBESAR */
}

/* TITLE */
.page-title {
    text-align: center;
    margin-bottom: 15px;
}

.page-title h2 {
    font-size: 24px;
}

.page-title p {
    font-size: 14px;
    color: #777;
}

/* CARD */
.ktm-card {
    background: #fff;
    border: 1px solid #ccc;
}

/* HEADER */
.ktm-header {
    background: #0d437a;
    color: white;
    display: flex;
    align-items: center;
    padding: 20px 25px;
    gap: 20px;
}

.ktm-logo {
    width: 80px;
    filter: brightness(0) invert(1);
}

.logo-placeholder {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
}

.header-text {
    flex: 1;
}

.ktm-title {
    font-size: 20px;
    font-weight: bold;
}

.ktm-subtitle {
    font-size: 12px;
    margin-top: 4px;
}

.ktm-contact {
    font-size: 11px;
    margin-top: 3px;
}

/* GARIS */
.ktm-divider {
    height: 6px;
    background: #ffc107;
}

/* CONTENT */
.ktm-content {
    display: flex;
    padding: 30px;
    gap: 40px;
}

/* FOTO */
.photo {
    width: 220px;
    text-align: center;
}

.photo-box {
    width: 200px;
    height: 260px;
    border: 3px solid #0d437a;
    overflow: hidden;
    margin: auto;
}

.photo-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* DATA */
.info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.info-group {
    margin-bottom: 14px;
}

.label {
    font-size: 11px;
    color: #777;
    font-weight: bold;
}

.value {
    font-size: 16px;
    font-weight: 600;
    margin-top: 3px;
}

/* FOOTER */
.ktm-footer {
    height: 6px;
    background: #0d437a;
}

</style>
</head>

<body>

<div class="wrapper">

<div class="ktm-container">

    <div class="page-title">
        <h2>Kartu Tanda Member (KTM)</h2>
        <p>Universitas Metamedia</p>
    </div>

    <div class="ktm-card">

        <!-- HEADER -->
        <div class="ktm-header">

            @if($logoBase64)
                <img class="ktm-logo" src="{{ $logoBase64 }}">
            @else
                <div class="logo-placeholder"></div>
            @endif

            <div class="header-text">
                <div class="ktm-title">UNIVERSITAS METAMEDIA</div>
                <div class="ktm-subtitle">
                    Jl. Khatib Sulaiman Dalam No.1, Padang
                </div>
                <div class="ktm-contact">
                    0812 6774 5677 | rektorat@metamedia.ac.id
                </div>
            </div>

        </div>

        <div class="ktm-divider"></div>

        <!-- CONTENT -->
        <div class="ktm-content">

            <!-- FOTO -->
            <div class="photo">
                <div class="photo-box">
                    @if($photoBase64)
                        <img src="{{ $photoBase64 }}">
                    @endif
                </div>
            </div>

            <!-- DATA -->
            <div class="info">

                <div class="info-group">
                    <div class="label">Nama Lengkap</div>
                    <div class="value">{{ $member->name }}</div>
                </div>

                <div class="info-group">
                    <div class="label">NIM</div>
                    <div class="value">{{ $member->nim ?? '-' }}</div>
                </div>

                <div class="info-group">
                    <div class="label">Program Studi</div>
                    <div class="value">{{ $member->prodi ?? '-' }}</div>
                </div>

                <div class="info-group">
                    <div class="label">Nomor Member</div>
                    <div class="value">{{ $member->member_id }}</div>
                </div>

                <div class="info-group">
                    <div class="label">Email</div>
                    <div class="value">{{ $member->email }}</div>
                </div>

                <div class="info-group">
                    <div class="label">Tanggal Daftar</div>
                    <div class="value">
                        {{ $member->tgl_daftar ? $member->tgl_daftar->format('d-m-Y') : '-' }}
                    </div>
                </div>

            </div>

        </div>

        <div class="ktm-footer"></div>

    </div>

</div>

</div>

</body>
</html>