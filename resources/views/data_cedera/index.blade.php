@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Data Cedera & Rujukan Medis</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Catat dan kelola informasi penanganan cedera serta rujukan medis pasien.</p>
        </div>
        <div class="d-grid d-md-flex justify-content-md-end">
            <button class="btn btn-primary px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>CATAT CEDERA BARU
            </button>
        </div>
    </div>

    <div class="mb-4 bg-white p-3 rounded-3 shadow-sm border" style="border-color: #e2e8f0;">
        <form action="{{ route('accident.cedera') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">Nama Orang</label>
                <select name="search" class="form-select form-select-sm select2-filter" data-placeholder="Ketik nama...">
                    <option value=""></option>
                    @foreach($pelakus as $p)
                        <option value="{{ $p->nama }}" {{ request('search') == $p->nama ? 'selected' : '' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="cedera" {{ request('status') == 'cedera' ? 'selected' : '' }}>Cedera</option>
                    <option value="rujuk" {{ request('status') == 'rujuk' ? 'selected' : '' }}>Rujuk</option>
                    <option value="sembuh" {{ request('status') == 'sembuh' ? 'selected' : '' }}>Sembuh</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">Cabang Olahraga</label>
                <select name="cabor" class="form-select form-select-sm">
                    <option value="">Semua Cabor</option>
                    @foreach($listCabor as $c)
                        <option value="{{ $c }}" {{ request('cabor') == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">Event/Kegiatan</label>
                <select name="kegiatan_id" class="form-select form-select-sm">
                    <option value="">Semua Event</option>
                    @foreach($kegiatans as $keg)
                        <option value="{{ $keg->id }}" {{ request('kegiatan_id') == $keg->id ? 'selected' : '' }}>{{ $keg->nama_kegiatan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5 mt-md-3">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">Rentang Tanggal</label>
                <div class="input-group input-group-sm">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" title="Dari Tanggal">
                    <span class="input-group-text bg-light text-muted border-start-0 border-end-0">s/d</span>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" title="Sampai Tanggal">
                </div>
            </div>
            <div class="col-md-7 mt-3 d-flex justify-content-md-end gap-2">
                <button type="submit" class="btn btn-sm btn-secondary fw-bold px-4" title="Filter"><i class="fas fa-search me-1"></i> Filter Data</button>
                @if(request()->anyFilled(['search', 'cabor', 'kegiatan_id', 'start_date', 'end_date', 'status']))
                    <a href="{{ route('accident.cedera') }}" class="btn btn-sm btn-outline-danger px-3" title="Reset"><i class="fas fa-times me-1"></i> Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Log Kasus Cedera</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($cederas) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0 text-nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>WAKTU</th>
                            <th>NAMA PASIEN</th>
                            <th>CABOR</th>
                            <th>BAGIAN CEDERA</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cederas as $cedera)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($cedera->waktu_kejadian)->format('d M Y H:i') }}</td>
                            <td>
                                @if($cedera->pelakuOlahraga)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#atlitModal{{ $cedera->pelakuOlahraga->id }}" class="text-decoration-none fw-bold">
                                        {{ $cedera->pelakuOlahraga->nama }}
                                    </a>
                                @else
                                    <strong>-</strong>
                                @endif
                                <br>
                                <span class="text-muted small">{{ $cedera->pelakuOlahraga->kategori ?? '-' }}</span>
                            </td>
                            <td>
                                {{ $cedera->pelakuOlahraga->cabor ?? '-' }}<br>
                                <span class="text-muted small">{{ $cedera->pelakuOlahraga->kontingen ?? '-' }}</span>
                            </td>
                            <td>{{ $cedera->bagian_cedera }}</td>
                            <td>
                                @if($cedera->status == 'rujuk')
                                    <div class="d-inline-block border rounded overflow-hidden" style="border-color: #fca5a5 !important; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.1);">
                                        <div class="bg-danger-subtle text-danger fw-bold text-center py-1 px-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                            DIRUJUK KE RS
                                        </div>
                                        @if($cedera->rs_rujukan)
                                            <div class="bg-white text-dark fw-bold text-center py-1 px-2" style="font-size: 0.75rem; border-top: 1px solid #fca5a5;">
                                                <i class="fas fa-hospital text-danger me-1"></i>{{ $cedera->rs_rujukan }}
                                            </div>
                                        @endif
                                    </div>
                                @elseif($cedera->status == 'sembuh')
                                    <span class="badge bg-success p-2 px-3 rounded-pill fw-bold">SEMBUH</span>
                                @else
                                    <span class="badge bg-warning text-dark p-2 px-3 rounded-pill fw-bold">CEDERA</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 align-items-center">
                                    <button class="btn btn-sm btn-info text-white fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#detailModal{{ $cedera->id }}">
                                        STATUS
                                    </button>
                                    @if($cedera->status != 'sembuh')
                                        @if($cedera->status != 'rujuk')
                                            <button type="button" class="btn btn-sm btn-danger fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#rujukModal{{ $cedera->id }}">
                                                RUJUK
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-success fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#sembuhModal{{ $cedera->id }}">
                                            SEMBUH
                                        </button>
                                    @endif
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">
                                            <i class="fas fa-print"></i> FORM
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 0.85rem;">
                                            <li><a class="dropdown-item fw-bold" href="{{ route('accident.print-tahap-1', $cedera->id) }}" target="_blank"><i class="fas fa-file-pdf text-danger me-2"></i>Form 1 (KK 1 Tahap I)</a></li>
                                            <li><a class="dropdown-item fw-bold" href="{{ route('accident.print-tahap-2', $cedera->id) }}" target="_blank"><i class="fas fa-file-pdf text-danger me-2"></i>Form 2 (KK 2 Tahap II)</a></li>
                                            <li><a class="dropdown-item fw-bold" href="{{ route('accident.print-kronologis', $cedera->id) }}" target="_blank"><i class="fas fa-file-pdf text-danger me-2"></i>Form 3 (Berita Acara Kronologis)</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item fw-bold" href="{{ route('accident.print-foto', $cedera->id) }}" target="_blank"><i class="fas fa-images text-danger me-2"></i>Laporan Foto & Perawatan</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center" style="background:#fff; padding: 15px 24px; border-top: 1px solid #e2e8f0;">
            <span style="color: #64748b; font-size: 0.85rem;">Menampilkan {{ $cederas->firstItem() ?? 0 }} - {{ $cederas->lastItem() ?? 0 }} dari {{ $cederas->total() }}</span>
            <div>
                {{ $cederas->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('accident.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Catat Data Cedera Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Pelaku Olahraga</label>
                            <select name="pelaku_olahraga_id" class="form-select select2-pelaku" style="width: 100%;" required>
                                <option value="">Pilih Atlit/Pelatih...</option>
                                @foreach(\App\PelakuOlahraga::all() as $pelaku)
                                    <option value="{{ $pelaku->id }}">
                                        {{ $pelaku->nama }} ({{ $pelaku->cabor ?? $pelaku->bagian }} - {{ $pelaku->kontingen }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu Kejadian</label>
                            <input type="datetime-local" name="waktu_kejadian" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Kegiatan (Jadwal Pertandingan) <span class="text-danger">*</span></label>
                            <select name="jadwal_pertandingan_id" class="form-select select2-jadwal" style="width: 100%;" required>
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach(\App\JadwalPertandingan::orderBy('tanggal', 'asc')->get() as $jadwal)
                                    <option value="{{ $jadwal->id }}">
                                        {{ $jadwal->jenis_cabor }} - {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} - {{ $jadwal->venue }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Bagian Cedera</label>
                            <input type="text" name="bagian_cedera" class="form-control" placeholder="Contoh: Engkel Kanan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penanganan Pertama</label>
                            <input type="text" name="penanganan" class="form-control" placeholder="Contoh: Kompres Es & Perban">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kronologis Kejadian</label>
                            <textarea name="kronologis" class="form-control" rows="3" placeholder="Jelaskan secara singkat bagaimana cedera terjadi..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Informasi lain yang diperlukan..."></textarea>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="form-label fw-bold">Foto Bukti/Kondisi (Opsional)</label>
                            
                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openCamera('Create')">
                                    <i class="fas fa-camera me-1"></i> Gunakan Kamera
                                </button>
                            </div>
                            
                            <!-- Camera Container -->
                            <div id="cameraContainerCreate" class="d-none mb-3 border p-2 bg-dark rounded text-center">
                                <video id="videoCreate" style="width: 100%; max-width: 400px; height: auto; border-radius: 4px;" autoplay playsinline></video>
                                <canvas id="canvasCreate" class="d-none"></canvas>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="takePhoto('Create')"><i class="fas fa-camera"></i> Jepret</button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="closeCamera('Create')"><i class="fas fa-times"></i> Batal</button>
                                </div>
                            </div>
                            
                            <!-- Image Preview -->
                            <div id="photoPreviewContainerCreate" class="d-none mb-2 position-relative d-inline-block">
                                <img id="photoPreviewCreate" src="" class="img-thumbnail" style="max-height: 150px;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="removePhoto('Create')" style="padding: 2px 6px; border-radius: 50%;"><i class="fas fa-times"></i></button>
                            </div>

                            <input type="file" id="fotoInputCreate" name="foto" class="form-control" accept="image/*" onchange="previewFile(this, 'Create')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data Cedera</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($cederas as $cedera)
<!-- Detail Modal -->
<div class="modal fade" id="detailModal{{ $cedera->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Cedera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-sm m-0">
                    <tr>
                        <th width="40%" class="text-muted">Nama Pasien</th>
                        <td>{{ $cedera->pelakuOlahraga->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Waktu Kejadian</th>
                        <td>{{ \Carbon\Carbon::parse($cedera->waktu_kejadian)->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Jadwal Pertandingan</th>
                        <td>{{ $cedera->jadwalPertandingan->kegiatan->nama_kegiatan ?? '-' }} ({{ $cedera->jadwalPertandingan->jenis_cabor ?? '-' }})</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Status Terakhir</th>
                        <td>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                @if($cedera->status == 'rujuk')
                                    <span class="badge bg-danger">DIRUJUK KE {{ $cedera->rs_rujukan }}</span>
                                @elseif($cedera->status == 'sembuh')
                                    <span class="badge bg-success">SEMBUH</span>
                                    @if($cedera->rs_rujukan)
                                        <span class="badge bg-secondary"><i class="fas fa-hospital me-1"></i>Rujuk: {{ $cedera->rs_rujukan }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-warning text-dark">CEDERA</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Bagian Cedera</th>
                        <td>{{ $cedera->bagian_cedera }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Kronologis</th>
                        <td>{{ $cedera->kronologis ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Penanganan Awal</th>
                        <td>{{ $cedera->penanganan ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Keterangan</th>
                        <td>{{ $cedera->keterangan ?: '-' }}</td>
                    </tr>
                    @if($cedera->images && $cedera->images->count() > 0)
                    <tr>
                        <th class="text-muted">Foto Insiden</th>
                        <td>
                            <div class="d-flex gap-2 flex-wrap mt-2">
                                @foreach($cedera->images as $image)
                                    <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" style="height: 100px; width: 100px; object-fit: cover;">
                                    </a>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif
                </table>

                <hr class="my-4">
                <h6 class="fw-bold text-primary mb-3"><i class="fas fa-notes-medical me-2"></i>Riwayat Perawatan</h6>
                
                @if($cedera->riwayatPerawatans->count() > 0)
                    <div class="timeline-container ps-3" style="border-left: 2px solid #e2e8f0; margin-left: 10px;">
                        @foreach($cedera->riwayatPerawatans as $riwayat)
                            <div class="position-relative mb-3 ps-3">
                                <span class="position-absolute bg-primary rounded-circle" style="width: 12px; height: 12px; left: -19px; top: 4px;"></span>
                                <div class="fw-bold" style="font-size: 0.85rem; color: #64748b;">
                                    {{ \Carbon\Carbon::parse($riwayat->tanggal_waktu)->format('d M Y H:i') }}
                                </div>
                                <div class="fw-bold text-dark">{{ $riwayat->tindakan }}</div>
                                @if($riwayat->keterangan)
                                    <div class="text-muted small mt-1">{{ $riwayat->keterangan }}</div>
                                @endif
                                @if($riwayat->foto)
                                    <div class="mt-2">
                                        <a href="{{ asset($riwayat->foto) }}" target="_blank">
                                            <img src="{{ asset($riwayat->foto) }}" class="img-thumbnail" style="max-height: 100px; width: auto; object-fit: cover;">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light text-center small text-muted border">Belum ada riwayat perawatan.</div>
                @endif

                <div class="mt-4">
                    <button class="btn btn-sm btn-outline-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formPerawatan{{ $cedera->id }}" aria-expanded="false" aria-controls="formPerawatan{{ $cedera->id }}">
                        <i class="fas fa-plus me-1"></i> Tambah Catatan Medis
                    </button>
                    
                    <div class="collapse" id="formPerawatan{{ $cedera->id }}">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold mb-3" style="font-size: 0.9rem;">Catat Perawatan Baru</h6>
                            <form action="{{ route('accident.perawatan', $cedera->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label small">Waktu Perawatan</label>
                                    <input type="datetime-local" name="tanggal_waktu" class="form-control form-control-sm" required value="{{ date('Y-m-d\TH:i') }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Tindakan</label>
                                    <input type="text" name="tindakan" class="form-control form-control-sm" placeholder="Contoh: Terapi fisik sesi 1" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Keterangan (Opsional)</label>
                                    <textarea name="keterangan" class="form-control form-control-sm" rows="2" placeholder="Catatan perkembangan..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Foto (Opsional)</label>
                                    
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openCamera({{ $cedera->id }})">
                                            <i class="fas fa-camera me-1"></i> Gunakan Kamera
                                        </button>
                                    </div>
                                    
                                    <!-- Camera Container -->
                                    <div id="cameraContainer{{ $cedera->id }}" class="d-none mb-3 border p-2 bg-dark rounded text-center">
                                        <video id="video{{ $cedera->id }}" style="width: 100%; max-width: 400px; height: auto; border-radius: 4px;" autoplay playsinline></video>
                                        <canvas id="canvas{{ $cedera->id }}" class="d-none"></canvas>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-primary" onclick="takePhoto({{ $cedera->id }})"><i class="fas fa-camera"></i> Jepret</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="closeCamera({{ $cedera->id }})"><i class="fas fa-times"></i> Batal</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    <div id="photoPreviewContainer{{ $cedera->id }}" class="d-none mb-2 position-relative d-inline-block">
                                        <img id="photoPreview{{ $cedera->id }}" src="" class="img-thumbnail" style="max-height: 150px;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="removePhoto({{ $cedera->id }})" style="padding: 2px 6px; border-radius: 50%;"><i class="fas fa-times"></i></button>
                                    </div>

                                    <input type="file" id="fotoInput{{ $cedera->id }}" name="foto" class="form-control form-control-sm" accept="image/*" onchange="previewFile(this, {{ $cedera->id }})">
                                </div>
                                <div class="text-end">
                                    <button type="submit" name="action" value="simpan" class="btn btn-sm btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                                    @if($cedera->status != 'sembuh')
                                        <button type="submit" name="action" value="simpan_dan_sembuh" class="btn btn-sm btn-success ms-1"><i class="fas fa-check-circle me-1"></i>Simpan & Sembuh</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Sembuh Modal -->
<div class="modal fade" id="sembuhModal{{ $cedera->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-success">Konfirmasi Sembuh & Catat Perawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('accident.sembuh', $cedera->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="alert alert-success mb-4" style="font-size: 0.9rem;">
                        <i class="fas fa-check-circle me-2"></i> Anda akan menyatakan pasien ini <strong>SEMBUH</strong>. Silakan tambahkan catatan akhir perawatan.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Waktu Perawatan Terakhir</label>
                        <input type="datetime-local" name="tanggal_waktu" class="form-control" required value="{{ date('Y-m-d\TH:i') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tindakan Akhir</label>
                        <input type="text" name="tindakan" class="form-control" placeholder="Contoh: Pemeriksaan akhir, pasien dinyatakan sembuh" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan kesembuhan..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Bukti (Opsional)</label>
                        
                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openCamera('Sembuh{{ $cedera->id }}')">
                                <i class="fas fa-camera me-1"></i> Gunakan Kamera
                            </button>
                        </div>
                        
                        <!-- Camera Container -->
                        <div id="cameraContainerSembuh{{ $cedera->id }}" class="d-none mb-3 border p-2 bg-dark rounded text-center">
                            <video id="videoSembuh{{ $cedera->id }}" style="width: 100%; max-width: 400px; height: auto; border-radius: 4px;" autoplay playsinline></video>
                            <canvas id="canvasSembuh{{ $cedera->id }}" class="d-none"></canvas>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-primary" onclick="takePhoto('Sembuh{{ $cedera->id }}')"><i class="fas fa-camera"></i> Jepret</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="closeCamera('Sembuh{{ $cedera->id }}')"><i class="fas fa-times"></i> Batal</button>
                            </div>
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="photoPreviewContainerSembuh{{ $cedera->id }}" class="d-none mb-2 position-relative d-inline-block">
                            <img id="photoPreviewSembuh{{ $cedera->id }}" src="" class="img-thumbnail" style="max-height: 150px;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="removePhoto('Sembuh{{ $cedera->id }}')" style="padding: 2px 6px; border-radius: 50%;"><i class="fas fa-times"></i></button>
                        </div>

                        <input type="file" id="fotoInputSembuh{{ $cedera->id }}" name="foto" class="form-control" accept="image/*" onchange="previewFile(this, 'Sembuh{{ $cedera->id }}')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="fas fa-check me-1"></i>Simpan & Sembuh</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rujuk Modal -->
<div class="modal fade" id="rujukModal{{ $cedera->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('accident.rujuk', $cedera->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Rujuk Pasien: {{ $cedera->pelakuOlahraga->nama ?? '-' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih RS / Klinik Rujukan</label>
                        <select name="rs_rujukan" class="form-select select2-rujukan" style="width: 100%;" required>
                            <option value="">-- Pilih RS/Klinik --</option>
                            @foreach(\App\RumahSakit::orderBy('nama', 'asc')->get() as $rs)
                                <option value="{{ $rs->nama }}">{{ $rs->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Tambahkan keterangan rujukan bila perlu..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Rujuk Pasien</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($cedera->pelakuOlahraga)
<!-- Detail Atlit Modal -->
<div class="modal fade" id="atlitModal{{ $cedera->pelakuOlahraga->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Profil Atlit: {{ $cedera->pelakuOlahraga->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                @if($cedera->pelakuOlahraga->foto)
                    <img src="{{ asset('storage/' . $cedera->pelakuOlahraga->foto) }}" class="img-thumbnail rounded-circle shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-secondary text-white shadow-sm mb-3" style="width: 120px; height: 120px; font-size: 3rem;">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
                <h5 class="fw-bold mb-1">{{ $cedera->pelakuOlahraga->nama }}</h5>
                <p class="text-muted small mb-4">{{ strtoupper($cedera->pelakuOlahraga->kategori) }} - {{ $cedera->pelakuOlahraga->cabor ?? '-' }}</p>

                <table class="table table-borderless table-sm text-start m-0">
                    <tr>
                        <th width="40%" class="text-muted">Nomor Anggota</th>
                        <td><strong>{{ $cedera->pelakuOlahraga->nomor_anggota ?: '-' }}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-muted">NIK</th>
                        <td>{{ $cedera->pelakuOlahraga->nik ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Jenis Kelamin</th>
                        <td>{{ $cedera->pelakuOlahraga->jk == 'L' ? 'Laki-laki' : ($cedera->pelakuOlahraga->jk == 'P' ? 'Perempuan' : '-') }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Tempat, Tgl Lahir</th>
                        <td>{{ $cedera->pelakuOlahraga->ttl ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">No. WhatsApp</th>
                        <td>{{ $cedera->pelakuOlahraga->no_wa ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Kontingen</th>
                        <td>{{ $cedera->pelakuOlahraga->kontingen ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Riwayat Kesehatan</th>
                        <td>{{ $cedera->pelakuOlahraga->riwayat_kesehatan ?: 'Tidak ada' }}</td>
                    </tr>
                    @if($cedera->pelakuOlahraga->dokumens && $cedera->pelakuOlahraga->dokumens->count() > 0)
                    <tr>
                        <th class="text-muted">Dokumen Atlet</th>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($cedera->pelakuOlahraga->dokumens as $doc)
                                    <a href="{{ asset($doc->file_path) }}" target="_blank" class="badge bg-primary text-decoration-none">
                                        <i class="fas fa-file-alt me-1"></i> {{ substr($doc->nama_file, 0, 15) }}...
                                    </a>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@endforeach

@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .select2-container .select2-selection--single {
        height: 31px !important; /* Match form-select-sm height */
        border: 1px solid #e2e8f0;
        border-radius: 4px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 31px;
        color: #334155;
        font-size: 0.875rem; /* form-select-sm font size */
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 29px;
    }
</style>
<script>
    $(document).ready(function() {
        $('.select2-filter').select2({
            placeholder: "Ketik nama...",
            allowClear: true,
            width: '100%'
        });
        
        // Initialize select2 on all rujuk modals when they are shown
        $('.modal[id^="rujukModal"]').on('shown.bs.modal', function () {
            $(this).find('.select2-rujukan').select2({
                dropdownParent: $(this),
                placeholder: "-- Cari dan Pilih RS/Klinik --",
                allowClear: true
            });
        });

        // Initialize select2 on create modal
        $('#createModal').on('shown.bs.modal', function () {
            $(this).find('.select2-pelaku').select2({
                dropdownParent: $(this),
                placeholder: "Pilih Atlit/Pelatih...",
                allowClear: true
            });
            $(this).find('.select2-jadwal').select2({
                dropdownParent: $(this),
                placeholder: "-- Pilih Jadwal --",
                allowClear: true
            });
        });
    });

    let streamMap = {};

    function openCamera(id) {
        let container = document.getElementById('cameraContainer' + id);
        let video = document.getElementById('video' + id);
        
        container.classList.remove('d-none');
        
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(stream) {
                video.srcObject = stream;
                streamMap[id] = stream;
            })
            .catch(function(error) {
                alert("Tidak dapat mengakses kamera. Pastikan browser memberikan izin akses.");
                console.error(error);
            });
        } else {
            alert("Browser Anda tidak mendukung akses kamera.");
        }
    }

    function closeCamera(id) {
        let container = document.getElementById('cameraContainer' + id);
        container.classList.add('d-none');
        
        if (streamMap[id]) {
            let tracks = streamMap[id].getTracks();
            tracks.forEach(track => track.stop());
            streamMap[id] = null;
        }
    }

    function takePhoto(id) {
        let video = document.getElementById('video' + id);
        let canvas = document.getElementById('canvas' + id);
        let context = canvas.getContext('2d');
        
        // Set canvas dimensions to match video stream
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw video frame to canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Add Timestamp Watermark
        const now = new Date();
        const timestamp = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const fontSize = Math.max(14, Math.floor(canvas.width * 0.035));
        context.font = "bold " + fontSize + "px Arial";
        const textWidth = context.measureText(timestamp).width;
        
        // Background
        context.fillStyle = "rgba(0, 0, 0, 0.6)";
        context.fillRect(10, canvas.height - (fontSize + 20), textWidth + 20, fontSize + 12);
        
        // Text
        context.fillStyle = "#FFEB3B";
        context.fillText(timestamp, 20, canvas.height - 15);
        
        // Convert to blob and set to file input
        canvas.toBlob(function(blob) {
            let file = new File([blob], "webcam_capture_" + Date.now() + ".jpg", { type: "image/jpeg", lastModified: new Date().getTime() });
            
            // Create a DataTransfer object to simulate a file list
            let container = new DataTransfer();
            container.items.add(file);
            
            let fileInput = document.getElementById('fotoInput' + id);
            fileInput.files = container.files;
            
            // Show preview
            previewFile(fileInput, id);
            
            // Close camera
            closeCamera(id);
        }, 'image/jpeg', 0.8);
    }

    function previewFile(input, id) {
        let previewContainer = document.getElementById('photoPreviewContainer' + id);
        let previewImg = document.getElementById('photoPreview' + id);
        
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('d-none');
        }
    }

    function removePhoto(id) {
        let input = document.getElementById('fotoInput' + id);
        input.value = ""; // Clear file
        
        // Try clearing via DataTransfer for browser compatibility
        try {
            let dt = new DataTransfer();
            input.files = dt.files;
        } catch (e) {}
        
        previewFile(input, id);
    }

    // Ensure cameras are closed when modal is hidden
    document.addEventListener('DOMContentLoaded', function() {
        let modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function () {
                let containers = modal.querySelectorAll('[id^="cameraContainer"]');
                containers.forEach(container => {
                    if(!container.classList.contains('d-none')){
                       let id = container.id.replace('cameraContainer', '');
                       closeCamera(id);
                    }
                });
            });
        });
    });
</script>
@endpush
