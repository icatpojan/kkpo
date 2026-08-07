@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Jadwal Nakes Jaga</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Atur jadwal penugasan dan shift tenaga kesehatan yang bertugas.</p>
        </div>
        <button class="btn btn-primary px-4 py-2" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-2"></i>TAMBAH JADWAL
        </button>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Tenaga Kesehatan Jaga</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($nakes) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>CABOR</th>
                            <th>VENUE</th>
                            <th>INSTANSI</th>
                            <th>NAMA KETUA TEAM</th>
                            <th>NO WA</th>
                            <th>PERSONIL</th>
                            <th>JUMLAH CEDERA</th>
                            <th>KET</th>
                            <th>UPLOAD ABSEN</th>
                            <th>UPLOAD FOTO</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nakes as $person)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($person->tanggal)->format('d M Y') }}</td>
                            <td>{{ $person->cabor }}</td>
                            <td>{{ $person->venue }}</td>
                            <td>{{ optional($person->nakes)->instansi ?: '-' }}</td>
                            <td><strong>{{ optional($person->nakes)->nama ?: 'N/A' }}</strong></td>
                            <td>{{ optional($person->nakes)->no_wa ?: '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($person->personil, 30) }}</td>
                            <td>{{ $person->jumlah_cedera }}</td>
                            <td>{{ $person->keterangan }}</td>
                            <td>
                                @if($person->upload_absen)
                                    <a href="{{ asset('storage/' . $person->upload_absen) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-file-alt"></i></a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($person->upload_foto)
                                    <a href="{{ asset('storage/' . $person->upload_foto) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-image"></i></a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $person->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('nakes-jaga.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Hapus data nakes ini?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger action-btn"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $person->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('nakes-jaga.update', $person->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Data Nakes</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal Jaga</label>
                                                    <input type="date" name="tanggal" class="form-control" value="{{ $person->tanggal }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Cabang Olahraga (Cabor)</label>
                                                    <input type="text" name="cabor" class="form-control" value="{{ $person->cabor }}" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Lokasi / Venue</label>
                                                    <input type="text" name="venue" class="form-control" value="{{ $person->venue }}" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label class="form-label">Pilih Ketua Tim Nakes</label>
                                                    <select name="nakes_id" class="form-select" required>
                                                        <option value="">-- Pilih Nakes --</option>
                                                        @foreach($master_nakes as $mn)
                                                            <option value="{{ $mn->id }}" {{ $person->nakes_id == $mn->id ? 'selected' : '' }}>{{ $mn->nama }} ({{ $mn->instansi }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Personil Anggota Tim</label>
                                                <textarea name="personil" class="form-control" rows="1">{{ $person->personil }}</textarea>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Jumlah Cedera</label>
                                                    <input type="number" name="jumlah_cedera" class="form-control" value="{{ $person->jumlah_cedera }}" min="0">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Keterangan (KET)</label>
                                                    <input type="text" name="keterangan" class="form-control" value="{{ $person->keterangan }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Upload Absen (PDF/Img)</label>
                                                    <input type="file" name="upload_absen" class="form-control">
                                                    @if($person->upload_absen)
                                                        <small class="text-success">File saat ini: <a href="{{ asset('storage/'.$person->upload_absen) }}" target="_blank">Lihat</a></small>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Upload Foto Kegiatan</label>
                                                    <input type="file" name="upload_foto" class="form-control">
                                                    @if($person->upload_foto)
                                                        <small class="text-success">File saat ini: <a href="{{ asset('storage/'.$person->upload_foto) }}" target="_blank">Lihat</a></small>
                                                    @endif
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
            <span style="color: #64748b; font-size: 0.85rem;">Showing 1-{{ count($nakes) }} of {{ count($nakes) }}</span>
            @if(count($nakes) > 10)
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
            <form action="{{ route('nakes-jaga.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Nakes Jaga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Jaga</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cabang Olahraga (Cabor)</label>
                            <input type="text" name="cabor" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Lokasi / Venue</label>
                            <input type="text" name="venue" class="form-control" required>
                        </div>
                    </div>
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
                    <div class="mb-3">
                        <label class="form-label">Personil Anggota Tim</label>
                        <textarea name="personil" class="form-control" rows="1"></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Cedera</label>
                            <input type="number" name="jumlah_cedera" class="form-control" value="0" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Keterangan (KET)</label>
                            <input type="text" name="keterangan" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Upload Absen (PDF/Img)</label>
                            <input type="file" name="upload_absen" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Foto Kegiatan</label>
                            <input type="file" name="upload_foto" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Nakes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
