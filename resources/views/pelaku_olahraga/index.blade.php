@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Data Pelaku Olahraga</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola rekam medis dan data profil seluruh atlet, pelatih, dan pelaku olahraga.</p>
        </div>
        <button class="btn btn-primary px-4 py-2" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-2"></i>TAMBAH DATA
        </button>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Active Roster & Medical Status</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($pelakus) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>L/P</th>
                            <th>TTL</th>
                            <th>NIK</th>
                            <th>NO WA</th>
                            @if($kategori != 'koni')
                                <th>CABOR</th>
                                <th>KEL CABOR</th>
                                <th>KONTINGEN</th>
                            @else
                                <th>BAGIAN</th>
                                <th>KONI</th>
                            @endif
                            <th>ALAMAT</th>
                            <th>RIWAYAT CEDERA / KESEHATAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelakus as $pelaku)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $pelaku->nama }}</strong></td>
                            <td>{{ $pelaku->jk }}</td>
                            <td>
                                @php
                                    $ttlParts = explode(',', $pelaku->ttl);
                                    $tempat = isset($ttlParts[0]) ? trim($ttlParts[0]) : '-';
                                    $tanggal = isset($ttlParts[1]) ? trim($ttlParts[1]) : '';
                                    try {
                                        $formattedTanggal = $tanggal ? \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') : '-';
                                    } catch (\Exception $e) {
                                        $formattedTanggal = $tanggal ?: '-';
                                    }
                                @endphp
                                <ul class="list-unstyled mb-0" style="font-size: 0.85rem; line-height: 1.6; white-space: nowrap;">
                                    <li><i class="fas fa-map-marker-alt text-muted me-2" style="width: 12px; text-align: center;"></i> {{ $tempat }}</li>
                                    <li><i class="fas fa-calendar-alt text-muted me-2" style="width: 12px; text-align: center;"></i> {{ $formattedTanggal }}</li>
                                </ul>
                            </td>
                            <td>{{ $pelaku->nik }}</td>
                            <td>{{ $pelaku->no_wa }}</td>
                            @if($kategori != 'koni')
                                <td>{{ $pelaku->cabor }}</td>
                                <td>{{ $pelaku->kel_cabor }}</td>
                                <td>{{ $pelaku->kontingen }}</td>
                            @else
                                <td>{{ $pelaku->bagian }}</td>
                                <td>{{ $pelaku->koni }}</td>
                            @endif
                            <td>{{ $pelaku->alamat }}</td>
                            <td>{{ $pelaku->riwayat_kesehatan }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $pelaku->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('pelaku.destroy', $pelaku->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger action-btn"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $pelaku->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('pelaku.update', $pelaku->id) }}" method="POST">
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
                                                        <label class="form-label">Cabang Olahraga</label>
                                                        <input type="text" name="cabor" class="form-control" value="{{ $pelaku->cabor }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Kelompok Cabor</label>
                                                        <input type="text" name="kel_cabor" class="form-control" value="{{ $pelaku->kel_cabor }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Kontingen</label>
                                                        <input type="text" name="kontingen" class="form-control" value="{{ $pelaku->kontingen }}">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center" style="background:#fff; padding: 15px 24px; border-top: 1px solid #e2e8f0;">
            <span style="color: #64748b; font-size: 0.85rem;">Showing 1-{{ count($pelakus) }} of {{ count($pelakus) }}</span>
            @if(count($pelakus) > 10)
            <div class="d-flex gap-3">
                <i class="fas fa-chevron-left" style="color: #0f172a; font-size: 0.8rem; cursor: pointer; opacity: 0.5;"></i>
                <i class="fas fa-chevron-right" style="color: #0f172a; font-size: 0.8rem; cursor: pointer;"></i>
            </div>
            @endif
        </div>
    </div>
</div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('pelaku.store') }}" method="POST">
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
                                <label class="form-label">Cabang Olahraga</label>
                                <input type="text" name="cabor" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kelompok Cabor</label>
                                <input type="text" name="kel_cabor" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kontingen</label>
                                <input type="text" name="kontingen" class="form-control">
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
@endsection
