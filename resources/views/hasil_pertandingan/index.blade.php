@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 8px;">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 8px;">
        <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Terdapat kesalahan pada input:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Header & Action (Identik dengan halaman Jadwal / Nakes / Cedera) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Hasil Pertandingan</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola hasil kejuaraan dan pencatatan perolehan medali cabang olahraga.</p>
        </div>
        <div class="d-grid d-md-flex justify-content-md-end">
            <button class="btn btn-primary px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#modalTambahHasil">
                <i class="fas fa-plus me-2"></i>TAMBAH HASIL
            </button>
        </div>
    </div>

    <!-- Filter Form (Identik dengan Halaman Lain di Project Ini) -->
    <div class="mb-4 bg-white p-3 rounded border border-light">
        <form action="{{ route('hasil-pertandingan.index') }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-lg-3 col-md-6">
                    <select name="kegiatan_id" class="form-select">
                        <option value="">Semua Kegiatan / Event...</option>
                        @foreach($kegiatans as $k)
                            <option value="{{ $k->id }}" {{ $kegiatan_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select name="cabor" class="form-select">
                        <option value="">Semua Cabor...</option>
                        @foreach($cabors as $c)
                            <option value="{{ $c->nama }}" {{ $cabor == $c->nama ? 'selected' : '' }}>
                                {{ $c->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atlet / daerah..." value="{{ $search }}">
                </div>
                <div class="col-lg-3 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary text-nowrap px-3 flex-fill d-inline-flex align-items-center justify-content-center" style="height: 38px;">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    @if($kegiatan_id || $cabor || $search)
                        <a href="{{ route('hasil-pertandingan.index') }}" class="btn btn-outline-secondary text-nowrap px-3 d-inline-flex align-items-center justify-content-center" style="height: 38px;">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Card Table (Identik dengan Halaman Lain) -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Hasil Pertandingan</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ $hasilPertandingans->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">NO</th>
                            <th style="width: 20%;">CABANG OLAHRAGA</th>
                            <th style="width: 45%;">PERAIH MEDALI</th>
                            <th style="width: 20%;">KEGIATAN / EVENT</th>
                            <th class="text-center" style="width: 10%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilPertandingans as $h)
                        <tr>
                            <td>{{ ($hasilPertandingans->currentPage() - 1) * $hasilPertandingans->perPage() + $loop->iteration }}</td>
                            <td>
                                <strong style="color: #0f172a; font-size: 0.95rem;">{{ $h->cabor }}</strong>
                            </td>
                            <td>
                                <div class="py-1">
                                    <!-- Emas -->
                                    <div class="d-flex align-items-center mb-1 text-nowrap">
                                        <span class="badge bg-warning text-dark me-2 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 20px; height: 20px; border-radius: 50%; font-size: 0.65rem;" title="Medali Emas">
                                            <i class="fas fa-medal"></i>
                                        </span>
                                        @if($h->emasPelaku)
                                            <span class="fw-bold text-dark me-2" style="font-size: 0.88rem;">{{ $h->emasPelaku->nama }}</span>
                                            @if($h->emas_kontingen)
                                                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.72rem; font-weight: 500;">{{ $h->emas_kontingen }}</span>
                                            @endif
                                        @else
                                            <span class="fw-bold text-dark" style="font-size: 0.88rem;">{{ $h->emas_kontingen ?: '-' }}</span>
                                        @endif
                                    </div>
                                    <!-- Perak -->
                                    <div class="d-flex align-items-center mb-1 text-nowrap">
                                        <span class="badge bg-secondary text-white me-2 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 20px; height: 20px; border-radius: 50%; font-size: 0.65rem;" title="Medali Perak">
                                            <i class="fas fa-medal"></i>
                                        </span>
                                        @if($h->perakPelaku)
                                            <span class="text-dark me-2" style="font-size: 0.88rem;">{{ $h->perakPelaku->nama }}</span>
                                            @if($h->perak_kontingen)
                                                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.72rem; font-weight: 500;">{{ $h->perak_kontingen }}</span>
                                            @endif
                                        @else
                                            <span class="text-dark" style="font-size: 0.88rem;">{{ $h->perak_kontingen ?: '-' }}</span>
                                        @endif
                                    </div>
                                    <!-- Perunggu -->
                                    <div class="d-flex align-items-center text-nowrap">
                                        <span class="badge text-white me-2 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #d97706; width: 20px; height: 20px; border-radius: 50%; font-size: 0.65rem;" title="Medali Perunggu">
                                            <i class="fas fa-medal"></i>
                                        </span>
                                        @if($h->perungguPelaku)
                                            <span class="text-dark me-2" style="font-size: 0.88rem;">{{ $h->perungguPelaku->nama }}</span>
                                            @if($h->perunggu_kontingen)
                                                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.72rem; font-weight: 500;">{{ $h->perunggu_kontingen }}</span>
                                            @endif
                                        @else
                                            <span class="text-dark" style="font-size: 0.88rem;">{{ $h->perunggu_kontingen ?: '-' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-primary border border-primary border-opacity-25" style="white-space: normal; text-align: left;">
                                    {{ $h->kegiatan ? $h->kegiatan->nama_kegiatan : '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary action-btn" title="Edit" onclick="editHasil({{ json_encode($h) }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('hasil-pertandingan.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hasil pertandingan ini?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger action-btn" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data hasil pertandingan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($hasilPertandingans->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $hasilPertandingans->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah Hasil Pertandingan -->
<div class="modal fade" id="modalTambahHasil" tabindex="-1" aria-labelledby="modalTambahHasilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('hasil-pertandingan.store') }}" method="POST" class="modal-content" style="border-radius: 12px; border: none;">
            @csrf
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title fw-bold" id="modalTambahHasilLabel" style="color: #0f172a;">
                    <i class="fas fa-plus-circle text-primary me-2"></i> Tambah Hasil Pertandingan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="max-height: calc(85vh - 140px); overflow-y: auto;">
                <!-- Kegiatan & Cabor -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted mb-1">Kegiatan / Event <span class="text-danger">*</span></label>
                        <select name="kegiatan_id" id="tambah_kegiatan_id" class="form-select select2-modal" required style="width: 100%;">
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($kegiatans as $k)
                                <option value="{{ $k->id }}" {{ old('kegiatan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted mb-1">Cabang Olahraga <span class="text-danger">*</span></label>
                        <select name="cabor" id="tambah_cabor" class="form-select select2-modal select2-cabor" required style="width: 100%;" onchange="handleCaborChange('tambah')">
                            <option value="">-- Pilih Cabor --</option>
                            @foreach($cabors as $c)
                                <option value="{{ $c->nama }}" {{ old('cabor') == $c->nama ? 'selected' : '' }}>
                                    {{ $c->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- 1. Medali Emas -->
                <div class="p-3 mb-3 rounded-3 border" style="background-color: #fffdf0; border-color: #fef08a !important;">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-warning text-dark me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; font-size: 0.75rem;">
                            <i class="fas fa-medal"></i>
                        </span>
                        <strong class="text-dark">Medali Emas</strong>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Pilih Atlet</label>
                            <select name="emas_pelaku_id" id="tambah_emas_pelaku_id" class="form-select select2-modal select2-atlet" data-target-kontingen="tambah_emas_kontingen" style="width: 100%;">
                                <option value="">-- Pilih Atlet (Opsional) --</option>
                                @foreach($atlits as $a)
                                    <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}">
                                        {{ $a->nama }} ({{ $a->kontingen }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Kontingen / Daerah Asal</label>
                            <select name="emas_kontingen" id="tambah_emas_kontingen" class="form-select">
                                <option value="">-- Pilih Kontingen / Kota --</option>
                                @foreach($kotas as $kota)
                                    <option value="{{ $kota->nama }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 2. Medali Perak -->
                <div class="p-3 mb-3 rounded-3 border" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-secondary text-white me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; font-size: 0.75rem;">
                            <i class="fas fa-medal"></i>
                        </span>
                        <strong class="text-dark">Medali Perak</strong>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Pilih Atlet</label>
                            <select name="perak_pelaku_id" id="tambah_perak_pelaku_id" class="form-select select2-modal select2-atlet" data-target-kontingen="tambah_perak_kontingen" style="width: 100%;">
                                <option value="">-- Pilih Atlet (Opsional) --</option>
                                @foreach($atlits as $a)
                                    <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}">
                                        {{ $a->nama }} ({{ $a->kontingen }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Kontingen / Daerah Asal</label>
                            <select name="perak_kontingen" id="tambah_perak_kontingen" class="form-select">
                                <option value="">-- Pilih Kontingen / Kota --</option>
                                @foreach($kotas as $kota)
                                    <option value="{{ $kota->nama }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Medali Perunggu -->
                <div class="p-3 rounded-3 border" style="background-color: #fffaf5; border-color: #ffedd5 !important;">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge text-white me-2 d-flex align-items-center justify-content-center" style="background-color: #d97706; width: 24px; height: 24px; border-radius: 50%; font-size: 0.75rem;">
                            <i class="fas fa-medal"></i>
                        </span>
                        <strong class="text-dark">Medali Perunggu</strong>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Pilih Atlet</label>
                            <select name="perunggu_pelaku_id" id="tambah_perunggu_pelaku_id" class="form-select select2-modal select2-atlet" data-target-kontingen="tambah_perunggu_kontingen" style="width: 100%;">
                                <option value="">-- Pilih Atlet (Opsional) --</option>
                                @foreach($atlits as $a)
                                    <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}">
                                        {{ $a->nama }} ({{ $a->kontingen }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Kontingen / Daerah Asal</label>
                            <select name="perunggu_kontingen" id="tambah_perunggu_kontingen" class="form-select">
                                <option value="">-- Pilih Kontingen / Kota --</option>
                                @foreach($kotas as $kota)
                                    <option value="{{ $kota->nama }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Hasil Pertandingan -->
<div class="modal fade" id="modalEditHasil" tabindex="-1" aria-labelledby="modalEditHasilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="formEditHasil" method="POST" class="modal-content" style="border-radius: 12px; border: none;">
            @csrf
            @method('PUT')
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title fw-bold" id="modalEditHasilLabel" style="color: #0f172a;">
                    <i class="fas fa-edit text-primary me-2"></i> Edit Hasil Pertandingan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="max-height: calc(85vh - 140px); overflow-y: auto;">
                <!-- Kegiatan & Cabor -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted mb-1">Kegiatan / Event <span class="text-danger">*</span></label>
                        <select name="kegiatan_id" id="edit_kegiatan_id" class="form-select select2-modal" required style="width: 100%;">
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($kegiatans as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted mb-1">Cabang Olahraga <span class="text-danger">*</span></label>
                        <select name="cabor" id="edit_cabor" class="form-select select2-modal select2-cabor" required style="width: 100%;" onchange="handleCaborChange('edit')">
                            <option value="">-- Pilih Cabor --</option>
                            @foreach($cabors as $c)
                                <option value="{{ $c->nama }}">{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- 1. Medali Emas -->
                <div class="p-3 mb-3 rounded-3 border" style="background-color: #fffdf0; border-color: #fef08a !important;">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-warning text-dark me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; font-size: 0.75rem;">
                            <i class="fas fa-medal"></i>
                        </span>
                        <strong class="text-dark">Medali Emas</strong>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Pilih Atlet</label>
                            <select name="emas_pelaku_id" id="edit_emas_pelaku_id" class="form-select select2-modal select2-atlet" data-target-kontingen="edit_emas_kontingen" style="width: 100%;">
                                <option value="">-- Pilih Atlet (Opsional) --</option>
                                @foreach($atlits as $a)
                                    <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}">
                                        {{ $a->nama }} ({{ $a->kontingen }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Kontingen / Daerah Asal</label>
                            <select name="emas_kontingen" id="edit_emas_kontingen" class="form-select">
                                <option value="">-- Pilih Kontingen / Kota --</option>
                                @foreach($kotas as $kota)
                                    <option value="{{ $kota->nama }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 2. Medali Perak -->
                <div class="p-3 mb-3 rounded-3 border" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-secondary text-white me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; font-size: 0.75rem;">
                            <i class="fas fa-medal"></i>
                        </span>
                        <strong class="text-dark">Medali Perak</strong>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Pilih Atlet</label>
                            <select name="perak_pelaku_id" id="edit_perak_pelaku_id" class="form-select select2-modal select2-atlet" data-target-kontingen="edit_perak_kontingen" style="width: 100%;">
                                <option value="">-- Pilih Atlet (Opsional) --</option>
                                @foreach($atlits as $a)
                                    <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}">
                                        {{ $a->nama }} ({{ $a->kontingen }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Kontingen / Daerah Asal</label>
                            <select name="perak_kontingen" id="edit_perak_kontingen" class="form-select">
                                <option value="">-- Pilih Kontingen / Kota --</option>
                                @foreach($kotas as $kota)
                                    <option value="{{ $kota->nama }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Medali Perunggu -->
                <div class="p-3 rounded-3 border" style="background-color: #fffaf5; border-color: #ffedd5 !important;">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge text-white me-2 d-flex align-items-center justify-content-center" style="background-color: #d97706; width: 24px; height: 24px; border-radius: 50%; font-size: 0.75rem;">
                            <i class="fas fa-medal"></i>
                        </span>
                        <strong class="text-dark">Medali Perunggu</strong>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Pilih Atlet</label>
                            <select name="perunggu_pelaku_id" id="edit_perunggu_pelaku_id" class="form-select select2-modal select2-atlet" data-target-kontingen="edit_perunggu_kontingen" style="width: 100%;">
                                <option value="">-- Pilih Atlet (Opsional) --</option>
                                @foreach($atlits as $a)
                                    <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}">
                                        {{ $a->nama }} ({{ $a->kontingen }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Kontingen / Daerah Asal</label>
                            <select name="perunggu_kontingen" id="edit_perunggu_kontingen" class="form-select">
                                <option value="">-- Pilih Kontingen / Kota --</option>
                                @foreach($kotas as $kota)
                                    <option value="{{ $kota->nama }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Perbarui</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da;
        border-radius: 6px;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
        color: #334155;
        font-size: 0.88rem;
        padding-left: 12px;
        padding-right: 28px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
        right: 8px;
    }
    .select2-dropdown {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        z-index: 1060;
    }
    .select2-search--dropdown .select2-search__field {
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        padding: 6px 10px;
    }
</style>

<script>
const allAtlits = @json($atlits);

function populateAtletOptions(selectId, selectedCabor, currentSelectedId = null) {
    const $select = $('#' + selectId);
    $select.empty();

    if (!selectedCabor) {
        $select.append('<option value="">-- Pilih Cabor Terlebih Dahulu --</option>');
        $select.trigger('change.select2');
        return;
    }

    $select.append('<option value="">-- Pilih Atlet (Opsional) --</option>');

    // Filter ketat hanya atlet yang cabor-nya sama dengan cabor yang dipilih
    const filtered = allAtlits.filter(a => a.cabor && a.cabor.trim().toLowerCase() === selectedCabor.trim().toLowerCase());

    if (filtered.length === 0) {
        $select.append('<option value="" disabled>-- Tidak ada atlet di cabor ' + selectedCabor + ' --</option>');
    } else {
        filtered.forEach(a => {
            const isSelected = (currentSelectedId && currentSelectedId == a.id) ? 'selected' : '';
            const optText = `${a.nama} (${a.kontingen || '-'})`;
            $select.append(`<option value="${a.id}" data-kontingen="${a.kontingen || ''}" ${isSelected}>${optText}</option>`);
        });
    }

    $select.trigger('change.select2');
}

function handleCaborChange(prefix, currentValues = {}) {
    const cabor = $(`#${prefix}_cabor`).val();
    populateAtletOptions(`${prefix}_emas_pelaku_id`, cabor, currentValues.emas);
    populateAtletOptions(`${prefix}_perak_pelaku_id`, cabor, currentValues.perak);
    populateAtletOptions(`${prefix}_perunggu_pelaku_id`, cabor, currentValues.perunggu);
}

$(document).ready(function() {
    // Inisialisasi Select2 pada Modal Tambah
    $('#modalTambahHasil').on('shown.bs.modal', function () {
        $(this).find('.select2-modal').select2({
            dropdownParent: $('#modalTambahHasil'),
            width: '100%'
        });
        handleCaborChange('tambah');
    });

    // Inisialisasi Select2 pada Modal Edit
    $('#modalEditHasil').on('shown.bs.modal', function () {
        $(this).find('.select2-modal').select2({
            dropdownParent: $('#modalEditHasil'),
            width: '100%'
        });
    });

    // Event listener saat cabor diubah (bekerja baik pada Select2 maupun native)
    $(document).on('change', '#tambah_cabor', function() {
        handleCaborChange('tambah');
    });

    $(document).on('change', '#edit_cabor', function() {
        handleCaborChange('edit');
    });

    // Otomatis isi kontingen ketika atlet dipilih via Select2
    $(document).on('change', '.select2-atlet', function() {
        const targetKontingenId = $(this).data('target-kontingen');
        const selectedOpt = $(this).find(':selected');
        const kontingen = selectedOpt.data('kontingen');
        if (kontingen && targetKontingenId) {
            const $targetSelect = $('#' + targetKontingenId);
            $targetSelect.val(kontingen);
            // Jika tidak cocok exact value, cari by text
            if (!$targetSelect.val()) {
                $targetSelect.find('option').each(function() {
                    if ($(this).text().toUpperCase() === kontingen.toUpperCase()) {
                        $targetSelect.val($(this).val());
                        return false;
                    }
                });
            }
        }
    });
});

function editHasil(data) {
    const form = document.getElementById('formEditHasil');
    form.action = '{{ url("hasil-pertandingan") }}/' + data.id;

    $('#edit_kegiatan_id').val(data.kegiatan_id || '').trigger('change.select2');
    $('#edit_cabor').val(data.cabor || '').trigger('change.select2');

    // Filter daftar atlet sesuai cabor hasil pertandingan
    handleCaborChange('edit', {
        emas: data.emas_pelaku_id,
        perak: data.perak_pelaku_id,
        perunggu: data.perunggu_pelaku_id
    });

    $('#edit_emas_pelaku_id').val(data.emas_pelaku_id || '').trigger('change.select2');
    $('#edit_emas_kontingen').val(data.emas_kontingen || '');

    $('#edit_perak_pelaku_id').val(data.perak_pelaku_id || '').trigger('change.select2');
    $('#edit_perak_kontingen').val(data.perak_kontingen || '');

    $('#edit_perunggu_pelaku_id').val(data.perunggu_pelaku_id || '').trigger('change.select2');
    $('#edit_perunggu_kontingen').val(data.perunggu_kontingen || '');

    const modal = new bootstrap.Modal(document.getElementById('modalEditHasil'));
    modal.show();
}
</script>
@endpush
@endsection
