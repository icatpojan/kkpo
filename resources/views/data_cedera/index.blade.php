@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Laporan Cedera</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Pantau riwayat cedera atlet, tindakan penanganan, dan status pemulihan.</p>
        </div>
        <button class="btn btn-primary px-4 py-2" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-2"></i>CATAT CEDERA BARU
        </button>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h5 class="mb-0" style="color: #0f172a; font-weight: 700; font-size: 1.05rem;">Log Kasus Cedera</h5>
            <span style="color: #64748b; font-size: 0.85rem; font-weight: 500;">{{ count($cederas) }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table w-100 m-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>WAKTU</th>
                            <th>NAMA</th>
                            <th>CABOR</th>
                            <th>KEL CABOR</th>
                            <th>KONTINGEN</th>
                            <th>VENUE</th>
                            <th>EVENT</th>
                            <th>BAGIAN CEDERA</th>
                            <th>KRONOLOGIS</th>
                            <th>PENANGANAN</th>
                            <th>KET</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cederas as $cedera)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($cedera->waktu_kejadian)->format('d M Y H:i') }}</td>
                            <td><strong>{{ $cedera->pelakuOlahraga->nama ?? '-' }}</strong></td>
                            <td>{{ $cedera->pelakuOlahraga->cabor ?? '-' }}</td>
                            <td>{{ $cedera->pelakuOlahraga->kel_cabor ?? '-' }}</td>
                            <td>{{ $cedera->pelakuOlahraga->kontingen ?? '-' }}</td>
                            <td>{{ $cedera->venue }}</td>
                            <td><strong>{{ $cedera->event }}</strong></td>
                            <td>{{ $cedera->bagian_cedera }}</td>
                            <td>{{ $cedera->kronologis }}</td>
                            <td>{{ $cedera->penanganan }}</td>
                            <td>
                                @if($cedera->status == 'rujuk')
                                    <span class="badge bg-danger">DI RUJUK</span>
                                @elseif($cedera->status == 'sembuh')
                                    <span class="badge bg-success">SEMBUH</span>
                                @else
                                    <span class="badge bg-warning text-dark">CEDERA</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <form action="{{ route('accident.rujuk', $cedera->id) }}" method="POST" onsubmit="return confirm('Rujuk pasien ini ke RS/Klinik?');">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-danger w-100 action-btn fw-bold">RUJUK</button>
                                    </form>
                                    <form action="{{ route('accident.sembuh', $cedera->id) }}" method="POST" onsubmit="return confirm('Pasien telah sembuh?');">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-success w-100 action-btn fw-bold">SEMBUH</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center" style="background:#fff; padding: 15px 24px; border-top: 1px solid #e2e8f0;">
            <span style="color: #64748b; font-size: 0.85rem;">Showing 1-{{ count($cederas) }} of {{ count($cederas) }}</span>
            @if(count($cederas) > 10)
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
            <form action="{{ route('accident.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Catat Data Cedera Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pelaku Olahraga</label>
                            <select name="pelaku_olahraga_id" class="form-select" required>
                                <option value="">Pilih Atlit/Pelatih...</option>
                                @foreach(\App\PelakuOlahraga::all() as $pelaku)
                                    <option value="{{ $pelaku->id }}">
                                        {{ $pelaku->nama }} ({{ ucfirst($pelaku->kategori) }} - {{ $pelaku->cabor ?? $pelaku->bagian }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu Kejadian</label>
                            <input type="datetime-local" name="waktu_kejadian" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Event/Kegiatan</label>
                            <input type="text" name="event" class="form-control" placeholder="Contoh: PORPROV 2026">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi (Venue)</label>
                            <input type="text" name="venue" class="form-control" placeholder="Contoh: GOR Basket Tangsel">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Bagian Cedera</label>
                            <input type="text" name="bagian_cedera" class="form-control" placeholder="Contoh: Engkel Kanan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penanganan Pertama</label>
                            <input type="text" name="penanganan" class="form-control" placeholder="Contoh: Kompres Es & Perban">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kronologis Kejadian</label>
                            <textarea name="kronologis" class="form-control" rows="3" placeholder="Jelaskan secara singkat bagaimana cedera terjadi..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Informasi lain yang diperlukan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data Cedera</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
