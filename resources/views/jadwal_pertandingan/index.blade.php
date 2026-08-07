@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Jadwal Pertandingan</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Pantau dan kelola jadwal pertandingan untuk memastikan kesiapan tim medis.</p>
        </div>
        <button class="btn btn-primary px-4 py-2" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-2"></i>TAMBAH JADWAL
        </button>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Daftar Pertandingan</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($jadwals) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>CABOR</th>
                            <th>KEL. CABOR</th>
                            <th>VENUE</th>
                            <th>TANGGAL & WAKTU</th>
                            <th>LAPANGAN</th>
                            <th>TIM NAKES</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $jadwal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $jadwal->jenis_cabor }}</strong></td>
                            <td>{{ $jadwal->kel_cabor }}</td>
                            <td>{{ $jadwal->venue }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} {{ $jadwal->waktu }}</td>
                            <td>{{ $jadwal->jumlah_lapangan }}</td>
                            <td>{{ $jadwal->nakes }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $jadwal->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('jadwal-pertandingan.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger action-btn"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $jadwal->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('jadwal-pertandingan.update', $jadwal->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Jadwal Pertandingan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Cabang Olahraga (Cabor)</label>
                                                    <input type="text" name="jenis_cabor" class="form-control" value="{{ $jadwal->jenis_cabor }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kelompok Cabor</label>
                                                    <input type="text" name="kel_cabor" class="form-control" value="{{ $jadwal->kel_cabor }}">
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label">Venue / Lokasi</label>
                                                    <input type="text" name="venue" class="form-control" value="{{ $jadwal->venue }}" required>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Jumlah Lapangan</label>
                                                    <input type="number" name="jumlah_lapangan" class="form-control" value="{{ $jadwal->jumlah_lapangan }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal" class="form-control" value="{{ $jadwal->tanggal }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Waktu</label>
                                                    <input type="time" name="waktu" class="form-control" value="{{ $jadwal->waktu }}" required>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label">Tim Nakes (Keterangan)</label>
                                                    <textarea name="nakes" class="form-control" rows="2">{{ $jadwal->nakes }}</textarea>
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
            <span style="color: #64748b; font-size: 0.85rem;">Showing 1-{{ count($jadwals) }} of {{ count($jadwals) }}</span>
            @if(count($jadwals) > 10)
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
            <form action="{{ route('jadwal-pertandingan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Jadwal Pertandingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Cabang Olahraga (Cabor)</label>
                            <input type="text" name="jenis_cabor" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelompok Cabor</label>
                            <input type="text" name="kel_cabor" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Venue / Lokasi</label>
                            <input type="text" name="venue" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Jumlah Lapangan</label>
                            <input type="number" name="jumlah_lapangan" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Waktu</label>
                            <input type="time" name="waktu" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Tim Nakes (Keterangan)</label>
                            <textarea name="nakes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
