@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Jadwal Pertandingan</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola seluruh jadwal kegiatan cabang olahraga dalam Pekan Olahraga.</p>
        </div>
        <div class="d-grid d-md-flex justify-content-md-end">
            <button class="btn btn-primary px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>TAMBAH JADWAL
            </button>
        </div>
    </div>

    <div class="mb-4 bg-white p-3 rounded border border-light">
        <form action="{{ route('jadwal-pertandingan.index') }}" method="GET">
            <div class="row g-2">
                <div class="col-lg-3 col-md-6">
                    <input type="text" name="filter_kegiatan" class="form-control" placeholder="Cari Kegiatan..." value="{{ request('filter_kegiatan') }}">
                </div>
                <div class="col-lg-2 col-md-6">
                    <select name="filter_kelompok_cabor" class="form-select filter-kelompok">
                        <option value="" data-kode="">Semua Kelompok...</option>
                        @foreach($kelompokCabors as $kc)
                            <option value="{{ $kc->nama }}" data-kode="{{ $kc->kode }}" {{ request('filter_kelompok_cabor') == $kc->nama ? 'selected' : '' }}>{{ $kc->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <select name="filter_cabor" class="form-select filter-cabor">
                        <option value="">Semua Cabor...</option>
                        @foreach($cabors as $c)
                            <option value="{{ $c->nama }}" data-kelompok="{{ $c->kelompok_kode }}" {{ request('filter_cabor') == $c->nama ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <input type="date" name="filter_tanggal" class="form-control" value="{{ request('filter_tanggal') }}" placeholder="Pilih Tanggal">
                </div>
                <div class="col-lg-2 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary flex-fill"><i class="fas fa-search me-1"></i> Filter</button>
                    @if(request('filter_kegiatan') || request('filter_cabor') || request('filter_kelompok_cabor') || request('filter_tanggal'))
                        <a href="{{ route('jadwal-pertandingan.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Pertandingan</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($jadwals) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>KEGIATAN</th>
                            <th>CABOR</th>
                            <th>TANGGAL & WAKTU</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $jadwal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $jadwal->kegiatan->nama_kegiatan ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $jadwal->kegiatan ? \Carbon\Carbon::parse($jadwal->kegiatan->tanggal)->format('Y') : '' }}</small>
                            </td>
                            <td><strong>{{ $jadwal->jenis_cabor }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} {{ $jadwal->waktu }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-info action-btn" data-bs-toggle="modal" data-bs-target="#detailModal{{ $jadwal->id }}" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success action-btn" data-bs-toggle="modal" data-bs-target="#listNakesJagaModal{{ $jadwal->id }}" title="Daftar Penugasan Nakes">
                                        <i class="fas fa-user-nurse"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $jadwal->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('jadwal-pertandingan.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger action-btn"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="background:#fff; padding: 15px 24px; border-top: 1px solid #e2e8f0;">
            <span style="color: #64748b; font-size: 0.85rem;" class="text-center text-md-start">Menampilkan {{ $jadwals->firstItem() ?? 0 }} - {{ $jadwals->lastItem() ?? 0 }} dari {{ $jadwals->total() }}</span>
            <div class="overflow-auto w-100 d-flex justify-content-center justify-content-md-end">
                {{ $jadwals->withQueryString()->links() }}
            </div>
        </div>
    </div>

    @foreach($jadwals as $jadwal)

                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal{{ $jadwal->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="border-radius: 12px; border: none;">
                                    <div class="modal-header" style="border-bottom: 1px solid #e2e8f0;">
                                        <h5 class="modal-title fw-bold" style="color: #0f172a;">Detail Pertandingan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-4">
                                            <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Kegiatan & Waktu</h6>
                                            <p class="fw-bold mb-0" style="color: #1e293b; font-size: 1.1rem;">{{ $jadwal->kegiatan->nama_kegiatan ?? '-' }}</p>
                                            <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y') }} - {{ $jadwal->waktu }}</p>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Cabor</h6>
                                                <p class="mb-0 fw-bold">{{ $jadwal->jenis_cabor }}</p>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Kelompok</h6>
                                                <p class="mb-0">{{ $jadwal->kel_cabor ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Lokasi Venue</h6>
                                            <p class="mb-0">{{ $jadwal->venue }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Tim Nakes Bertugas</h6>
                                            <p class="mb-0">{{ $jadwal->nakes ?? 'Belum ada tim nakes' }}</p>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Jumlah Lapangan</h6>
                                            <p class="mb-0">{{ $jadwal->jumlah_lapangan ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid #e2e8f0;">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $jadwal->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('jadwal-pertandingan.update', $jadwal->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Jadwal Pertandingan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label class="form-label">Kegiatan</label>
                                                    <select name="kegiatan_id" class="form-select" required>
                                                        <option value="">-- Pilih Kegiatan --</option>
                                                        @foreach($kegiatans as $keg)
                                                            <option value="{{ $keg->id }}" {{ $jadwal->kegiatan_id == $keg->id ? 'selected' : '' }}>
                                                                {{ $keg->nama_kegiatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kelompok Cabor</label>
                                                    <select name="kel_cabor" class="form-select modal-kelompok">
                                                        <option value="" data-kode="">-- Pilih Kelompok --</option>
                                                        @foreach($kelompokCabors as $kc)
                                                            <option value="{{ $kc->nama }}" data-kode="{{ $kc->kode }}" {{ $jadwal->kel_cabor == $kc->nama ? 'selected' : '' }}>{{ $kc->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Cabang Olahraga (Cabor)</label>
                                                    <select name="jenis_cabor" class="form-select modal-cabor" required>
                                                        <option value="">-- Pilih Cabor --</option>
                                                        @foreach($cabors as $c)
                                                            <option value="{{ $c->nama }}" data-kelompok="{{ $c->kelompok_kode }}" {{ $jadwal->jenis_cabor == $c->nama ? 'selected' : '' }}>{{ $c->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label">Venue / Lokasi</label>
                                                    <input type="text" name="venue" class="form-control" value="{{ $jadwal->venue }}" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Alamat Lengkap</label>
                                                    <textarea name="alamat" class="form-control" rows="2">{{ $jadwal->alamat }}</textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Link Google Map</label>
                                                    <input type="url" name="link_google_map" class="form-control" value="{{ $jadwal->link_google_map }}" placeholder="https://maps.google.com/...">
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Jumlah Lapangan</label>
                                                    <input type="number" name="jumlah_lapangan" class="form-control" value="{{ $jadwal->jumlah_lapangan }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal" class="form-control" value="{{ $jadwal->tanggal }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Waktu</label>
                                                    <input type="time" name="waktu" class="form-control" value="{{ $jadwal->waktu }}" required>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label">Tim Nakes (Keterangan)</label>
                                                    <textarea name="nakes" class="form-control" rows="2">{{ $jadwal->nakes }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- List Nakes Jaga Modal -->
                        <div class="modal fade" id="listNakesJagaModal{{ $jadwal->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Daftar Penugasan Nakes</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <div class="alert alert-info py-2 mb-3">
                                            <strong>Kegiatan:</strong> {{ $jadwal->kegiatan->nama_kegiatan ?? '-' }}<br>
                                            <strong>Cabor:</strong> {{ $jadwal->jenis_cabor }}<br>
                                            <strong>Tanggal & Waktu:</strong> {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y') }} - {{ $jadwal->waktu }}<br>
                                            <strong>Lokasi:</strong> {{ $jadwal->venue }}
                                        </div>
                                        <div class="d-flex justify-content-end mb-3">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formNakesJagaModal{{ $jadwal->id }}">
                                                <i class="fas fa-plus me-1"></i> Tambah Penugasan
                                            </button>
                                        </div>
                                        <div class="card border-0 shadow-sm rounded-4">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>NO</th>
                                                                <th>KETUA TIM</th>
                                                                <th>INSTANSI</th>
                                                                <th>LINI 1</th>
                                                                <th>LINI 2</th>
                                                                <th>LINI 3</th>
                                                                <th>AKSI</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($jadwal->nakesJagas as $nj)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $nj->nakes->nama ?? '-' }}</td>
                                                                    <td>{{ $nj->instansi ?? '-' }}</td>
                                                                    <td>{{ $nj->lini1 ?? '-' }}</td>
                                                                    <td>{{ $nj->lini2 ?? '-' }}</td>
                                                                    <td>{{ $nj->lini3 ?? '-' }}</td>
                                                                    <td>
                                                                        <form action="{{ route('nakes-jaga.destroy', $nj->id) }}" method="POST" onsubmit="return confirm('Hapus penugasan ini?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada penugasan nakes untuk jadwal ini.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
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

                        <!-- Tambah Nakes Jaga Modal -->
                        <div class="modal fade" id="formNakesJagaModal{{ $jadwal->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('nakes-jaga.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="jadwal_pertandingan_id" value="{{ $jadwal->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Tambah Penugasan Nakes</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-light">
                                            <div class="alert alert-info py-2 mb-3">
                                                <strong>Kegiatan:</strong> {{ $jadwal->kegiatan->nama_kegiatan ?? '-' }}<br>
                                                <strong>Cabor:</strong> {{ $jadwal->jenis_cabor }}<br>
                                                <strong>Tanggal & Waktu:</strong> {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y') }} - {{ $jadwal->waktu }}<br>
                                                <strong>Lokasi:</strong> {{ $jadwal->venue }}
                                            </div>
                                            <div class="card border-0 shadow-sm rounded-4 mb-3">
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label class="form-label">Pilih Ketua Tim Nakes</label>
                                                            <select name="nakes_id" class="form-select" required>
                                                                <option value="">-- Pilih Nakes --</option>
                                                                @foreach($master_nakes as $mn)
                                                                    <option value="{{ $mn->id }}">{{ $mn->nama }} ({{ $mn->instansi }})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Instansi (Tim)</label>
                                                            <input type="text" name="instansi" class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Lini 1</label>
                                                            <input type="text" name="lini1" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Lini 2</label>
                                                            <input type="text" name="lini2" class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Lini 3</label>
                                                            <input type="text" name="lini3" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#listNakesJagaModal{{ $jadwal->id }}">Kembali</button>
                                            <button type="submit" class="btn btn-primary">Simpan Nakes Jaga</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
</div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('jadwal-pertandingan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Jadwal Pertandingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Kegiatan</label>
                            <select name="kegiatan_id" class="form-select" required>
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach($kegiatans as $keg)
                                    <option value="{{ $keg->id }}">
                                        {{ $keg->nama_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelompok Cabor</label>
                            <select name="kel_cabor" class="form-select modal-kelompok">
                                <option value="" data-kode="">-- Pilih Kelompok --</option>
                                @foreach($kelompokCabors as $kc)
                                    <option value="{{ $kc->nama }}" data-kode="{{ $kc->kode }}">{{ $kc->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cabang Olahraga (Cabor)</label>
                            <select name="jenis_cabor" class="form-select modal-cabor" required>
                                <option value="">-- Pilih Cabor --</option>
                                @foreach($cabors as $c)
                                    <option value="{{ $c->nama }}" data-kelompok="{{ $c->kelompok_kode }}">{{ $c->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Venue / Lokasi</label>
                            <input type="text" name="venue" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Link Google Map</label>
                            <input type="url" name="link_google_map" class="form-control" placeholder="https://maps.google.com/...">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Jumlah Lapangan</label>
                            <input type="number" name="jumlah_lapangan" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Waktu</label>
                            <input type="time" name="waktu" class="form-control" value="{{ date('H:i') }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Tim Nakes (Keterangan)</label>
                            <textarea name="nakes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupDependentDropdown(kelompokSelect, caborSelect) {
            if (!kelompokSelect || !caborSelect) return;

            // Store original options once
            if (!caborSelect.hasAttribute('data-original-options')) {
                const optionsHTML = Array.from(caborSelect.options).map(opt => opt.outerHTML).join('');
                caborSelect.setAttribute('data-original-options', optionsHTML);
            }

            function filterCabor() {
                const selectedKelompok = kelompokSelect.options[kelompokSelect.selectedIndex];
                const kelompokKode = selectedKelompok ? selectedKelompok.getAttribute('data-kode') : '';
                
                const originalOptionsHTML = caborSelect.getAttribute('data-original-options');
                
                // Create a temporary select to parse and filter the options
                const tempSelect = document.createElement('select');
                tempSelect.innerHTML = originalOptionsHTML;
                
                // Clear current options
                caborSelect.innerHTML = '';
                
                Array.from(tempSelect.options).forEach(opt => {
                    const caborKelompok = opt.getAttribute('data-kelompok');
                    // Always append the placeholder
                    if (opt.value === "") {
                        caborSelect.appendChild(opt.cloneNode(true));
                    } 
                    else if (!kelompokKode || caborKelompok === kelompokKode) {
                        caborSelect.appendChild(opt.cloneNode(true));
                    }
                });
            }

            kelompokSelect.addEventListener('change', function() {
                filterCabor();
                // Reset cabor selection when kelompok changes
                caborSelect.value = '';
            });

            // Initial filter on load (useful for Edit Modal and Filters)
            filterCabor();
            
            // Restore original selected value if it was set (for edit modal on load)
            const originalVal = caborSelect.getAttribute('data-selected-val');
            if (originalVal) {
                // Set timeout to ensure options are fully populated before setting value
                setTimeout(() => { caborSelect.value = originalVal; }, 10);
            }
        }

        // Setup filter section
        setupDependentDropdown(
            document.querySelector('.filter-kelompok'),
            document.querySelector('.filter-cabor')
        );

        // Setup create modal
        setupDependentDropdown(
            document.querySelector('#createModal .modal-kelompok'),
            document.querySelector('#createModal .modal-cabor')
        );

        // Setup all edit modals
        document.querySelectorAll('div[id^="editModal"]').forEach(modal => {
            const kelompokSelect = modal.querySelector('.modal-kelompok');
            const caborSelect = modal.querySelector('.modal-cabor');
            
            if (caborSelect) {
                // Save the initially selected value to restore after initial filtering
                caborSelect.setAttribute('data-selected-val', caborSelect.value);
            }
            
            setupDependentDropdown(kelompokSelect, caborSelect);
        });
    });
</script>
@endpush
