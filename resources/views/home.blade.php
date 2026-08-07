@extends('layouts.app')

@section('content')
<style>
    .kpi-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        gap: 20px;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .kpi-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .kpi-info h3 {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 5px;
        letter-spacing: 0.5px;
    }
    .kpi-info h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    
    .chart-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
        height: 100%;
    }
    .chart-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
    }
    
    .recent-table th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 16px;
    }
    .recent-table td {
        padding: 16px;
        vertical-align: middle;
        font-size: 0.9rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }
    .recent-table tr:last-child td {
        border-bottom: none;
    }
</style>

<div class="container-fluid relative z-10">
    <!-- Header & Filters -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Dashboard Klinis</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Pantau segala hal secara <i>real-time</i>.</p>
        </div>
        
        <form action="{{ route('dashboard') }}" method="GET" class="d-flex flex-wrap gap-3 align-items-center">
            <div>
                <select name="cabor" class="form-select border-0 shadow-sm py-2" style="border-radius: 8px; font-weight: 500; min-width: 220px; cursor: pointer; padding-left: 1rem; padding-right: 2.5rem;" onchange="this.form.submit()">
                    <option value="">Semua Cabang Olahraga</option>
                    @foreach($listCabor as $c)
                        <option value="{{ $c }}" {{ $c == $cabor ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="tahun" class="form-select border-0 shadow-sm py-2" style="border-radius: 8px; font-weight: 500; min-width: 140px; cursor: pointer; padding-left: 1rem; padding-right: 2.5rem;" onchange="this.form.submit()">
                    @foreach($listTahun as $t)
                        <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>Tahun {{ $t }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- 4 KPIs Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: #e0f2fe; color: #0284c7;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="kpi-info">
                    <h3>Total Atlet</h3>
                    <h2>{{ number_format($athleteCount) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: #fef3c7; color: #d97706;">
                    <i class="fas fa-user-injured"></i>
                </div>
                <div class="kpi-info">
                    <h3>Cedera Aktif</h3>
                    <h2>{{ number_format($cederaAktif) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: #dcfce7; color: #16a34a;">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="kpi-info">
                    <h3>Sembuh Rate</h3>
                    <h2>{{ $sembuhRate }}%</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: #fee2e2; color: #dc2626;">
                    <i class="fas fa-ambulance"></i>
                </div>
                <div class="kpi-info">
                    <h3>Dirujuk Ke RS</h3>
                    <h2>{{ number_format($rujukanCount) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row mb-4">
        <!-- Line Chart -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="chart-card">
                <h4 class="chart-title">Tren Kasus Cedera ({{ $tahun }})</h4>
                <div style="height: 300px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Doughnut Chart -->
        <div class="col-lg-4">
            <div class="chart-card">
                <h4 class="chart-title">Titik Cedera Terbanyak</h4>
                <div style="height: 300px; display:flex; justify-content:center;">
                    <canvas id="bodyPartChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Bar Chart & Table -->
    <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="chart-card">
                <h4 class="chart-title">Cabor Paling Rawan</h4>
                <div style="height: 350px;">
                    <canvas id="caborChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="chart-card" style="padding: 0;">
                <div class="d-flex justify-content-between align-items-center" style="padding: 24px 24px 10px;">
                    <h4 class="chart-title mb-0">Insiden Terbaru</h4>
                    <a href="{{ route('accident.cedera') }}" class="text-primary text-decoration-none" style="font-size: 0.85rem; font-weight: 600;">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table recent-table w-100 mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Atlet / Pasien</th>
                                <th>Titik Cedera</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestIncidents as $inc)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($inc->waktu_kejadian)->format('d M Y') }}</td>
                                <td>
                                    <strong>{{ $inc->pelakuOlahraga->nama ?? '-' }}</strong><br>
                                    <span class="text-muted" style="font-size: 0.8rem;">{{ $inc->pelakuOlahraga->cabor ?? '-' }}</span>
                                </td>
                                <td>{{ $inc->bagian_cedera ?? '-' }}</td>
                                <td>
                                    @if($inc->status == 'sembuh')
                                        <span class="badge bg-success px-2 py-1 rounded-pill">Sembuh</span>
                                    @elseif($inc->status == 'rujuk')
                                        <span class="badge bg-danger px-2 py-1 rounded-pill">Dirujuk</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1 rounded-pill">Perawatan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada catatan insiden.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Injection -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Trend Line Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($trendLabels) !!},
            datasets: [{
                label: 'Jumlah Cedera',
                data: {!! json_encode($trendData) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f5f9' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

    // 2. Body Part Doughnut Chart
    const bodyPartCtx = document.getElementById('bodyPartChart').getContext('2d');
    new Chart(bodyPartCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($bodyPartLabels) !!},
            datasets: [{
                data: {!! json_encode($bodyPartData) !!},
                backgroundColor: ['#3b82f6', '#0ea5e9', '#06b6d4', '#14b8a6', '#94a3b8'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 20 } }
            }
        }
    });

    // 3. Cabor Bar Chart
    const caborCtx = document.getElementById('caborChart').getContext('2d');
    new Chart(caborCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($caborLabels) !!},
            datasets: [{
                label: 'Insiden',
                data: {!! json_encode($caborData) !!},
                backgroundColor: '#38bdf8',
                borderRadius: 6,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f5f9' }, border: { display: false } },
                y: { grid: { display: false }, border: { display: false } }
            }
        }
    });
});
</script>
@endsection
