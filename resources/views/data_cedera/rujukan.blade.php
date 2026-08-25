@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Data Rujukan Medis</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola data rujukan atlet ke fasilitas kesehatan rujukan tingkat lanjut.</p>
        </div>
    </div>

    <div class="mb-4">
        <form action="{{ route('accident.rujukan') }}" method="GET" class="d-flex gap-2" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama pasien rujukan..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Rujukan Eksternal</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ $rujukans->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0 text-nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PASIEN (ATLIT/PELATIH)</th>
                            <th>WAKTU KEJADIAN</th>
                            <th>BAGIAN CEDERA</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rujukans as $rujuk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $rujuk->pelakuOlahraga->nama ?? '-' }}</strong><br>
                                <span class="text-muted small">{{ $rujuk->pelakuOlahraga->kategori ?? '-' }} - {{ $rujuk->pelakuOlahraga->cabor ?? '-' }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($rujuk->waktu_kejadian)->format('d M Y H:i') }}</td>
                            <td>{{ $rujuk->bagian_cedera }}</td>
                            <td>
                                <span class="badge bg-danger px-3 py-2 rounded-pill">DIRUJUK KE RS</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 align-items-center">
                                    <button class="btn btn-sm btn-info text-white fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#detailModal{{ $rujuk->id }}">
                                        DETAIL
                                    </button>
                                    <form action="{{ route('accident.sembuh', $rujuk->id) }}" method="POST" onsubmit="return confirm('Pasien telah dinyatakan sembuh?');" class="m-0 p-0">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-success fw-bold" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">SEMBUH</button>
                                    </form>
                                </div>
                            </td>
                        </tr>


                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data pasien rujukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3 text-end p-3">
                <a href="{{ route('accident.cedera') }}" class="btn btn-outline-secondary px-4">LIHAT DATA CEDERA</a>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center" style="background:#fff; padding: 15px 24px; border-top: 1px solid #e2e8f0;">
            <span style="color: #64748b; font-size: 0.85rem;">Menampilkan {{ $rujukans->firstItem() ?? 0 }} - {{ $rujukans->lastItem() ?? 0 }} dari {{ $rujukans->total() }}</span>
            <div>
                {{ $rujukans->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@foreach($rujukans as $rujuk)
<!-- Detail Modal -->
<div class="modal fade" id="detailModal{{ $rujuk->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Pasien Rujukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-sm m-0">
                    <tr>
                        <th width="40%" class="text-muted">Nama Pasien</th>
                        <td>{{ $rujuk->pelakuOlahraga->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Waktu Kejadian</th>
                        <td>{{ \Carbon\Carbon::parse($rujuk->waktu_kejadian)->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Event & Venue</th>
                        <td>{{ $rujuk->event }} di {{ $rujuk->venue }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Bagian Cedera</th>
                        <td>{{ $rujuk->bagian_cedera }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Kronologis</th>
                        <td>{{ $rujuk->kronologis ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Penanganan Awal</th>
                        <td>{{ $rujuk->penanganan ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Keterangan</th>
                        <td>{{ $rujuk->keterangan ?: '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
