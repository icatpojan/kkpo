@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        border-radius: 8px !important;
        height: 45px !important;
        border-color: #cbd5e1 !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 45px !important;
        padding-left: 15px !important;
        color: #334155 !important;
        font-size: 0.9rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 43px !important;
        right: 10px !important;
    }
    .select2-dropdown {
        border-radius: 8px !important;
        border-color: #cbd5e1 !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
        z-index: 9999 !important;
    }
</style>
@endpush

@section('content')
<style>
    .kpi-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s;
        height: 100%;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .kpi-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .kpi-info h3 {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 2px;
        letter-spacing: 0.2px;
    }
    .kpi-info h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    /* Quick Action Buttons */
    .btn-nakes-quick {
        border-radius: 8px !important;
        font-weight: 700;
        font-size: 0.88rem;
        height: 40px;
        padding: 8px 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        transition: all 0.2s ease;
    }
    .btn-nakes-quick:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .btn-lapor-quick {
        background: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
    }
    .btn-absen-quick {
        background: #4f6f8f !important;
        border-color: #4f6f8f !important;
        color: #ffffff !important;
    }

    /* Filter Selects */
    .dashboard-select {
        border-radius: 8px !important;
        font-weight: 600;
        font-size: 0.88rem;
        height: 40px;
        border: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        padding-left: 1rem !important;
        padding-right: 2.25rem !important;
        cursor: pointer;
        background-color: #ffffff;
    }

    @media (max-width: 767.98px) {
        .kpi-card {
            padding: 12px 10px;
            gap: 10px;
            border-radius: 14px;
        }
        .kpi-icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
            border-radius: 10px;
        }
        .kpi-info h3 {
            font-size: 0.65rem;
            margin-bottom: 2px;
            line-height: 1.2;
        }
        .kpi-info h2 {
            font-size: 1.25rem;
        }
        .dashboard-header-toolbar {
            width: 100% !important;
        }
        .dashboard-header-toolbar .nakes-btn-group {
            display: flex !important;
            width: 100% !important;
            gap: 8px !important;
        }
        .dashboard-header-toolbar .nakes-btn-group button,
        .dashboard-header-toolbar .nakes-btn-group a,
        .dashboard-header-toolbar .btn-nakes-quick {
            flex: 1 1 50% !important;
            width: 50% !important;
            font-size: 0.76rem !important;
            padding: 6px 6px !important;
            height: 38px !important;
            white-space: nowrap !important;
        }
        .dashboard-header-toolbar .nakes-btn-group button i,
        .dashboard-header-toolbar .nakes-btn-group a i,
        .dashboard-header-toolbar .btn-nakes-quick i {
            font-size: 0.78rem !important;
            margin-right: 4px !important;
        }
        .dashboard-header-toolbar .filter-form-group {
            display: flex !important;
            width: 100% !important;
            gap: 8px !important;
        }
        .dashboard-header-toolbar .filter-form-group .select-cabor-wrap {
            flex: 1 1 58% !important;
        }
        .dashboard-header-toolbar .filter-form-group .select-tahun-wrap {
            flex: 1 1 42% !important;
        }
        .dashboard-header-toolbar .filter-form-group select {
            width: 100% !important;
            min-width: 0 !important;
            font-size: 0.76rem !important;
            height: 38px !important;
            padding-left: 0.6rem !important;
            padding-right: 1.6rem !important;
        }
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
            <p class="mb-0 text-muted" style="font-size: 0.95rem;">Pantau segala hal secara <i>real-time</i>.</p>
        </div>
        
        <div class="dashboard-header-toolbar d-flex flex-wrap align-items-center gap-2 gap-md-3">
            @if(auth()->check() && auth()->user()->role == 'nakes')
            <div class="nakes-btn-group d-flex align-items-center gap-2">
                <button type="button" class="btn btn-nakes-quick btn-lapor-quick" data-bs-toggle="modal" data-bs-target="#laporInsidenModal">
                    <i class="fas fa-ambulance me-1 me-sm-2"></i> <span>Lapor Insiden</span>
                </button>
                <button type="button" class="btn btn-nakes-quick btn-absen-quick" data-bs-toggle="modal" data-bs-target="#absenLandingModal">
                    <i class="fas fa-user-check me-1 me-sm-2"></i> <span class="d-none d-sm-inline">Absensi Nakes Jaga</span><span class="d-inline d-sm-none">Absen Nakes</span>
                </button>
            </div>
            @endif

            <form action="{{ route('dashboard') }}" method="GET" class="filter-form-group d-flex align-items-center gap-2 m-0">
                <div class="select-cabor-wrap">
                    <select name="cabor" class="form-select dashboard-select" style="min-width: 220px;" onchange="this.form.submit()">
                        <option value="">Semua Cabang Olahraga</option>
                        @foreach($listCabor as $c)
                            <option value="{{ $c }}" {{ $c == $cabor ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="select-tahun-wrap">
                    <select name="tahun" class="form-select dashboard-select" style="min-width: 140px;" onchange="this.form.submit()">
                        @foreach($listTahun as $t)
                            <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>Tahun {{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- 5 KPIs Row -->
    <div class="row g-2 g-md-3 mb-4">
        <div class="col-6 col-md-4 col-xl mb-2 mb-xl-0">
            <a href="{{ route('pelaku.index', 'atlit') }}" class="text-decoration-none">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>Total Atlet</h3>
                        <h2>{{ number_format($athleteCount) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl mb-2 mb-xl-0">
            <a href="{{ route('accident.cedera') }}" class="text-decoration-none">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: #fef3c7; color: #d97706;">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>Laporan Cedera</h3>
                        <h2>{{ number_format($incidentCount) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl mb-2 mb-xl-0">
            <a href="{{ route('accident.cedera', ['status' => 'cedera']) }}" class="text-decoration-none">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: #f1f5f9; color: #475569;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>Belum Ditangani</h3>
                        <h2>{{ number_format($belumDitangani) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-6 col-xl mb-2 mb-xl-0">
            <a href="{{ route('accident.cedera', ['status' => 'sembuh']) }}" class="text-decoration-none">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: #dcfce7; color: #16a34a;">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>Sudah Sembuh</h3>
                        <h2>{{ number_format($totalSembuh) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 col-xl mb-2 mb-xl-0">
            <a href="{{ route('accident.cedera', ['status' => 'rujuk']) }}" class="text-decoration-none">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: #fee2e2; color: #dc2626;">
                        <i class="fas fa-ambulance"></i>
                    </div>
                    <div class="kpi-info">
                        <h3>Dirujuk Ke RS</h3>
                        <h2>{{ number_format($rujukanCount) }}</h2>
                    </div>
                </div>
            </a>
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
    <div class="row mb-4">
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

    <!-- Klasemen Perolehan Medali Row -->
    @if(isset($medaliData))
    <div class="row">
        <div class="col-12">
            <div class="chart-card" style="padding: 0; overflow: hidden;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2" style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
                    <div class="d-flex align-items-center">
                        <span class="d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background-color: #fef3c7; border-radius: 8px; color: #d97706; font-size: 1.1rem;">
                            <i class="fas fa-trophy"></i>
                        </span>
                        <div>
                            <h4 class="chart-title mb-0" style="font-size: 1.05rem;">Klasemen Perolehan Medali Banten</h4>
                            <span class="text-muted small">Akumulasi real-time seluruh cabang olahraga</span>
                        </div>
                    </div>
                    @if(auth()->user() && auth()->user()->role == 'admin')
                    <a href="{{ route('hasil-pertandingan.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-cog me-1"></i> Kelola Hasil Pertandingan
                    </a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center" style="font-size: 0.9rem;">
                        <thead style="background-color: #0f172a; color: #ffffff;">
                            <tr>
                                <th style="width: 50px; padding: 14px 10px; font-weight: 700; border: none;">No.</th>
                                <th style="text-align: left; padding: 14px 20px; font-weight: 700; border: none;">Peserta / Daerah</th>
                                <th style="width: 120px; padding: 10px; border: none;">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-medal text-warning" style="font-size: 1.1rem;"></i>
                                        <span style="font-size: 0.72rem; font-weight: 700; color: #fbbf24;">Emas</span>
                                    </div>
                                </th>
                                <th style="width: 120px; padding: 10px; border: none;">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-medal" style="color: #cbd5e1; font-size: 1.1rem;"></i>
                                        <span style="font-size: 0.72rem; font-weight: 700; color: #cbd5e1;">Perak</span>
                                    </div>
                                </th>
                                <th style="width: 120px; padding: 10px; border: none;">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-medal" style="color: #f59e0b; font-size: 1.1rem;"></i>
                                        <span style="font-size: 0.72rem; font-weight: 700; color: #f59e0b;">Perunggu</span>
                                    </div>
                                </th>
                                <th style="width: 100px; padding: 14px 10px; font-weight: 700; border: none;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medaliData['klasemen'] as $idx => $row)
                            <tr style="{{ $idx < 3 ? 'font-weight: 600; background-color: #fafbfc;' : '' }}">
                                <td class="text-muted">{{ $idx + 1 }}</td>
                                <td style="text-align: left; padding-left: 20px;" class="fw-bold text-dark">{{ $row['nama'] }}</td>
                                <td class="{{ $row['emas'] > 0 ? 'text-dark fw-bold' : 'text-muted' }}">{{ $row['emas'] }}</td>
                                <td class="{{ $row['perak'] > 0 ? 'text-dark fw-bold' : 'text-muted' }}">{{ $row['perak'] }}</td>
                                <td class="{{ $row['perunggu'] > 0 ? 'text-dark fw-bold' : 'text-muted' }}">{{ $row['perunggu'] }}</td>
                                <td class="fw-bold text-primary" style="font-size: 1rem;">{{ $row['total'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data perolehan medali.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background-color: #f1f5f9; font-weight: 800; border-top: 2px solid #cbd5e1;">
                            <tr>
                                <td colspan="2" class="text-center py-3 text-uppercase" style="letter-spacing: 0.5px;">JUMLAH TOTAL</td>
                                <td class="py-3 text-dark">{{ $medaliData['totalEmas'] }}</td>
                                <td class="py-3 text-dark">{{ $medaliData['totalPerak'] }}</td>
                                <td class="py-3 text-dark">{{ $medaliData['totalPerPerunggu'] ?? $medaliData['totalPerunggu'] }}</td>
                                <td class="py-3 text-primary" style="font-size: 1.05rem;">{{ $medaliData['grandTotal'] }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@if(auth()->check() && auth()->user()->role == 'nakes')
<!-- Lapor Insiden Modal -->
<div class="modal fade" id="laporInsidenModal" tabindex="-1" aria-labelledby="laporInsidenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom px-4 pt-4 pb-3" style="border-color: #f1f5f9 !important;">
                <h5 class="modal-title fw-bold d-flex align-items-center" id="laporInsidenModalLabel" style="color: #1e293b; font-size: 1.25rem;">
                    <div class="d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 12px; color: #ef4444;">
                        <i class="fas fa-briefcase-medical" style="font-size: 1.1rem;"></i>
                    </div>
                    Lapor Insiden Cedera
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.5;"></button>
            </div>
            <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 p-md-5 bg-white">
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">Mohon isi formulir di bawah ini dengan lengkap untuk pelaporan cepat kejadian cedera atlet di lapangan.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Nama Atlet <span class="text-danger">*</span></label>
                            <select name="pelaku_olahraga_id" class="form-select select2-lapor w-100" required>
                                <option value="">-- Cari dan Pilih Atlet --</option>
                                @if(isset($atlits))
                                @foreach($atlits as $atlit)
                                    <option value="{{ $atlit->id }}">{{ $atlit->nama }} ({{ $atlit->cabor }} - {{ $atlit->kontingen }})</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Waktu Kejadian <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="waktu_kejadian" class="form-control" value="{{ date('Y-m-d\TH:i') }}" style="border-radius: 8px; padding: 10px 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155; height: 45px;" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Kegiatan (Jadwal Pertandingan) <span class="text-danger">*</span></label>
                            <select name="jadwal_pertandingan_id" class="form-select select2-jadwal-lapor w-100" required>
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach(\App\JadwalPertandingan::whereDate('tanggal', \Carbon\Carbon::today())->orderBy('waktu', 'asc')->get() as $jadwal)
                                    <option value="{{ $jadwal->id }}">
                                        {{ $jadwal->jenis_cabor }} - {{ $jadwal->waktu }} - {{ $jadwal->venue }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Bagian yang Cedera <span class="text-danger">*</span></label>
                            <input type="text" name="bagian_cedera" class="form-control" placeholder="Misal: Pergelangan Kaki Kanan" style="border-radius: 8px; padding: 10px 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155; height: 45px;" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Penanganan Pertama</label>
                            <input type="text" name="penanganan" class="form-control" placeholder="Contoh: Kompres Es & Perban" style="border-radius: 8px; padding: 10px 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155; height: 45px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Kronologis Kejadian <span class="text-danger">*</span></label>
                            <textarea name="kronologis" class="form-control" rows="4" placeholder="Ceritakan secara singkat bagaimana cedera terjadi..." style="border-radius: 8px; padding: 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155;" required></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="4" placeholder="Informasi lain yang diperlukan..." style="border-radius: 8px; padding: 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155;"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Ambil Foto Bukti/Kondisi</label>
                            <div class="card border border-2 border-dashed shadow-sm">
                                <div class="card-body text-center bg-light rounded" style="position: relative; min-height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                    <video id="webcamLapor" autoplay playsinline style="width: 100%; max-width: 400px; border-radius: 8px; display: none;"></video>
                                    <canvas id="canvasLapor" style="width: 100%; max-width: 400px; border-radius: 8px; display: none;"></canvas>
                                    
                                    <div id="webcamPlaceholderLapor" class="my-3">
                                        <i class="fas fa-camera fa-3x text-muted mb-2"></i>
                                        <p class="text-muted mb-0 small">Kamera akan aktif saat tombol ditekan</p>
                                    </div>

                                    <input type="hidden" name="foto_base64" id="fotoBase64Lapor">

                                    <div class="mt-3">
                                        <button type="button" class="btn btn-outline-primary rounded-pill fw-bold" id="btnStartCameraLapor">
                                            <i class="fas fa-video me-1"></i> Buka Kamera
                                        </button>
                                        <button type="button" class="btn btn-primary rounded-pill fw-bold" id="btnSnapLapor" style="display: none;">
                                            <i class="fas fa-camera me-1"></i> Ambil Foto
                                        </button>
                                        <button type="button" class="btn btn-warning rounded-pill fw-bold" id="btnRetakeLapor" style="display: none;">
                                            <i class="fas fa-redo me-1"></i> Ulangi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3" style="border-color: #f1f5f9 !important; background-color: #ffffff;">
                    <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 10px; color: #64748b; background-color: #f8fafc; border: 1px solid #e2e8f0; height: 45px;">Batal</button>
                    <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 10px; background-color: #ef4444; border: none; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2); height: 45px;">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Absen Landing Modal -->
<div class="modal fade" id="absenLandingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header" style="background-color: var(--primary-teal); color: white; border-bottom: none;">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-check me-2"></i> Absensi Nakes Jaga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="absenLandingForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 bg-white">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Pilih Jadwal Jaga <span class="text-danger">*</span></label>
                            <select id="nakesJagaSelect" class="form-select select2-absen w-100" required onchange="updateAbsenAction(this.value)">
                                <option value="">-- Cari Jadwal & Venue --</option>
                                @if(isset($nakes_jaga_list))
                                @foreach($nakes_jaga_list as $nj)
                                    @php
                                        $displayCabor = $nj->jadwalPertandingan ? $nj->jadwalPertandingan->jenis_cabor : $nj->cabor;
                                        $displayVenue = $nj->jadwalPertandingan ? $nj->jadwalPertandingan->venue : $nj->venue;
                                    @endphp
                                    <option value="{{ $nj->id }}">{{ \Carbon\Carbon::parse($nj->tanggal)->format('d M') }} - {{ $displayCabor }} ({{ $displayVenue }})</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama Anda">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Instansi / Tim</label>
                            <input type="text" name="instansi" class="form-control" placeholder="Contoh: Puskesmas Pamulang">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Nama Bank</label>
                            <input type="text" name="bank" class="form-control" placeholder="Contoh: BCA, BNI, Mandiri">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">No. Rekening</label>
                            <input type="text" name="norek" class="form-control" placeholder="Nomor Rekening Anda">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan opsional..."></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Tanda Tangan (Wajib)</label>
                            <div class="border rounded bg-light" style="position: relative;">
                                <canvas id="signatureCanvas" style="width: 100%; height: 150px; cursor: crosshair; touch-action: none;"></canvas>
                            </div>
                            <div class="mt-2 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger" id="btnClearSignature"><i class="fas fa-eraser me-1"></i> Bersihkan</button>
                            </div>
                            <input type="hidden" name="tanda_tangan_base64" id="tandaTanganBase64" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Ambil Foto Kehadiran (Wajib)</label>
                            <div class="camera-wrapper rounded bg-dark position-relative overflow-hidden mb-2" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                                <video id="webcam" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
                                <canvas id="canvas" style="display: none; width: 100%; height: 100%; object-fit: cover;"></canvas>
                            </div>
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button" id="btnSnap" class="btn btn-sm btn-primary rounded-pill px-3"><i class="fas fa-camera me-1"></i> Ambil Foto</button>
                                <button type="button" id="btnRetake" class="btn btn-sm btn-warning rounded-pill px-3" style="display: none;"><i class="fas fa-redo me-1"></i> Ulangi</button>
                            </div>
                            <input type="hidden" name="foto_base64" id="fotoBase64" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold" style="background-color: var(--primary-teal); border: none;">Simpan Absen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // 1. Trend Line Chart
    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        new Chart(trendCtx.getContext('2d'), {
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
    }

    // 2. Body Part Doughnut Chart
    const bodyPartCtx = document.getElementById('bodyPartChart');
    if (bodyPartCtx) {
        new Chart(bodyPartCtx.getContext('2d'), {
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
    }

    // 3. Cabor Bar Chart
    const caborCtx = document.getElementById('caborChart');
    if (caborCtx) {
        new Chart(caborCtx.getContext('2d'), {
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
    }

    @if(auth()->check() && auth()->user()->role == 'nakes')
    // Inisialisasi Select2 di Modal Lapor Insiden
    function initSelect2Lapor() {
        if ($('.select2-lapor').length) {
            $('.select2-lapor').select2({
                dropdownParent: $('#laporInsidenModal'),
                placeholder: "-- Cari dan Pilih Atlet --",
                allowClear: true,
                width: '100%'
            });
        }
        if ($('.select2-jadwal-lapor').length) {
            $('.select2-jadwal-lapor').select2({
                dropdownParent: $('#laporInsidenModal'),
                placeholder: "-- Pilih Jadwal --",
                allowClear: true,
                width: '100%'
            });
        }
    }

    function initSelect2Absen() {
        if ($('.select2-absen').length) {
            $('.select2-absen').select2({
                dropdownParent: $('#absenLandingModal'),
                placeholder: "-- Cari Jadwal & Venue --",
                allowClear: true,
                width: '100%'
            });
        }
    }

    initSelect2Lapor();
    initSelect2Absen();

    $('#laporInsidenModal').on('shown.bs.modal', function () {
        initSelect2Lapor();
    });

    $('#absenLandingModal').on('shown.bs.modal', function () {
        initSelect2Absen();
    });

    // Webcam Logic for Lapor Insiden
    let webcamStreamLapor;
    const videoLapor = document.getElementById('webcamLapor');
    const canvasLapor = document.getElementById('canvasLapor');
    const btnStartCameraLapor = document.getElementById('btnStartCameraLapor');
    const btnSnapLapor = document.getElementById('btnSnapLapor');
    const btnRetakeLapor = document.getElementById('btnRetakeLapor');
    const fotoBase64Lapor = document.getElementById('fotoBase64Lapor');
    const placeholderLapor = document.getElementById('webcamPlaceholderLapor');
    const laporModal = document.getElementById('laporInsidenModal');

    if (btnStartCameraLapor) {
        btnStartCameraLapor.addEventListener('click', function() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then(function (stream) {
                    webcamStreamLapor = stream;
                    videoLapor.srcObject = stream;
                    videoLapor.play();
                    
                    videoLapor.style.display = 'block';
                    placeholderLapor.style.display = 'none';
                    btnStartCameraLapor.style.display = 'none';
                    btnSnapLapor.style.display = 'inline-block';
                })
                .catch(function (error) {
                    console.error("Camera access denied!", error);
                    alert("Akses kamera tidak diizinkan atau tidak didukung di perangkat ini.");
                });
            }
        });
    }

    if (btnSnapLapor) {
        btnSnapLapor.addEventListener('click', function() {
            canvasLapor.width = videoLapor.videoWidth;
            canvasLapor.height = videoLapor.videoHeight;
            const contextLapor = canvasLapor.getContext('2d');
            contextLapor.drawImage(videoLapor, 0, 0, canvasLapor.width, canvasLapor.height);

            const nowLapor = new Date();
            const timestampLapor = nowLapor.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' ' + nowLapor.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const fontSizeLapor = Math.max(14, Math.floor(canvasLapor.width * 0.035));
            contextLapor.font = "bold " + fontSizeLapor + "px Arial";
            const textWidthLapor = contextLapor.measureText(timestampLapor).width;
            
            contextLapor.fillStyle = "rgba(0, 0, 0, 0.6)";
            contextLapor.fillRect(10, canvasLapor.height - (fontSizeLapor + 20), textWidthLapor + 20, fontSizeLapor + 12);
            
            contextLapor.fillStyle = "#FFEB3B";
            contextLapor.fillText(timestampLapor, 20, canvasLapor.height - 15);
            
            fotoBase64Lapor.value = canvasLapor.toDataURL('image/jpeg');

            videoLapor.style.display = 'none';
            canvasLapor.style.display = 'block';
            btnSnapLapor.style.display = 'none';
            btnRetakeLapor.style.display = 'inline-block';
        });
    }

    if (btnRetakeLapor) {
        btnRetakeLapor.addEventListener('click', function() {
            videoLapor.style.display = 'block';
            canvasLapor.style.display = 'none';
            btnSnapLapor.style.display = 'inline-block';
            btnRetakeLapor.style.display = 'none';
            fotoBase64Lapor.value = '';
        });
    }

    if (laporModal) {
        laporModal.addEventListener('hidden.bs.modal', function () {
            if (webcamStreamLapor) {
                webcamStreamLapor.getTracks().forEach(track => track.stop());
            }
            videoLapor.style.display = 'none';
            canvasLapor.style.display = 'none';
            placeholderLapor.style.display = 'block';
            btnStartCameraLapor.style.display = 'inline-block';
            btnSnapLapor.style.display = 'none';
            btnRetakeLapor.style.display = 'none';
            fotoBase64Lapor.value = '';
        });
    }

    // Absen Modal Logic
    let webcamStream;
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const btnSnap = document.getElementById('btnSnap');
    const btnRetake = document.getElementById('btnRetake');
    const fotoBase64 = document.getElementById('fotoBase64');
    const absenModal = document.getElementById('absenLandingModal');

    if (absenModal) {
        absenModal.addEventListener('shown.bs.modal', function () {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } })
                .then(function (stream) {
                    webcamStream = stream;
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function (error) {
                    console.error("Camera access denied!", error);
                    alert("Akses kamera tidak diizinkan atau tidak didukung di perangkat ini.");
                });
            }
            resizeCanvas();
        });

        absenModal.addEventListener('hidden.bs.modal', function () {
            if (webcamStream) {
                webcamStream.getTracks().forEach(track => track.stop());
            }
            video.style.display = 'block';
            canvas.style.display = 'none';
            btnSnap.style.display = 'inline-block';
            btnRetake.style.display = 'none';
            fotoBase64.value = '';
        });
    }

    if (btnSnap) {
        btnSnap.addEventListener('click', function() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const now = new Date();
            const timestamp = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const fontSize = Math.max(14, Math.floor(canvas.width * 0.035));
            context.font = "bold " + fontSize + "px Arial";
            const textWidth = context.measureText(timestamp).width;
            
            context.fillStyle = "rgba(0, 0, 0, 0.6)";
            context.fillRect(10, canvas.height - (fontSize + 20), textWidth + 20, fontSize + 12);
            
            context.fillStyle = "#FFEB3B";
            context.fillText(timestamp, 20, canvas.height - 15);
            
            fotoBase64.value = canvas.toDataURL('image/jpeg');

            video.style.display = 'none';
            canvas.style.display = 'block';
            btnSnap.style.display = 'none';
            btnRetake.style.display = 'inline-block';
        });
    }

    if (btnRetake) {
        btnRetake.addEventListener('click', function() {
            video.style.display = 'block';
            canvas.style.display = 'none';
            btnSnap.style.display = 'inline-block';
            btnRetake.style.display = 'none';
            fotoBase64.value = '';
        });
    }

    // Signature Pad Logic
    const sigCanvas = document.getElementById('signatureCanvas');
    if (sigCanvas) {
        const sigCtx = sigCanvas.getContext('2d');
        const btnClearSig = document.getElementById('btnClearSignature');
        const tandaTanganBase64 = document.getElementById('tandaTanganBase64');
        let isDrawing = false;

        function resizeCanvas() {
            const ratio =  Math.max(window.devicePixelRatio || 1, 1);
            sigCanvas.width = sigCanvas.offsetWidth * ratio;
            sigCanvas.height = sigCanvas.offsetHeight * ratio;
            sigCtx.scale(ratio, ratio);
        }

        function getMousePos(canvasDom, mouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: mouseEvent.clientX - rect.left,
                y: mouseEvent.clientY - rect.top
            };
        }

        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }

        sigCanvas.addEventListener("mousedown", function (e) {
            isDrawing = true;
            var mousePos = getMousePos(sigCanvas, e);
            sigCtx.beginPath();
            sigCtx.moveTo(mousePos.x, mousePos.y);
            e.preventDefault();
        }, false);
        sigCanvas.addEventListener("mouseup", function (e) { isDrawing = false; tandaTanganBase64.value = sigCanvas.toDataURL('image/png'); }, false);
        sigCanvas.addEventListener("mousemove", function (e) {
            if (isDrawing) {
                var mousePos = getMousePos(sigCanvas, e);
                sigCtx.lineTo(mousePos.x, mousePos.y);
                sigCtx.stroke();
            }
            e.preventDefault();
        }, false);
        
        sigCanvas.addEventListener("touchstart", function (e) {
            isDrawing = true;
            var touchPos = getTouchPos(sigCanvas, e);
            sigCtx.beginPath();
            sigCtx.moveTo(touchPos.x, touchPos.y);
            e.preventDefault();
        }, false);
        sigCanvas.addEventListener("touchend", function (e) { isDrawing = false; tandaTanganBase64.value = sigCanvas.toDataURL('image/png'); }, false);
        sigCanvas.addEventListener("touchmove", function (e) {
            if (isDrawing) {
                var touchPos = getTouchPos(sigCanvas, e);
                sigCtx.lineTo(touchPos.x, touchPos.y);
                sigCtx.stroke();
            }
            e.preventDefault();
        }, false);

        if (btnClearSig) {
            btnClearSig.addEventListener('click', function() {
                sigCtx.clearRect(0, 0, sigCanvas.width, sigCanvas.height);
                tandaTanganBase64.value = '';
            });
        }

        const absenForm = document.getElementById('absenLandingForm');
        if (absenForm) {
            absenForm.addEventListener('submit', function(e) {
                if (!tandaTanganBase64.value) {
                    e.preventDefault();
                    alert('Tanda tangan wajib diisi!');
                }
            });
        }
    }
    @endif
});

function updateAbsenAction(id) {
    var form = document.getElementById('absenLandingForm');
    if (form) {
        if (id) {
            form.action = "{{ url('/public/nakes-jaga') }}/" + id + "/absen";
        } else {
            form.action = "";
        }
    }
}
</script>
@endpush
