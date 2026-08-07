@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Master Data Nakes</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola data profil seluruh tenaga kesehatan (Nakes).</p>
        </div>
        <button class="btn btn-primary px-4 py-2" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-2"></i>TAMBAH DATA
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Tenaga Kesehatan</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($nakes) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA LENGKAP</th>
                            <th>SPESIALISASI</th>
                            <th>NO. STR</th>
                            <th>INSTANSI ASAL</th>
                            <th>NO. WHATSAPP</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nakes as $person)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $person->nama }}</strong></td>
                            <td>{{ $person->spesialisasi }}</td>
                            <td>{{ $person->no_str ?: '-' }}</td>
                            <td>{{ $person->instansi ?: '-' }}</td>
                            <td>{{ $person->no_wa ?: '-' }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $person->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('master-nakes.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Hapus data nakes ini?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger action-btn"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $person->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('master-nakes.update', $person->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Data Nakes</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Lengkap Nakes</label>
                                                <input type="text" name="nama" class="form-control" value="{{ $person->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Spesialisasi Profesi</label>
                                                <input type="text" name="spesialisasi" class="form-control" value="{{ $person->spesialisasi }}" required>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nomor STR</label>
                                                    <input type="text" name="no_str" class="form-control" value="{{ $person->no_str }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">No. WhatsApp</label>
                                                    <input type="text" name="no_wa" class="form-control" value="{{ $person->no_wa }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Instansi / Asal Klinik</label>
                                                <input type="text" name="instansi" class="form-control" value="{{ $person->instansi }}">
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
            @if(count($nakes) == 0)
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3 text-light"></i>
                    <p>Belum ada data Nakes.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master-nakes.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data Nakes Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap Nakes</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Spesialisasi Profesi</label>
                        <input type="text" name="spesialisasi" class="form-control" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor STR</label>
                            <input type="text" name="no_str" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instansi / Asal Klinik</label>
                        <input type="text" name="instansi" class="form-control">
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
