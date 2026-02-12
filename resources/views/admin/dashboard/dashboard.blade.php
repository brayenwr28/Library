@extends('layout.app')
@section('title', 'Dashboard Admin')

@section('content-header')
    <div class="row align-items-center gy-2">
        <div class="col">
            <h1 class="h3 mb-1">Dashboard</h1>
            <p class="text-muted mb-0">Ringkasan statistik dan aktivitas sistem</p>
        </div>
        <div class="col-auto">
            <select class="form-select form-select-sm">
                <option>30 hari terakhir</option>
                <option>7 hari terakhir</option>
                <option>Tahun berjalan</option>
            </select>
        </div>
    </div>
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-semibold mb-1">Total Buku</p>
                        <h3 class="fw-semibold mb-1">{{ number_format($totalBooks ?? 0) }}</h3>
                        <small class="text-muted">Seluruh koleksi</small>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="fas fa-book fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-semibold mb-1">Buku Digital</p>
                        <h3 class="fw-semibold mb-1">{{ number_format($totalDigitalBooks ?? 0) }}</h3>
                        <small class="text-muted">Format elektronik</small>
                    </div>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="fas fa-tablet-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-semibold mb-1">Buku Perpustakaan</p>
                        <h3 class="fw-semibold mb-1">{{ number_format($totalLibraryBooks ?? 0) }}</h3>
                        <small class="text-muted">Koleksi fisik</small>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="fas fa-building fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-semibold mb-1">Pengguna Terdaftar</p>
                        <h3 class="fw-semibold mb-1">{{ number_format($totalRegisteredUsers ?? 0) }}</h3>
                        <small class="text-muted">Akun aktif</small>
                    </div>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                        <div>
                            <h5 class="card-title mb-1">Tren Peminjam Buku</h5>
                            <p class="text-muted small mb-0">Total pengguna yang meminjam buku per periode</p>
                        </div>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active">30 Hari</button>
                            <button type="button" class="btn btn-outline-secondary">90 Hari</button>
                            <button type="button" class="btn btn-outline-secondary">12 Bulan</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="ratio ratio-21x9">
                        <canvas id="borrowersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-1">Aktivitas Terbaru</h5>
                    <p class="text-muted small mb-0">Pergerakan terakhir di sistem</p>
                </div>
                <div class="card-body p-0">
                    @php
                        $activities = $recentActivities ?? [
                            ['icon' => 'fas fa-book', 'context' => 'bg-primary-subtle text-primary', 'title' => 'Buku baru ditambahkan', 'description' => 'Judul "Design Patterns" oleh Gamma et al.', 'time' => '2 jam lalu'],
                            ['icon' => 'fas fa-user-plus', 'context' => 'bg-success-subtle text-success', 'title' => 'Pengguna baru terdaftar', 'description' => 'Ahmad Fauzi bergabung', 'time' => '5 jam lalu'],
                            ['icon' => 'fas fa-download', 'context' => 'bg-info-subtle text-info', 'title' => 'Unduhan buku digital', 'description' => '"Clean Code" diunduh', 'time' => 'Kemarin'],
                            ['icon' => 'fas fa-exclamation-circle', 'context' => 'bg-warning-subtle text-warning', 'title' => 'Pengingat pengembalian', 'description' => '2 buku jatuh tempo', 'time' => 'Kemarin'],
                        ];
                    @endphp
                    <div class="list-group list-group-flush">
                        @foreach ($activities as $activity)
                            <div class="list-group-item border-0 py-3">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="activity-icon {{ $activity['context'] }}">
                                        <i class="{{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                            <span class="text-muted small">{{ $activity['time'] }}</span>
                                        </div>
                                        <p class="text-muted small mb-0">{{ $activity['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .activity-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .list-group-item + .list-group-item {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js" integrity="sha384-lIDGszNUpZ9uEPgZGHF9OxR9HaDsrnrqELM8cUwsvFmv+mqhAjoYlVqhFzsAojr/" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chartCanvas = document.getElementById('borrowersChart');
            if (!chartCanvas) {
                return;
            }

            const labels = @json($borrowChartLabels ?? []);
            const totals = @json($borrowChartData ?? []);

            if (!labels.length || !totals.length) {
                chartCanvas.parentElement.innerHTML = `
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                        <i class="fas fa-chart-line fa-3x opacity-25 mb-3"></i>
                        <p class="mb-0">Belum ada data peminjaman</p>
                        <small>Data akan muncul setelah ada transaksi peminjaman</small>
                    </div>
                `;
                return;
            }

            // Render tren peminjam buku
            new Chart(chartCanvas, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Total peminjam',
                        data: totals,
                        borderColor: 'rgba(99, 102, 241, 1)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        tension: 0.35,
                        fill: true,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: context => `${context.parsed.y.toLocaleString('id-ID')} peminjam`,
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                callback: value => value.toLocaleString('id-ID'),
                            },
                        },
                        x: {
                            grid: {
                                display: false,
                            },
                        },
                    },
                },
            });
        });
    </script>
@endpush