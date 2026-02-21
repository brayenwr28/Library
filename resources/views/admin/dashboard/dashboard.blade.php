@extends('layout.app')
@section('title', 'Dashboard Admin')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div>
                <h1 class="h2 mb-2 fw-bold">📊 Dashboard Admin</h1>
                <p class="text-muted mb-0">Selamat datang kembali! Berikut ringkasan sistem perpustakaan digital Anda</p>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" id="period-filter" style="width: 180px;">
                    <option value="30">30 hari terakhir</option>
                    <option value="7">7 hari terakhir</option>
                    <option value="1">Hari ini</option>
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
            <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-1">📚 Total Buku</p>
                            <h2 class="fw-bold mb-1 stat-number">{{ number_format($totalBooks ?? 0) }}</h2>
                            <small class="text-muted d-block">Seluruh koleksi</small>
                        </div>
                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>
                <div class="card-footer bg-primary-subtle border-0 py-2 px-4">
                    <small class="text-primary"><i class="fas fa-arrow-up"></i> 12% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Buku Digital -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-1">💿 Buku Digital</p>
                            <h2 class="fw-bold mb-1 stat-number">{{ number_format($totalDigitalBooks ?? 0) }}</h2>
                            <small class="text-muted d-block">Format elektronik</small>
                        </div>
                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="fas fa-tablet-alt"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 60%"></div>
                    </div>
                </div>
                <div class="card-footer bg-info-subtle border-0 py-2 px-4">
                    <small class="text-info"><i class="fas fa-arrow-up"></i> 8% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Buku Perpustakaan -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-1">🏛️ Buku Fisik</p>
                            <h2 class="fw-bold mb-1 stat-number">{{ number_format($totalLibraryBooks ?? 0) }}</h2>
                            <small class="text-muted d-block">Koleksi perpustakaan</small>
                        </div>
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                    </div>
                </div>
                <div class="card-footer bg-success-subtle border-0 py-2 px-4">
                    <small class="text-success"><i class="fas fa-arrow-up"></i> 5% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Pengguna Terdaftar -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase tracking-wider mb-1">👥 Pengguna</p>
                            <h2 class="fw-bold mb-1 stat-number">{{ number_format($totalRegisteredUsers ?? 0) }}</h2>
                            <small class="text-muted d-block">Member aktif</small>
                        </div>
                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 90%"></div>
                    </div>
                </div>
                <div class="card-footer bg-warning-subtle border-0 py-2 px-4">
                    <small class="text-warning"><i class="fas fa-arrow-up"></i> 15% dari bulan lalu</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Activities -->
    <div class="row g-3">
        <!-- Chart -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h5 class="card-title fw-bold mb-1">📈 Tren Peminjaman</h5>
                            <p class="text-muted small mb-0">Grafik aktivitas peminjaman buku 30 hari terakhir</p>
                        </div>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active fw-semibold">30H</button>
                            <button type="button" class="btn btn-outline-primary fw-semibold">90H</button>
                            <button type="button" class="btn btn-outline-primary fw-semibold">1T</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="borrowersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100 d-flex flex-column">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <h5 class="card-title fw-bold mb-1">⚡ Aktivitas Terbaru</h5>
                    <p class="text-muted small mb-0">5 aktivitas terbaru di sistem</p>
                </div>
                <div class="card-body p-0 flex-grow-1 overflow-auto" style="max-height: 400px;">
                    @php
                        $activities = $recentActivities ?? [];
                    @endphp
                    
                    @if(count($activities) > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($activities as $index => $activity)
                                <div class="list-group-item border-0 px-4 py-3 activity-item" style="animation: slideIn 0.3s ease-out {{ $index * 0.05 }}s forwards; opacity: 0;">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="activity-icon flex-shrink-0 {{ $activity['context'] ?? 'bg-primary-subtle text-primary' }}">
                                            <i class="{{ $activity['icon'] ?? 'fas fa-circle' }}"></i>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <h6 class="mb-1 fw-semibold small">{{ $activity['title'] ?? 'Aktivitas' }}</h6>
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
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 p-4 text-muted">
                            <i class="fas fa-inbox fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 text-center small">Belum ada aktivitas baru</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light border-top-0 p-3 text-center">
                    <a href="#" class="btn btn-sm btn-link text-primary fw-semibold">Lihat semua aktivitas →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h6 class="fw-bold mb-1">🎯 Akses Cepat</h6>
                            <p class="text-muted small mb-0">Kelola perpustakaan dengan mudah</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="/digital/create" class="btn btn-primary btn-sm fw-semibold">
                                <i class="fas fa-plus"></i> Tambah Buku Digital
                            </a>
                            <a href="/perpuss/create" class="btn btn-info btn-sm fw-semibold">
                                <i class="fas fa-plus"></i> Tambah Buku Fisik
                            </a>
                            <a href="/digital" class="btn btn-outline-primary btn-sm fw-semibold">
                                <i class="fas fa-list"></i> Kelola Buku
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
        }

        /* Stat Cards */
        .stat-card {
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-number {
            font-size: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: var(--transition-smooth);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .tracking-wider {
            letter-spacing: 0.08em;
        }

        /* Activity Icons */
        .activity-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        /* Activity Items */
        .activity-item {
            transition: var(--transition-smooth);
            border-left: 3px solid transparent;
        }

        .activity-item:hover {
            background-color: rgba(102, 126, 234, 0.05);
            border-left-color: #667eea;
            padding-left: calc(1rem + 1px);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .activity-item {
            animation: slideIn 0.3s ease-out forwards;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            width: 100%;
        }

        /* Gradient Background */
        .bg-gradient {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border: 1px solid #667eea25;
        }

        /* Cards Styling */
        .card {
            transition: var(--transition-smooth);
        }

        .card:hover {
            border-color: #667eea20 !important;
        }

        /* Progress Bar */
        .progress {
            background-color: rgba(102, 126, 234, 0.1);
            border-radius: 100px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 0.6s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stat-number {
                font-size: 1.5rem;
            }

            .btn-group-sm .btn {
                padding: 0.35rem 0.6rem;
                font-size: 0.8rem;
            }
        }

        /* Min Width Utility */
        .min-width-0 {
            min-width: 0;
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
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
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
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
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
                            borderWidth: 3,
                            borderRadius: 4,
                            pointBackgroundColor: '#667eea',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
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
                            duration: 1000,
                            easing: 'easeInOutQuart',
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 15,
                                    font: {
                                        weight: '500',
                                    },
                                },
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold',
                                },
                                bodyFont: {
                                    size: 13,
                                },
                                borderColor: '#667eea',
                                borderWidth: 1,
                                displayColors: true,
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
                                    },
                                },
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)',
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
                                    },
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