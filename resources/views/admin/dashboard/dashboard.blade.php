@extends('layout.app')
@section('title', 'Dashboard Admin')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">📊 Dashboard Admin</h1>
                <p class="text-muted mb-0">Selamat datang kembali! Berikut ringkasan sistem perpustakaan digital Anda</p>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-primary-subtle text-primary fw-semibold">
                    <i class="fas fa-calendar"></i> Filter
                </span>
                <select class="form-select form-select-sm period-filter-select" id="period-filter">
                    <option value="30">30 hari terakhir</option>
                    <option value="7">7 hari terakhir</option>
                    <option value="1">Hari ini</option>+
                    <option value="365">Tahun berjalan</option>
                </select>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Buku -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden animate-fade-in-up delay-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="flex-grow-1">
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-2">📚 Total Buku</p>
                            <h2 class="fw-bold mb-2 stat-number">{{ number_format($totalBooks ?? 0) }}</h2>
                            <small class="text-muted d-block fw-500">Seluruh koleksi</small>
                        </div>
                        <div class="stat-icon bg-primary-subtle text-primary ms-3">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>
                <div class="card-footer border-0 py-3 px-4">
                    <small class="text-primary fw-semibold"><i class="fas fa-arrow-trend-up"></i> 12% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Buku Digital -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden animate-fade-in-up delay-200">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="flex-grow-1">
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-2">💿 Buku Digital</p>
                            <h2 class="fw-bold mb-2 stat-number" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ number_format($totalDigitalBooks ?? 0) }}</h2>
                            <small class="text-muted d-block fw-500">Format elektronik</small>
                        </div>
                        <div class="stat-icon bg-info-subtle text-info ms-3">
                            <i class="fas fa-tablet-alt"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 60%"></div>
                    </div>
                </div>
                <div class="card-footer border-0 py-3 px-4">
                    <small class="text-info fw-semibold"><i class="fas fa-arrow-trend-up"></i> 8% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Buku Perpustakaan -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden animate-fade-in-up delay-300">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="flex-grow-1">
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-2">🏛️ Buku Fisik</p>
                            <h2 class="fw-bold mb-2 stat-number" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ number_format($totalLibraryBooks ?? 0) }}</h2>
                            <small class="text-muted d-block fw-500">Koleksi perpustakaan</small>
                        </div>
                        <div class="stat-icon bg-success-subtle text-success ms-3">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                    </div>
                </div>
                <div class="card-footer border-0 py-3 px-4">
                    <small class="text-success fw-semibold"><i class="fas fa-arrow-trend-up"></i> 5% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Pengguna Terdaftar -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden animate-fade-in-up delay-400">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="flex-grow-1">
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-2">👥 Pengguna</p>
                            <h2 class="fw-bold mb-2 stat-number" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ number_format($totalRegisteredUsers ?? 0) }}</h2>
                            <small class="text-muted d-block fw-500">Member aktif</small>
                        </div>
                        <div class="stat-icon bg-warning-subtle text-warning ms-3">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 90%"></div>
                    </div>
                </div>
                <div class="card-footer border-0 py-3 px-4">
                    <small class="text-warning fw-semibold"><i class="fas fa-arrow-trend-up"></i> 15% dari bulan lalu</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Pending Alerts -->
    <div class="row g-3 mb-4">
        <!-- Pending Peminjaman -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden animate-fade-in-up delay-500" style="border-left: 4px solid #3b82f6;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-2">⏳ Peminjaman Menunggu</p>
                            <h2 class="fw-bold stat-number mb-2" style="color: #3b82f6;">{{ $pendingPeminjaman ?? 0 }}</h2>
                            <small class="text-muted">Perlu dikonfirmasi</small>
                        </div>
                        <div class="stat-icon bg-blue-100 text-primary ms-3">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.peminjaman.menunggu') }}" class="btn btn-sm btn-primary fw-semibold" style="border-radius: 6px;">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Pengembalian -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden animate-fade-in-up delay-600" style="border-left: 4px solid #10b981;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-2">📦 Pengembalian Menunggu</p>
                            <h2 class="fw-bold stat-number mb-2" style="color: #10b981;">{{ $pendingPengembalian ?? 0 }}</h2>
                            <small class="text-muted">Perlu dikonfirmasi</small>
                        </div>
                        <div class="stat-icon bg-green-100 text-success ms-3">
                            <i class="fas fa-inbox"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.pengembalian.menunggu') }}" class="btn btn-sm btn-success fw-semibold" style="border-radius: 6px;">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Denda Hari Ini -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden animate-fade-in-up delay-700" style="border-left: 4px solid #ef4444;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-2">💰 Denda Hari Ini</p>
                            <h2 class="fw-bold stat-number mb-2" style="color: #ef4444;">Rp {{ number_format($totalDendaHariIni ?? 0, 0, ',', '.') }}</h2>
                            <small class="text-muted">Total dari pengembalian</small>
                        </div>
                        <div class="stat-icon bg-red-100 text-danger ms-3">
                            <i class="fas fa-money-bill"></i>
                        </div>
                    </div>
                    <span class="badge bg-light text-muted fw-normal small">
                        <i class="fas fa-calendar-today"></i> {{ today()->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Activities -->
    <div class="row g-3">
        <!-- Chart -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100 animate-slide-in-left delay-100">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h5 class="card-title fw-bold mb-1">📈 Tren Peminjaman</h5>
                        </div>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active fw-semibold">30H</button>
                            <button type="button" class="btn btn-outline-primary fw-semibold">90H</button>
                            <button type="button" class="btn btn-outline-primary fw-semibold">1T</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="position: relative; height: 320px;">
                        <canvas id="borrowersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100 d-flex flex-column animate-slide-in-right delay-100">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <h5 class="card-title fw-bold mb-1">⚡ Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-0 flex-grow-1 overflow-auto" style="max-height: 420px; scrollbar-width: thin;">
                    @php
                        $activities = $recentActivities ?? [];
                    @endphp
                    
                    @if(count($activities) > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($activities as $index => $activity)
                                <div class="list-group-item border-0 px-4 py-3 activity-item" style="animation: slideIn 0.4s ease-out {{ $index * 0.08 }}s forwards; opacity: 0;">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="activity-icon flex-shrink-0 {{ $activity['context'] ?? 'bg-primary-subtle text-primary' }}">
                                            <i class="{{ $activity['icon'] ?? 'fas fa-circle' }}"></i>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <h6 class="mb-1 fw-semibold small text-dark">{{ $activity['title'] ?? 'Aktivitas' }}</h6>
                                            <p class="text-muted small mb-2">{{ $activity['description'] ?? '' }}</p>
                                            <span class="badge bg-light text-muted fw-normal small">
                                                <i class="far fa-clock"></i> {{ $activity['time'] ?? '' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 p-4 text-muted empty-state">
                            <i class="fas fa-inbox fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 text-center small fw-semibold">Belum ada aktivitas baru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mt-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient animate-fade-in-up delay-200">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">
                        <div>
                            <h5 class="fw-bold mb-2" style="font-size: 1.15rem;">🎯 Akses Cepat</h5>
                            <p class="text-muted small mb-0">Kelola perpustakaan dengan mudah dan cepat</p>
                        </div>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="/digital/create" class="btn btn-primary btn-sm fw-semibold" style="border-radius: 10px; padding: 0.6rem 1.2rem;">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Buku Digital
                            </a>
                            <a href="/perpuss/create" class="btn btn-info btn-sm fw-semibold" style="border-radius: 10px; padding: 0.6rem 1.2rem;">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Buku Fisik
                            </a>
                            <a href="/digital" class="btn btn-outline-primary btn-sm fw-semibold" style="border-radius: 10px; padding: 0.6rem 1.2rem;">
                                <i class="fas fa-list me-2"></i> Kelola Buku
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 15px rgba(102, 126, 234, 0.3);
            }
            50% {
                box-shadow: 0 0 25px rgba(102, 126, 234, 0.6);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }
        .delay-600 { animation-delay: 600ms; }

        /* Stat Cards - Enhanced */
        .stat-card {
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15) !important;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .stat-number {
            font-size: 2.2rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
            font-weight: 800;
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            transition: var(--transition-smooth);
            position: relative;
            z-index: 1;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.15) rotate(8deg);
        }

        .stat-card .progress {
            background-color: rgba(102, 126, 234, 0.08);
            border-radius: 100px;
            height: 6px;
            overflow: hidden;
            border: 1px solid rgba(102, 126, 234, 0.15);
        }

        .stat-card .progress-bar {
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 100px;
            background: var(--primary-gradient);
        }

        /* Card Footer */
        .stat-card .card-footer {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%) !important;
            border-top: 1px solid rgba(102, 126, 234, 0.1);
        }

        .stat-card .card-footer small {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .tracking-wider {
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-size: 0.7rem;
        }

        /* Chart Card */
        .card {
            transition: var(--transition-smooth);
            border-radius: 16px;
            border: 1px solid rgba(102, 126, 234, 0.1) !important;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        }

        .card:hover {
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.1) !important;
            border-color: rgba(102, 126, 234, 0.2) !important;
        }

        .card-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%) !important;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1) !important;
            border-radius: 15px 15px 0 0;
        }

        .card-title {
            font-size: 1.15rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Activity Icons */
        .activity-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .activity-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: inherit;
            opacity: 0;
            border-radius: 12px;
        }

        /* Activity Items */
        .activity-item {
            transition: var(--transition-smooth);
            border-left: 3px solid transparent;
            position: relative;
        }

        .activity-item::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .activity-item:hover {
            background-color: rgba(102, 126, 234, 0.08);
            border-left-color: transparent;
            padding-left: 1rem;
        }

        .activity-item:hover::after {
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-15px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .activity-item {
            animation: slideIn 0.4s ease-out forwards !important;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            width: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
            border-radius: 12px;
            padding: 10px;
        }

        /* Gradient Background */
        .bg-gradient {
            background: linear-gradient(135deg, #667eea12 0%, #764ba212 100%) !important;
            border: 2px solid rgba(102, 126, 234, 0.2) !important;
            border-radius: 16px;
        }

        .bg-gradient:hover {
            background: linear-gradient(135deg, #667eea18 0%, #764ba218 100%) !important;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.1) !important;
        }

        /* Buttons */
        .period-filter-select {
            width: 160px !important;
            border-radius: 8px !important;
            border: 2px solid rgba(102, 126, 234, 0.2) !important;
            padding: 0.4rem 0.75rem !important;
            font-size: 0.85rem !important;
            transition: var(--transition-smooth);
            background-color: #ffffff !important;
            color: #374151 !important;
        }

        .period-filter-select:focus {
            border-color: rgba(102, 126, 234, 0.5) !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
            outline: none !important;
        }

        .period-filter-select:hover {
            border-color: rgba(102, 126, 234, 0.4) !important;
        }

        /* Buttons */
        .btn-group-sm .btn {
            border-radius: 8px;
            padding: 0.45rem 0.85rem;
            font-size: 0.85rem;
            font-weight: 600;
            transition: var(--transition-smooth);
        }

        .btn-group-sm .btn:hover {
            transform: translateY(-2px);
        }

        .btn-group-sm .btn.active {
            background: var(--primary-gradient);
            border-color: transparent;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition-smooth);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: var(--transition-smooth);
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(6, 182, 212, 0.3);
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid rgba(102, 126, 234, 0.3);
            color: #667eea;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition-smooth);
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-color: #667eea;
            transform: translateY(-2px);
            color: #667eea;
        }

        .btn-link {
            color: #667eea;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .btn-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Quick Actions Card */
        .card-body.p-4 {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Min Width Utility */
        .min-width-0 {
            min-width: 0;
        }

        /* Section Header */
        .section-header {
            animation: slideInLeft 0.6s ease-out;
        }

        .section-header h1 {
            font-size: 2rem;
            font-weight: 900;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stat-number {
                font-size: 1.5rem;
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.4rem;
            }

            .btn-group-sm .btn {
                padding: 0.35rem 0.6rem;
                font-size: 0.75rem;
            }

            .card-body {
                padding: 1rem !important;
            }
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            color: #9ca3af;
        }

        .empty-state i {
            opacity: 0.25;
            margin-bottom: 1rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js" integrity="sha384-lIDGszNUpZ9uEPgZGHF9OxR9HaDsrnrqELM8cUwsvFmv+mqhAjoYlVqhFzsAojr/" crossorigin="anonymous" defer></script>
    <script>
        // Initialize Chart
        function initializeBorrowersChart() {
            const chartCanvas = document.getElementById('borrowersChart');
            if (!chartCanvas) return;

            const labels = @json($borrowChartLabels ?? []);
            const totals = @json($borrowChartData ?? []);

            if (!labels.length || !totals.length) {
                chartCanvas.parentElement.innerHTML = `
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted empty-state">
                        <i class="fas fa-chart-line fa-3x opacity-25 mb-3"></i>
                        <p class="mb-0 fw-semibold">Belum ada data peminjaman</p>
                        <small>Data akan muncul setelah ada transaksi peminjaman</small>
                    </div>
                `;
                return;
            }

            try {
                // Destroy existing chart if it exists
                const existing = Chart.helpers.getChart(chartCanvas);
                if (existing) existing.destroy();

                // Create gradient
                const ctx = chartCanvas.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 320);
                gradient.addColorStop(0, 'rgba(102, 126, 234, 0.5)');
                gradient.addColorStop(0.5, 'rgba(102, 126, 234, 0.15)');
                gradient.addColorStop(1, 'rgba(102, 126, 234, 0.01)');

                new Chart(chartCanvas, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Peminjaman',
                            data: totals,
                            borderColor: '#667eea',
                            backgroundColor: gradient,
                            borderWidth: 4,
                            borderRadius: 8,
                            pointBackgroundColor: '#667eea',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            tension: 0.4,
                            fill: true,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        animation: {
                            duration: 1200,
                            easing: 'easeInOutQuart',
                            delay: (ctx) => {
                                let delay = 0;
                                if (ctx.type === 'data') {
                                    if (ctx.mode === 'default' && !ctx.dropped) {
                                        ctx.dropped = true;
                                        delay = ctx.dataIndex * 50 + ctx.datasetIndex * 100;
                                    }
                                }
                                return delay;
                            },
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        weight: '600',
                                        size: 13,
                                    },
                                    color: '#667eea',
                                },
                            },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.95)',
                                padding: 14,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold',
                                },
                                bodyFont: {
                                    size: 13,
                                },
                                borderColor: '#667eea',
                                borderWidth: 2,
                                displayColors: true,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return `${context.parsed.y.toLocaleString('id-ID')} peminjaman`;
                                    }
                                }
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    callback: function(value) {
                                        return value.toLocaleString('id-ID');
                                    },
                                    font: {
                                        size: 12,
                                        weight: '500',
                                    },
                                    color: '#9ca3af',
                                },
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(102, 126, 234, 0.08)',
                                    drawTicks: false,
                                },
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '500',
                                    },
                                    color: '#9ca3af',
                                },
                            },
                        },
                    },
                });
            } catch (error) {
                console.error('Error initializing chart:', error);
            }
        }

        // Period Filter
        document.getElementById('period-filter')?.addEventListener('change', function() {
            // TODO: Implement period filter functionality
            console.log('Period changed to:', this.value);
        });

        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', initializeBorrowersChart);

        // Reinitialize on Turbo navigation (if using Turbo)
        document.addEventListener('turbo:load', initializeBorrowersChart);
    </script>
@endpush