@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Klinik KKPO se-Banten</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola direktori instansi dan klinik fasilitas kesehatan tingkat daerah.</p>
        </div>
        <div class="d-grid d-md-flex justify-content-md-end">
            <button class="btn btn-primary px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>TAMBAH DATA
            </button>
        </div>
    </div>

    <div class="mb-4">
        <form action="{{ route('kkpo-sebanten.index') }}" method="GET" class="d-flex gap-2" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari wadah / instansi..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Jaringan Klinik KKPO</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($data) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>KABUPATEN / KOTA</th>
                            <th>KETUA KKPO</th>
                            <th>NO SK PENGURUS</th>
                            <th>ALAMAT SEKRETARIAT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->wadah }}</strong></td>
                            <td>{{ $item->nama_personil }}</td>
                            <td>{{ $item->npp }}</td>
                            <td>{{ $item->alamat_kantor }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('kkpo-sebanten.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" style="display:inline;">
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
                                    <form action="{{ route('kkpo-sebanten.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Data KKPO Se-Banten</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Kabupaten / Kota</label>
                                                <input type="text" name="wadah" class="form-control" value="{{ $item->wadah }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Ketua KKPO</label>
                                                <input type="text" name="nama_personil" class="form-control" value="{{ $item->nama_personil }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nomor SK Kepengurusan</label>
                                                <input type="text" name="npp" class="form-control" value="{{ $item->npp }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Alamat Sekretariat</label>
                                                <textarea name="alamat_kantor" class="form-control" rows="3">{{ $item->alamat_kantor }}</textarea>
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
            <span style="color: #64748b; font-size: 0.85rem;">Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }}</span>
            <div>
                {{ $data->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('kkpo-sebanten.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data KKPO Se-Banten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kabupaten / Kota</label>
                        <input type="text" name="wadah" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ketua KKPO</label>
                        <input type="text" name="nama_personil" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor SK Kepengurusan</label>
                        <input type="text" name="npp" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Sekretariat</label>
                        <textarea name="alamat_kantor" class="form-control" rows="3"></textarea>
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
