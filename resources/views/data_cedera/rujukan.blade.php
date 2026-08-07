@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Data Rujukan Medis</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola data rujukan atlet ke fasilitas kesehatan rujukan tingkat lanjut.</p>
        </div>
        
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Rujukan Eksternal</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($rujukans) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PASIEN (ATLIT/PELATIH)</th>
                            <th>WAKTU KEJADIAN</th>
                            <th>EVENT & VENUE</th>
                            <th>BAGIAN CEDERA</th>
                            <th>KRONOLOGIS</th>
                            <th>PENANGANAN AWAL</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rujukans as $rujuk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rujuk->pelakuOlahraga->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($rujuk->waktu_kejadian)->format('d M Y H:i') }}</td>
                            <td>
                                <strong>{{ $rujuk->event }}</strong><br>
                                <span class="text-muted small">{{ $rujuk->venue }}</span>
                            </td>
                            <td>{{ $rujuk->bagian_cedera }}</td>
                            <td>{{ $rujuk->kronologis }}</td>
                            <td>{{ $rujuk->penanganan }}</td>
                            <td>
                                <span class="badge bg-danger px-3 py-2 rounded-pill">DIRUJUK KE RS</span>
                            </td>
                            <td>
                                <form action="{{ route('accident.sembuh', $rujuk->id) }}" method="POST" onsubmit="return confirm('Pasien telah dinyatakan sembuh?');">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-success w-100 action-btn fw-bold"><i class="fas fa-check-circle"></i> SEMBUH</button>
                                </form>
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
            
            <div class="mt-3 text-end">
                <a href="{{ route('accident.cedera') }}" class="btn btn-outline-secondary px-4">LIHAT DATA CEDERA</a>
            </div>
        </div>
    </div>
</div>
@endsection
