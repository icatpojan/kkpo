@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Berita & Pengumuman</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola publikasi berita, informasi terbaru, dan pengumuman untuk masyarakat.</p>
        </div>
        <button class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#createModal" style="border-radius: 6px;">
            <i class="fas fa-plus me-2"></i>Tambah Berita
        </button>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Publikasi Aktif</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($data) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">NO</th>
                            <th style="width: 25%;">JUDUL BERITA</th>
                            <th style="width: 20%;">TANGGAL PUBLIKASI</th>
                            <th>KONTEN</th>
                            <th class="text-end" style="width: 120px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->judul }}</strong></td>
                            <td>{{ $item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d F Y') : '-' }}</td>
                            <td>{{ Str::limit($item->konten, 100) }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger action-btn"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 8px; border: none;">
                                    <form action="{{ route('berita.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header" style="border-bottom: 1px solid #e2e8f0;">
                                            <h5 class="modal-title" style="font-weight: 700; color: #0f172a;">Edit Berita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label">Judul Berita</label>
                                                <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Publikasi</label>
                                                <input type="date" name="tanggal_publikasi" class="form-control" value="{{ $item->tanggal_publikasi }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Konten Berita</label>
                                                <textarea name="konten" class="form-control" rows="5" required>{{ $item->konten }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="border-top: 1px solid #e2e8f0;">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4" style="color: #64748b;">Belum ada data berita.</td>
                        </tr>
                        @endforelse
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('berita.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Berita</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Publikasi</label>
                        <input type="date" name="tanggal_publikasi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten Berita</label>
                        <textarea name="konten" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
