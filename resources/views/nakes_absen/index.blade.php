@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h3 class="fw-bold mb-0 text-dark">Data Absensi Nakes</h3>
            <p class="text-muted mb-0 mt-1">Daftar kehadiran Tenaga Kesehatan di berbagai kegiatan</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('nakes-absen.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-muted fw-semibold small">Mulai Tanggal</label>
                        <input type="date" name="start_date" class="form-control bg-light" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-muted fw-semibold small">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control bg-light" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label text-muted fw-semibold small">Cari </label>
                        <input type="text" name="search" class="form-control bg-light" placeholder="Nama/Instansi/Kegiatan..." value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-5 col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1 fw-bold" style="padding-top: 0.5rem; padding-bottom: 0.5rem;"><i class="fas fa-search me-1"></i> Filter</button>
                        @if(request()->hasAny(['start_date', 'end_date', 'search']))
                            <a href="{{ route('nakes-absen.index') }}" class="btn btn-outline-secondary" style="padding: 0.5rem 0.75rem;" title="Reset Filter"><i class="fas fa-undo"></i></a>
                        @endif
                        <a href="{{ route('nakes-absen.pdf', request()->all()) }}" target="_blank" class="btn btn-danger fw-bold px-3" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">
                            <i class="fas fa-file-pdf me-2"></i> PDF
                        </a>
                        <a href="{{ route('nakes-absen.excel', request()->all()) }}" target="_blank" class="btn btn-success fw-bold px-3" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">
                            <i class="fas fa-file-excel me-2"></i> Excel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4 text-uppercase text-nowrap" style="font-size: 0.75rem; letter-spacing: 0.5px;">No</th>
                        <th class="py-3 text-uppercase text-nowrap" style="font-size: 0.75rem; letter-spacing: 0.5px;">Waktu Absen</th>
                        <th class="py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; min-width: 180px;">Nama & Instansi</th>
                        <th class="py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; min-width: 180px;">Kegiatan & Cabor</th>
                        <th class="py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; min-width: 150px;">Venue</th>
                        <th class="py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; min-width: 250px;">Keterangan & Info Bank</th>
                        <th class="py-3 px-4 text-center text-uppercase text-nowrap" style="font-size: 0.75rem; letter-spacing: 0.5px;">Bukti</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($absens as $absen)
                    <tr>
                        <td class="px-4 fw-medium">{{ $loop->iteration + $absens->firstItem() - 1 }}</td>
                        <td class="text-nowrap">
                            <div class="fw-bold text-dark">{{ $absen->created_at->format('d M Y') }}</div>
                            <div class="small text-muted">{{ $absen->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{{ $absen->nama }}</div>
                            <div class="small text-muted"><i class="fas fa-building me-1"></i>{{ $absen->instansi ?? '-' }}</div>
                        </td>
                        <td>
                            @if($absen->nakesJaga && $absen->nakesJaga->jadwalPertandingan && $absen->nakesJaga->jadwalPertandingan->kegiatan)
                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $absen->nakesJaga->jadwalPertandingan->kegiatan->nama_kegiatan }}</div>
                                <span class="badge bg-secondary mt-1">{{ $absen->nakesJaga->cabor ?? $absen->nakesJaga->jadwalPertandingan->jenis_cabor }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium text-dark" style="font-size: 0.85rem;">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                {{ $absen->nakesJaga->venue ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="mb-1" style="font-size: 0.85rem;">{{ $absen->keterangan ?? '-' }}</div>
                            @if($absen->bank || $absen->norek)
                                <div class="d-inline-block border rounded px-2 py-1 bg-light text-nowrap mt-1">
                                    <small class="fw-bold text-dark">{{ $absen->bank ?? 'Bank ?' }}</small>
                                    <small class="text-muted mx-1">|</small>
                                    <small class="text-muted">{{ $absen->norek ?? '-' }}</small>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 text-center text-nowrap">
                            <div class="d-flex justify-content-center gap-2">
                                @if($absen->foto)
                                    <a href="{{ asset('storage/' . $absen->foto) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat Foto Absen">
                                        <i class="fas fa-camera"></i>
                                    </a>
                                @endif
                                @if($absen->tanda_tangan)
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ttdModal{{ $absen->id }}" title="Lihat Tanda Tangan">
                                        <i class="fas fa-signature"></i>
                                    </button>
                                @endif
                            </div>

                            <!-- Modal TTD -->
                            @if($absen->tanda_tangan)
                            <div class="modal fade" id="ttdModal{{ $absen->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title fw-bold">Tanda Tangan</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center p-4 bg-light">
                                            <img src="{{ asset('storage/' . $absen->tanda_tangan) }}" alt="TTD {{ $absen->nama }}" class="img-fluid bg-white border rounded shadow-sm p-2" style="max-height: 150px;">
                                            <div class="mt-3 fw-bold">{{ $absen->nama }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-check mb-3 d-block" style="font-size: 3rem; color: #cbd5e1;"></i>
                            Belum ada data absensi yang sesuai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($absens->hasPages())
        <div class="card-footer bg-white border-top-0 pt-3">
            {{ $absens->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
