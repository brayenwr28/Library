<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Admin Area'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BkyQi+0lKQ8Zq+6N0hZl5uN5l5Z4O3BO6cK7VQ0YzJis+qJfFZ0CPt2jT9sSk6U2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        .ktm-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .ktm-header {
            background: linear-gradient(to right, #003d7a 0%, #0052a3 100%);
            color: white;
            padding: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .ktm-header-left {
            flex-shrink: 0;
        }

        .ktm-logo {
            max-height: 70px;
            width: auto;
        }

        .ktm-logo-placeholder {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ktm-header-right {
            flex: 1;
        }

        .ktm-title {
            font-size: 1.5em;
            font-weight: bold;
            margin: 0;
            line-height: 1.2;
        }

        .ktm-subtitle {
            font-size: 0.85em;
            margin: 5px 0;
            opacity: 0.95;
            line-height: 1.3;
        }

        .ktm-contact {
            font-size: 0.8em;
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .ktm-divider {
            height: 8px;
            background: #ffc107;
        }

        .ktm-content {
            display: flex;
            padding: 40px;
            gap: 30px;
            background: white;
            min-height: 300px;
        }

        .ktm-photo-section {
            flex-shrink: 0;
        }

        .ktm-photo-box {
            width: 180px;
            height: 220px;
            background: linear-gradient(135deg, #003d7a 0%, #0052a3 100%);
            border-radius: 8px;
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
            opacity: 0.5;
        }

        .ktm-info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            gap: 15px;
        }

        .ktm-info-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .ktm-label {
            font-size: 0.85em;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ktm-value {
            font-size: 1.1em;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
        }

        .ktm-footer {
            height: 15px;
            background: linear-gradient(to right, #003d7a 0%, #0052a3 100%);
        }

        @media print {
            .ktm-card {
                box-shadow: none !important;
                border: none;
                border-radius: 0;
            }

            .ktm-content {
                padding: 30px;
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Title -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-1">Kartu Tanda Member (KTM)</h2>
                    <p class="text-muted">Universitas Metamedia</p>
                </div>

                <!-- KTM Card -->
                <div class="ktm-card shadow-lg">
                    <!-- Header Section -->
                    <div class="ktm-header">
                        <div class="ktm-header-left">
                            @if(file_exists(public_path('logo/logo-univ.png')))
                                <img src="{{ asset('logo/logo-univ.png') }}" alt="Logo" class="ktm-logo">
                            @else
                                <div class="ktm-logo-placeholder"></div>
                            @endif
                        </div>
                        <div class="ktm-header-right">
                            <h3 class="ktm-title">UNIVERSITAS METAMEDIA</h3>
                            <p class="ktm-subtitle">Jl. Khatib Sulaiman Dalam No.1, RT.004/RW.006, Lolong Belanti, Kec.
                                Padang Utara, Kota Padang</p>
                            <p class="ktm-contact">
                                <i class="fas fa-phone"></i> Front Office. 0812 6774 5677 |
                                <i class="fas fa-envelope"></i> rektorat@metamedia.ac.id |
                                <i class="fas fa-globe"></i> www.metamedia.ac.id
                            </p>
                        </div>
                    </div>

                    <!-- Yellow Divider -->
                    <div class="ktm-divider"></div>

                    <!-- Content Section -->
                    <div class="ktm-content">
                        <!-- Photo Section -->
                        <div class="ktm-photo-section">
                            <div class="ktm-photo-box">
                                @if($member->photo && file_exists(public_path('storage/' . $member->photo)))
                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Member" class="ktm-photo">
                                @else
                                    <div class="ktm-photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Info Section -->
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
                                <span class="ktm-value" style="font-size: 0.95em;">{{ $member->email }}</span>
                            </div>
                            <div class="ktm-info-item">
                                <span class="ktm-label">Tanggal Daftar</span>
                                <span
                                    class="ktm-value">{{ $member->tgl_daftar ? $member->tgl_daftar->format('d-m-Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="ktm-footer"></div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-4 g-2">
                    <div class="col-md-6">
                        <a href="{{ route('ktm.download') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-download me-2"></i> Download PDF
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg w-100">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi Penting</h5>
                    <ul class="mb-0">
                        <li>Download KTM Anda dan cetak dengan ukuran kertas A4</li>
                        <li>Gunakan foto dengan latar belakang biru untuk hasil optimal</li>
                        <li>Tunjukkan KTM setiap kali mengakses layanan perpustakaan</li>
                        <li>Kartu berlaku selama masih terdaftar sebagai anggota</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>