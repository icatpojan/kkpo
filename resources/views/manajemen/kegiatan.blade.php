@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Kegiatan KKPO</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola jadwal, lokasi, dan detail seluruh kegiatan KKPO secara terpusat.</p>
        </div>
        <button class="btn btn-primary px-4 py-2" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-2"></i>TAMBAH KEGIATAN
        </button>
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
                            <th>DESKRIPSI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->nama_kegiatan }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>
                                <div class="d-flex gap-1">
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
                                                <label class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" name="lokasi" class="form-control" value="{{ $item->lokasi }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
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
            <span style="color: #64748b; font-size: 0.85rem;">Showing 1-{{ count($data) }} of {{ count($data) }}</span>
            @if(count($data) > 10)
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
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
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
