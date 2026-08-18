@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Data {{ strtoupper($kategori) }}</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola data profil, rekam medis, dan informasi kontak {{ $kategori }}.</p>
        </div>
        <div class="d-grid d-md-flex justify-content-md-end gap-2">
            <button class="btn btn-success px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-excel me-2"></i>IMPORT EXCEL
            </button>
            <button class="btn btn-primary px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>TAMBAH DATA
            </button>
        </div>
    </div>

    <div class="mb-4 bg-white p-3 rounded-3 shadow-sm border" style="border-color: #e2e8f0;">
        <form action="{{ route('pelaku.index', $kategori) }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">Cari Nama</label>
                <input type="text" name="search" class="form-control" placeholder="Ketik nama..." value="{{ request('search') }}">
            </div>
            @if($kategori != 'koni')
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">Kel. Cabor</label>
                <select name="kel_cabor" class="form-select" id="kel_cabor_filter">
                    <option value="">Semua</option>
                    @foreach($listKelompok as $key => $val)
                        <option value="{{ $key }}" {{ request('kel_cabor') == $key ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">Cabang Olahraga</label>
                <select name="cabor" class="form-select" id="cabor_filter">
                    <option value="">Semua Cabor</option>
                    @if(!request('kel_cabor'))
                        @foreach($listCabor as $kel => $cabors)
                            <optgroup label="{{ $listKelompok[$kel] ?? $kel }}">
                                @foreach($cabors as $code => $name)
                                    <option value="{{ $name }}" {{ request('cabor') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    @else
                        @if(isset($listCabor[request('kel_cabor')]))
                            @foreach($listCabor[request('kel_cabor')] as $code => $name)
                                <option value="{{ $name }}" {{ request('cabor') == $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        @endif
                    @endif
                </select>
            </div>
            @endif
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted mb-1" style="font-size: 0.8rem;">J. Kelamin</label>
                <select name="jk" class="form-select">
                    <option value="">Semua</option>
                    <option value="L" {{ request('jk') == 'L' ? 'selected' : '' }}>L</option>
                    <option value="P" {{ request('jk') == 'P' ? 'selected' : '' }}>P</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100"><i class="fas fa-filter me-1"></i> Filter</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Active Roster & Medical Status</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($pelakus) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0 text-nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>FOTO</th>
                            <th>NAMA</th>
                            @if($kategori != 'koni')
                                <th>CABOR</th>
                                <th>KONTINGEN</th>
                            @else
                                <th>BAGIAN</th>
                                <th>KONI</th>
                            @endif
                            <th>L/P</th>
                            <th>NO WA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelakus as $pelaku)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($pelaku->foto)
                                    <img src="{{ asset($pelaku->foto) }}" alt="Foto" class="rounded border shadow-sm" style="width: 45px; height: 45px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#photoModal{{ $pelaku->id }}">
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center bg-secondary text-white border shadow-sm" style="width: 45px; height: 45px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#photoModal{{ $pelaku->id }}">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $pelaku->nama }}</strong>
                                <div style="font-size: 0.85rem; color: #64748b; margin-top: 2px;">{{ $pelaku->nomor_anggota ?? '-' }}</div>
                            </td>
                            @if($kategori != 'koni')
                                <td>{{ $pelaku->cabor }}</td>
                                <td>{{ $pelaku->kontingen }}</td>
                            @else
                                <td>{{ $pelaku->bagian }}</td>
                                <td>{{ $pelaku->koni }}</td>
                            @endif
                            <td>{{ $pelaku->jk }}</td>
                            <td>{{ $pelaku->no_wa }}</td>
                            <td>
                                <div class="d-flex gap-1 align-items-center">
                                    <button class="btn btn-sm btn-info text-white fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pelaku->id }}">
                                        DETAIL
                                    </button>
                                    @if($kategori == 'atlit')
                                    <button class="btn btn-sm {{ $pelaku->dokumens && $pelaku->dokumens->count() > 0 ? 'btn-secondary text-white' : 'btn-outline-secondary text-secondary' }} fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#dokumenModal{{ $pelaku->id }}">
                                        DOKUMEN
                                    </button>
                                    <button class="btn btn-sm btn-warning text-dark fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#riwayatModal{{ $pelaku->id }}">
                                        RIWAYAT
                                    </button>
                                    @endif
                                    <a href="{{ route('pelaku.cetak_kartu', $pelaku->id) }}" target="_blank" class="btn btn-sm btn-outline-dark fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">
                                        CETAK KARTU
                                    </a>
                                    <button class="btn btn-sm btn-primary fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#editModal{{ $pelaku->id }}">
                                        EDIT
                                    </button>
                                    <form action="{{ route('pelaku.destroy', $pelaku->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">HAPUS</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center" style="background:#fff; padding: 15px 24px; border-top: 1px solid #e2e8f0;">
            <span style="color: #64748b; font-size: 0.85rem;">Menampilkan {{ $pelakus->firstItem() ?? 0 }} - {{ $pelakus->lastItem() ?? 0 }} dari {{ $pelakus->total() }}</span>
            <div>
                {{ $pelakus->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@foreach($pelakus as $pelaku)
<!-- Photo Modal -->
<div class="modal fade" id="photoModal{{ $pelaku->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                @if($pelaku->foto)
                    <img src="{{ asset($pelaku->foto) }}" alt="Foto {{ $pelaku->nama }}" class="img-fluid rounded shadow-sm" style="max-height: 70vh;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-secondary text-white rounded shadow-sm mx-auto" style="width: 250px; height: 250px; font-size: 6rem;">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
                <h4 class="mt-4 fw-bold text-dark">{{ $pelaku->nama }}</h4>
            </div>
        </div>
    </div>
</div>
<!-- Detail Modal -->
<div class="modal fade" id="detailModal{{ $pelaku->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail {{ strtoupper($kategori) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-sm m-0">
                    @if($pelaku->foto)
                    <tr>
                        <td colspan="2" class="text-center pb-3">
                            <img src="{{ asset($pelaku->foto) }}" alt="Foto {{ $pelaku->nama }}" class="img-thumbnail rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th width="40%" class="text-muted">Nomor Anggota</th>
                        <td><strong>{{ $pelaku->nomor_anggota ?: '-' }}</strong></td>
                    </tr>
                    <tr>
                        <th width="30%" class="bg-light">Nama Lengkap</th>
                        <td>{{ $pelaku->nama }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Jenis Kelamin</th>
                        <td>{{ $pelaku->jk == 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tempat, Tanggal Lahir</th>
                        <td>{{ $pelaku->ttl ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">NIK</th>
                        <td>{{ $pelaku->nik ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">No. WhatsApp</th>
                        <td>{{ $pelaku->no_wa ?: '-' }}</td>
                    </tr>
                    @if($kategori != 'koni')
                        <tr>
                            <th class="bg-light">Cabang Olahraga</th>
                            <td>{{ $pelaku->cabor ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kelompok Cabor</th>
                            <td>{{ $pelaku->kel_cabor ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kontingen</th>
                            <td>{{ $pelaku->kontingen ?: '-' }}</td>
                        </tr>
                    @else
                        <tr>
                            <th class="bg-light">Bagian (Jabatan)</th>
                            <td>{{ $pelaku->bagian ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">KONI Asal</th>
                            <td>{{ $pelaku->koni ?: '-' }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th class="bg-light">Alamat</th>
                        <td>{{ $pelaku->alamat ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Riwayat Cedera/Kesehatan</th>
                        <td>{{ $pelaku->riwayat_kesehatan ?: '-' }}</td>
                    </tr>
                    @if($kategori == 'atlit')
                        <tr>
                            <th class="bg-light">Dokumen Atlet</th>
                            <td>
                                @if($pelaku->dokumens && $pelaku->dokumens->count() > 0)
                                    <div class="d-flex flex-column gap-2">
                                        @foreach($pelaku->dokumens as $doc)
                                            <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn btn-sm btn-primary text-start">
                                                <i class="fas fa-download me-1"></i> {{ $doc->nama_file ?: 'Dokumen '.$loop->iteration }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@if($kategori == 'atlit')
<!-- Riwayat Cedera Modal -->
<div class="modal fade" id="riwayatModal{{ $pelaku->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Rekam Medis & Riwayat Cedera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8fafc; max-height: 70vh; overflow-y: auto;">
                <div class="d-flex align-items-center mb-4 p-3 bg-white rounded shadow-sm border">
                    @if($pelaku->foto)
                        <img src="{{ asset($pelaku->foto) }}" class="rounded-circle shadow-sm me-3" style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #e2e8f0;">
                    @else
                        <div class="d-flex justify-content-center align-items-center rounded-circle bg-secondary text-white shadow-sm me-3" style="width: 70px; height: 70px; font-size: 2rem; border: 2px solid #e2e8f0;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">{{ $pelaku->nama }}</h5>
                        <div class="d-flex flex-wrap gap-2 text-muted" style="font-size: 0.85rem;">
                            <span><i class="fas fa-id-badge me-1"></i> {{ $pelaku->nomor_anggota ?? '-' }}</span>
                            <span>&bull;</span>
                            <span><i class="fas fa-running me-1"></i> {{ $pelaku->cabor ?? '-' }} ({{ $pelaku->kontingen ?? '-' }})</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3 text-secondary ms-1"><i class="fas fa-history me-2"></i>Histori Insiden & Perawatan</h6>

                @if($pelaku->dataCederas && $pelaku->dataCederas->count() > 0)
                    <div class="timeline-wrapper ps-2" style="border-left: 2px solid #cbd5e1; margin-left: 10px;">
                        @foreach($pelaku->dataCederas->sortByDesc('waktu_kejadian') as $cedera)
                            <div class="position-relative mb-4 ps-4">
                                <span class="position-absolute bg-warning border border-2 border-white rounded-circle shadow-sm" style="width: 16px; height: 16px; left: -9px; top: 0;"></span>
                                
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i>{{ \Carbon\Carbon::parse($cedera->waktu_kejadian)->format('d M Y, H:i') }}
                                        </div>
                                        <div>
                                            @if($cedera->status == 'rujuk')
                                                <span class="badge bg-danger-subtle text-danger border">DIRUJUK: {{ $cedera->rs_rujukan }}</span>
                                            @elseif($cedera->status == 'sembuh')
                                                <span class="badge bg-success">SEMBUH</span>
                                            @else
                                                <span class="badge bg-warning text-dark">CEDERA</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body py-3">
                                        <div class="row g-2 mb-3">
                                            <div class="col-sm-6">
                                                <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Bagian Cedera</div>
                                                <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $cedera->bagian_cedera ?? '-' }}</div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Event/Pertandingan</div>
                                                @if($cedera->jadwalPertandingan && $cedera->jadwalPertandingan->kegiatan)
                                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $cedera->jadwalPertandingan->kegiatan->nama_kegiatan ?? '-' }} <span class="text-secondary fw-normal">({{ $cedera->jadwalPertandingan->jenis_cabor ?? '-' }})</span></div>
                                                @else
                                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">-</div>
                                                @endif
                                            </div>
                                        </div>
                                        @if($cedera->kronologis)
                                            <div class="mb-3 p-2 bg-light rounded text-dark" style="font-size: 0.9rem; border-left: 3px solid #94a3b8;">
                                                <span class="fw-bold d-block text-secondary mb-1" style="font-size: 0.75rem;">KRONOLOGIS</span>
                                                {{ $cedera->kronologis }}
                                            </div>
                                        @endif

                                        @if($cedera->riwayatPerawatans && $cedera->riwayatPerawatans->count() > 0)
                                            <div class="mt-3">
                                                <h6 class="fw-bold text-primary mb-2" style="font-size: 0.85rem;"><i class="fas fa-stethoscope me-1"></i> Log Perawatan</h6>
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach($cedera->riwayatPerawatans as $riwayat)
                                                        <div class="p-2 bg-light rounded border border-light">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $riwayat->tindakan }}</span>
                                                                <span class="badge bg-secondary" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($riwayat->tanggal_waktu)->format('d M Y, H:i') }}</span>
                                                            </div>
                                                            @if($riwayat->keterangan)
                                                                <div class="text-muted" style="font-size: 0.8rem;">{{ $riwayat->keterangan }}</div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border text-center text-muted p-4">
                        <i class="fas fa-shield-alt mb-3 d-block" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                        <span class="fw-bold">Rekam Medis Bersih</span><br>
                        Belum ada riwayat insiden/cedera yang tercatat untuk atlet ini.
                    </div>
                @endif
            </div>
            <div class="modal-footer bg-light border-top-0">
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@if($kategori == 'atlit')
<!-- Dokumen Modal -->
<div class="modal fade" id="dokumenModal{{ $pelaku->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Dokumen {{ $pelaku->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                @if($pelaku->dokumens && $pelaku->dokumens->count() > 0)
                    <div class="d-flex flex-column gap-4">
                        @foreach($pelaku->dokumens as $doc)
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <div class="fw-bold text-primary"><i class="fas fa-file-alt me-2"></i>{{ $doc->nama_file }}</div>
                                    <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru</a>
                                </div>
                                <div class="card-body p-0 text-center bg-dark rounded-bottom" style="overflow: hidden;">
                                    @if(preg_match('/\.(jpg|jpeg|png)$/i', $doc->file_path))
                                        <img src="{{ asset($doc->file_path) }}" class="img-fluid" style="max-height: 80vh;" alt="{{ $doc->nama_file }}">
                                    @elseif(preg_match('/\.pdf$/i', $doc->file_path))
                                        <iframe src="{{ asset($doc->file_path) }}" style="width: 100%; height: 80vh;" frameborder="0"></iframe>
                                    @else
                                        <div class="p-5 text-white">
                                            <i class="fas fa-file-download fa-3x mb-3"></i>
                                            <p>Format file ini tidak dapat ditampilkan secara langsung.</p>
                                            <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn btn-primary">Unduh File</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border text-center text-muted p-4">
                        <i class="fas fa-folder-open mb-3 d-block" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                        <span class="fw-bold">Belum ada dokumen</span><br>
                        Silakan tambahkan dokumen melalui tombol EDIT.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $pelaku->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('pelaku.update', $pelaku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Data {{ strtoupper($kategori) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $pelaku->nama }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jk" class="form-select" required>
                                <option value="L" {{ $pelaku->jk == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                <option value="P" {{ $pelaku->jk == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ $pelaku->nik }}">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Tempat, Tanggal Lahir (TTL)</label>
                            <input type="text" name="ttl" class="form-control" value="{{ $pelaku->ttl }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control" value="{{ $pelaku->no_wa }}">
                        </div>

                        @if($kategori != 'koni')
                            <div class="col-md-4">
                                <label class="form-label">Kelompok Cabor</label>
                                <select name="kel_cabor" class="form-select kel_cabor_edit" required>
                                    <option value="">-- Pilih Kelompok --</option>
                                    @foreach($listKelompok as $key => $val)
                                        <option value="{{ $key }}" {{ $pelaku->kel_cabor == $val ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cabang Olahraga</label>
                                <select name="cabor" class="form-select cabor_edit" data-selected="{{ $pelaku->cabor }}" required>
                                    <option value="">-- Pilih Cabor --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kontingen (Kota/Kab)</label>
                                <select name="kontingen" class="form-select" required>
                                    <option value="">-- Pilih Kota --</option>
                                    @foreach($listKota as $key => $val)
                                        <option value="{{ $val }}" {{ $pelaku->kontingen == $val ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="col-md-6">
                                <label class="form-label">Bagian (Jabatan)</label>
                                <input type="text" name="bagian" class="form-control" value="{{ $pelaku->bagian }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">KONI Asal</label>
                                <input type="text" name="koni" class="form-control" value="{{ $pelaku->koni }}">
                            </div>
                        @endif

                        <div class="col-md-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ $pelaku->alamat }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Riwayat Cedera / Kesehatan</label>
                            <textarea name="riwayat_kesehatan" class="form-control" rows="2">{{ $pelaku->riwayat_kesehatan }}</textarea>
                        </div>
                        @if($kategori == 'atlit')
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Dokumen Terlampir</label>
                            @if($pelaku->dokumens && $pelaku->dokumens->count() > 0)
                                <div class="d-flex flex-column gap-2 mb-2">
                                    @foreach($pelaku->dokumens as $doc)
                                        <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light">
                                            <div>
                                                <i class="fas fa-file-alt text-primary me-2"></i>
                                                <a href="{{ asset($doc->file_path) }}" target="_blank" class="text-decoration-none">{{ $doc->nama_file }}</a>
                                            </div>
                                            <a href="#" onclick="event.preventDefault(); if(confirm('Hapus dokumen ini?')) document.getElementById('delete-doc-{{ $doc->id }}').submit();" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted small mb-2">Belum ada dokumen</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tambah Dokumen (Bisa lebih dari 1)</label>
                            <input type="file" name="dokumen[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple>
                            <small class="text-muted">Max 5MB per file</small>
                        </div>
                        @endif
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Foto Profil (Opsional)</label>
                            <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Max 2MB</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
            @if($pelaku->dokumens)
                @foreach($pelaku->dokumens as $doc)
                    <form id="delete-doc-{{ $doc->id }}" action="{{ route('dokumen.destroy', $doc->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endforeach

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('pelaku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kategori" value="{{ $kategori }}">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data {{ strtoupper($kategori) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jk" class="form-select" required>
                                <option value="L">Laki-laki (L)</option>
                                <option value="P">Perempuan (P)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Tempat, Tanggal Lahir (TTL)</label>
                            <input type="text" name="ttl" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control">
                        </div>

                        @if($kategori != 'koni')
                            <div class="col-md-4">
                                <label class="form-label">Kelompok Cabor</label>
                                <select name="kel_cabor" class="form-select" id="kel_cabor_create" required>
                                    <option value="">-- Pilih Kelompok --</option>
                                    @foreach($listKelompok as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cabang Olahraga</label>
                                <select name="cabor" class="form-select" id="cabor_create" required>
                                    <option value="">-- Pilih Cabor --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kontingen (Kota/Kab)</label>
                                <select name="kontingen" class="form-select" required>
                                    <option value="">-- Pilih Kota --</option>
                                    @foreach($listKota as $key => $val)
                                        <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="col-md-6">
                                <label class="form-label">Bagian (Jabatan)</label>
                                <input type="text" name="bagian" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">KONI Asal</label>
                                <input type="text" name="koni" class="form-control">
                            </div>
                        @endif

                        <div class="col-md-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Riwayat Cedera / Kesehatan</label>
                            <textarea name="riwayat_kesehatan" class="form-control" rows="2"></textarea>
                        </div>
                        @if($kategori == 'atlit')
                        <div class="col-md-6">
                            <label class="form-label">Dokumen Atlet (KTP/KK/BPJS)</label>
                            <input type="file" name="dokumen[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple>
                            <small class="text-muted">Max 5MB per file</small>
                        </div>
                        @endif
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Foto Profil (Opsional)</label>
                            <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Max 2MB</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="importModalLabel"><i class="fas fa-file-excel me-2"></i>Import Excel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pelaku.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small">
                        Gunakan template yang telah disediakan untuk memastikan format data sesuai. 
                        Pastikan Anda telah mengisi kolom wajib dan memilih opsi yang benar pada kolom dropdown.
                    </p>
                    <div class="mb-4">
                        <a href="{{ route('pelaku.template') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download me-2"></i>Unduh Template Excel
                        </a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload File Excel (.xlsx, .xls)</label>
                        <input type="file" name="file_excel" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload me-2"></i>Mulai Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const caborData = @json($listCabor);
    const kelompokData = @json($listKelompok);

    const kelCaborFilter = document.getElementById('kel_cabor_filter');
    if (kelCaborFilter) {
        kelCaborFilter.addEventListener('change', function() {
            const kel = this.value;
            const caborSelect = document.getElementById('cabor_filter');
            caborSelect.innerHTML = '<option value="">Semua Cabor</option>';
            if (kel && caborData[kel]) {
                for (const [code, name] of Object.entries(caborData[kel])) {
                    caborSelect.innerHTML += `<option value="${name}">${name}</option>`;
                }
            } else if (!kel) {
                for (const [k, cabors] of Object.entries(caborData)) {
                    let label = kelompokData[k] ? kelompokData[k] : k;
                    let optgroup = `<optgroup label="${label}">`;
                    for (const [code, name] of Object.entries(cabors)) {
                        optgroup += `<option value="${name}">${name}</option>`;
                    }
                    optgroup += `</optgroup>`;
                    caborSelect.innerHTML += optgroup;
                }
            }
        });
    }

    const kelCaborCreate = document.getElementById('kel_cabor_create');
    if (kelCaborCreate) {
        kelCaborCreate.addEventListener('change', function() {
            const kel = this.value;
            const caborSelect = document.getElementById('cabor_create');
            caborSelect.innerHTML = '<option value="">-- Pilih Cabor --</option>';
            if (kel && caborData[kel]) {
                for (const [code, name] of Object.entries(caborData[kel])) {
                    caborSelect.innerHTML += `<option value="${name}">${name}</option>`;
                }
            }
        });
    }

    document.querySelectorAll('.kel_cabor_edit').forEach(select => {
        select.addEventListener('change', function() {
            const form = this.closest('form');
            const caborSelect = form.querySelector('.cabor_edit');
            const kel = this.value;
            caborSelect.innerHTML = '<option value="">-- Pilih Cabor --</option>';
            if (kel && caborData[kel]) {
                for (const [code, name] of Object.entries(caborData[kel])) {
                    caborSelect.innerHTML += `<option value="${name}">${name}</option>`;
                }
            }
        });
    });

    // trigger change to load initial data in edit modal
    document.querySelectorAll('.kel_cabor_edit').forEach(select => {
        if(select.value) {
            const form = select.closest('form');
            const caborSelect = form.querySelector('.cabor_edit');
            const kel = select.value;
            const selectedCabor = caborSelect.getAttribute('data-selected');
            caborSelect.innerHTML = '<option value="">-- Pilih Cabor --</option>';
            if (kel && caborData[kel]) {
                for (const [code, name] of Object.entries(caborData[kel])) {
                    const isSelected = selectedCabor === name ? 'selected' : '';
                    caborSelect.innerHTML += `<option value="${name}" ${isSelected}>${name}</option>`;
                }
            }
        }
    });
</script>
@endpush
