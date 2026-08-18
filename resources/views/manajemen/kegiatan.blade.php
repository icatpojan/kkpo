@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Kegiatan KKPO</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola jadwal, lokasi, dan detail seluruh kegiatan KKPO secara terpusat.</p>
        </div>
        <div class="d-grid d-md-flex justify-content-md-end">
            <button class="btn btn-primary px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>TAMBAH KEGIATAN
            </button>
        </div>
    </div>

    <div class="mb-4">
        <form action="{{ route('kegiatan.index') }}" method="GET" class="d-flex gap-2" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama kegiatan..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Kegiatan Aktif</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($data) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA KEGIATAN</th>
                            <th>TANGGAL</th>
                            <th>LOKASI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->nama_kegiatan }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') }} {{ $item->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($item->tanggal_selesai)->format('d F Y') : '' }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-info action-btn" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning action-btn" data-bs-toggle="modal" data-bs-target="#jadwalListModal{{ $item->id }}" title="Lihat Jadwal Lomba">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data kegiatan ini?');" style="display:inline;">
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
        <div class="card-footer d-flex justify-content-between align-items-center" style="background:#fff; padding: 15px 24px; border-top: 1px solid #e2e8f0;">
            <span style="color: #64748b; font-size: 0.85rem;">Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }}</span>
            <div>
                {{ $data->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
</div>


@foreach($data as $item)
                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="border-radius: 12px; border: none;">
                                    <div class="modal-header" style="border-bottom: 1px solid #e2e8f0;">
                                        <h5 class="modal-title fw-bold" style="color: #0f172a;">Detail Kegiatan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-4">
                                            <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Nama Kegiatan</h6>
                                            <p class="fw-bold mb-0" style="color: #1e293b; font-size: 1.1rem;">{{ $item->nama_kegiatan }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Tanggal Pelaksanaan</h6>
                                            <p class="mb-0">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') }} {{ $item->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($item->tanggal_selesai)->format('d F Y') : '' }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <h6 class="text-muted mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Deskripsi</h6>
                                            <p class="mb-0">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid #e2e8f0;">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('kegiatan.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Kegiatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Kegiatan</label>
                                                <input type="text" name="nama_kegiatan" class="form-control" value="{{ $item->nama_kegiatan }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Mulai</label>
                                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $item->tanggal_mulai }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Selesai (Opsional)</label>
                                                <input type="date" name="tanggal_selesai" class="form-control" value="{{ $item->tanggal_selesai }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" name="lokasi" class="form-control" value="{{ $item->lokasi }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label d-block">Kegiatan Khusus</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_khusus" id="khusus_ya_{{ $item->id }}" value="1" {{ $item->is_khusus ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="khusus_ya_{{ $item->id }}">Ya</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_khusus" id="khusus_tidak_{{ $item->id }}" value="0" {{ !$item->is_khusus ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="khusus_tidak_{{ $item->id }}">Tidak</label>
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

                        <!-- Jadwal List Modal -->
                        <div class="modal fade" id="jadwalListModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header align-items-center">
                                        <h5 class="modal-title fw-bold mb-0">Jadwal Lomba: {{ $item->nama_kegiatan }}</h5>
                                        <button type="button" class="btn btn-primary btn-sm ms-auto me-3" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#createJadwalModal{{ $item->id }}">
                                            <i class="fas fa-plus me-1"></i> Tambah Jadwal Lomba
                                        </button>
                                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="table-responsive">
                                            <table class="table w-100 m-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>CABOR</th>
                                                        <th>VENUE</th>
                                                        <th>TANGGAL & WAKTU</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($item->jadwalPertandingans as $jadwal)
                                                    <tr>
                                                        <td><strong>{{ $jadwal->jenis_cabor }}</strong><br><small class="text-muted">{{ $jadwal->kel_cabor ?? '-' }}</small></td>
                                                        <td>{{ $jadwal->venue }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} {{ $jadwal->waktu }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted py-3">Belum ada jadwal lomba untuk kegiatan ini.</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Create Jadwal Modal -->
                        <div class="modal fade" id="createJadwalModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('jadwal-pertandingan.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kegiatan_id" value="{{ $item->id }}">
                                        
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Tambah Jadwal Lomba: {{ $item->nama_kegiatan }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Kelompok Cabor</label>
                                                    <select name="kel_cabor" class="form-select modal-kelompok-kegiatan">
                                                        <option value="" data-kode="">-- Pilih Kelompok --</option>
                                                        @foreach($kelompokCabors as $kc)
                                                            <option value="{{ $kc->nama }}" data-kode="{{ $kc->kode }}">{{ $kc->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Cabang Olahraga (Cabor)</label>
                                                    <select name="jenis_cabor" class="form-select modal-cabor-kegiatan" required>
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
                                                    <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal_mulai }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Waktu</label>
                                                    <input type="time" name="waktu" class="form-control" value="08:00" required>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label">Tim Nakes (Keterangan)</label>
                                                    <textarea name="nakes" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#jadwalListModal{{ $item->id }}">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
@endforeach

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('kegiatan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai (Opsional)</label>
                        <input type="date" name="tanggal_selesai" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block">Kegiatan Khusus</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_khusus" id="khusus_ya" value="1">
                            <label class="form-check-label" for="khusus_ya">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_khusus" id="khusus_tidak" value="0" checked>
                            <label class="form-check-label" for="khusus_tidak">Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kegiatan</button>
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

            if (!caborSelect.hasAttribute('data-original-options')) {
                const optionsHTML = Array.from(caborSelect.options).map(opt => opt.outerHTML).join('');
                caborSelect.setAttribute('data-original-options', optionsHTML);
            }

            function filterCabor() {
                const selectedKelompok = kelompokSelect.options[kelompokSelect.selectedIndex];
                const kelompokKode = selectedKelompok ? selectedKelompok.getAttribute('data-kode') : '';
                
                const originalOptionsHTML = caborSelect.getAttribute('data-original-options');
                
                const tempSelect = document.createElement('select');
                tempSelect.innerHTML = originalOptionsHTML;
                
                caborSelect.innerHTML = '';
                
                Array.from(tempSelect.options).forEach(opt => {
                    const caborKelompok = opt.getAttribute('data-kelompok');
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
                caborSelect.value = '';
            });

            filterCabor();
        }

        document.querySelectorAll('div[id^="createJadwalModal"]').forEach(modal => {
            const kelompokSelect = modal.querySelector('.modal-kelompok-kegiatan');
            const caborSelect = modal.querySelector('.modal-cabor-kegiatan');
            setupDependentDropdown(kelompokSelect, caborSelect);
        });
    });
</script>
@endpush
