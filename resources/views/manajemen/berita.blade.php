@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Berita & Pengumuman</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola publikasi berita, informasi terbaru, dan pengumuman untuk masyarakat.</p>
        </div>
        <div class="d-grid d-md-flex justify-content-md-end">
            <button class="btn btn-primary px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>TULIS BERITA
            </button>
        </div>
    </div>

    <div class="mb-4">
        <form action="{{ route('berita.index') }}" method="GET" class="d-flex gap-2" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari judul berita..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
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
                            <th style="width: 15%;">TANGGAL PUBLIKASI</th>
                            <th style="width: 10%;">GAMBAR</th>
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
                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light text-secondary" style="width: 50px; height: 50px; border-radius: 8px; font-size: 0.8rem;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit(strip_tags($item->konten), 100) }}</td>
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
                                    <form action="{{ route('berita.update', $item->id) }}" method="POST" enctype="multipart/form-data">
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
                                                <label class="form-label">Gambar Berita (Opsional)</label>
                                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                                @if($item->gambar)
                                                    <div class="mt-2">
                                                        <small class="text-muted d-block mb-1">Gambar saat ini:</small>
                                                        <img src="{{ asset($item->gambar) }}" alt="Current Image" style="max-height: 100px; border-radius: 8px;">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Konten Berita</label>
                                                <textarea name="konten" class="form-control summernote" rows="5" required>{{ $item->konten }}</textarea>
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
            <span style="color: #64748b; font-size: 0.85rem;">Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }}</span>
            <div>
                {{ $data->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label class="form-label">Gambar Berita (Opsional)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten Berita</label>
                        <textarea name="konten" class="form-control summernote" rows="5" required></textarea>
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

@stack('styles')
<!-- include summernote css -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@push('scripts')
<!-- include summernote js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush
