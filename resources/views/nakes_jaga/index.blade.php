@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Penugasan Nakes Jaga</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Atur dan kelola penugasan tenaga kesehatan di setiap pertandingan.</p>
        </div>
        <div class="d-grid d-md-flex justify-content-md-end">
            <button class="btn btn-primary px-4 py-2 text-nowrap" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>TAMBAH JADWAL
            </button>
        </div>
    </div>

    <div class="mb-4">
        <form action="{{ route('nakes-jaga.index') }}" method="GET" class="d-flex gap-2" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau personil..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
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
                            <th>CABOR / VENUE</th>
                            <th>INSTANSI</th>
                            <th>NAMA KETUA TEAM</th>
                            <th>ABSENSI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nakes as $person)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($person->tanggal)->format('d M Y') }}</td>
                            <td>{{ $person->cabor }}<br><small class="text-muted">{{ $person->venue }}</small></td>
                            <td>{{ $person->instansi ?: '-' }}</td>
                            <td><strong>{{ optional($person->nakes)->nama ?: 'N/A' }}</strong></td>
                            <td>
                                <button class="btn btn-sm btn-primary action-btn position-relative" data-bs-toggle="modal" data-bs-target="#absenModal{{ $person->id }}">
                                    <i class="fas fa-users"></i>
                                    @if($person->absens->count() > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            {{ $person->absens->count() }}
                                        </span>
                                    @endif
                                </button>
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-info action-btn" data-bs-toggle="modal" data-bs-target="#detailModal{{ $person->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center" style="background:#fff; padding: 15px 24px; border-top: 1px solid #e2e8f0;">
            <span style="color: #64748b; font-size: 0.85rem;">Menampilkan {{ $nakes->firstItem() ?? 0 }} - {{ $nakes->lastItem() ?? 0 }} dari {{ $nakes->total() }}</span>
            <div>
                {{ $nakes->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
</div>

@foreach($nakes as $person)
                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal{{ $person->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Detail Jadwal Jaga</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Lini 1:</strong> {{ $person->lini1 ?: '-' }}</li>
                                            <li class="list-group-item"><strong>Lini 2:</strong> {{ $person->lini2 ?: '-' }}</li>
                                            <li class="list-group-item"><strong>Lini 3:</strong> {{ $person->lini3 ?: '-' }}</li>
                                            <li class="list-group-item"><strong>No WA Ketua:</strong> {{ optional($person->nakes)->no_wa ?: '-' }}</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                                <div class="col-md-12">
                                                    <label class="form-label">Pilih Jadwal Lomba</label>
                                                    <select name="jadwal_pertandingan_id" class="form-select jadwal-lomba-edit" required>
                                                        <option value="">-- Pilih Jadwal Lomba --</option>
                                                        @foreach($jadwals as $jadwal)
                                                            <option value="{{ $jadwal->id }}" data-tanggal="{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d') }}" data-venue="{{ $jadwal->venue }}" data-cabor="{{ $jadwal->jenis_cabor }}" data-kel="{{ $jadwal->kel_cabor }}" {{ $person->jadwal_pertandingan_id == $jadwal->id ? 'selected' : '' }}>
                                                                {{ optional($jadwal->kegiatan)->nama_kegiatan }} - {{ $jadwal->jenis_cabor }} ({{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }})
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Instansi (Tim)</label>
                                                    <input type="text" name="instansi" class="form-control" value="{{ $person->instansi }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Lini 1</label>
                                                    <input type="text" name="lini1" class="form-control" value="{{ $person->lini1 }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Lini 2</label>
                                                    <input type="text" name="lini2" class="form-control" value="{{ $person->lini2 }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Lini 3</label>
                                                    <input type="text" name="lini3" class="form-control" value="{{ $person->lini3 }}">
                                                </div>
                                            </div>
                                                    @if($person->upload_foto)
                                                        <small class="text-success">File saat ini: <a href="{{ asset('storage/'.$person->upload_foto) }}" target="_blank">Lihat</a></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Absen Modal -->
                        <div class="modal fade" id="absenModal{{ $person->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Data Absensi: {{ \Carbon\Carbon::parse($person->tanggal)->format('d M Y') }} - {{ $person->cabor }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="card border-0 shadow-sm rounded-4 mb-3">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-3">Daftar Kehadiran</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered mb-0">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th>NO</th>
                                                                        <th>NAMA</th>
                                                                        <th>INSTANSI/TIM</th>
                                                                        <th>KETERANGAN</th>
                                                                        <th>BANK / NOREK</th>
                                                                        <th>TTD</th>
                                                                        <th>FOTO</th>
                                                                        <th>WAKTU</th>
                                                                        <th>AKSI</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($person->absens as $absen)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td><strong>{{ $absen->nama }}</strong></td>
                                                                        <td>{{ $absen->instansi ?: '-' }}</td>
                                                                        <td>{{ $absen->keterangan ?: '-' }}</td>
                                                                        <td>
                                                                            @if($absen->bank || $absen->norek)
                                                                                <strong>{{ $absen->bank }}</strong><br>
                                                                                <small>{{ $absen->norek }}</small>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($absen->tanda_tangan)
                                                                                <a href="{{ asset('storage/'.$absen->tanda_tangan) }}" target="_blank"><img src="{{ asset('storage/'.$absen->tanda_tangan) }}" width="60" style="background:#fff;" class="rounded border"></a>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($absen->foto)
                                                                                <a href="{{ asset('storage/'.$absen->foto) }}" target="_blank"><img src="{{ asset('storage/'.$absen->foto) }}" width="40" class="rounded"></a>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $absen->created_at->format('H:i') }}</td>
                                                                        <td>
                                                                            <form action="{{ route('nakes-jaga.absen.destroy', $absen->id) }}" method="POST" onsubmit="return confirm('Hapus absen ini?');">
                                                                                @csrf @method('DELETE')
                                                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr><td colspan="7" class="text-center text-muted">Belum ada data absensi.</td></tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card border-0 shadow-sm rounded-4">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-3">Tambah Absensi Baru</h6>
                                                        <form action="{{ route('nakes-jaga.absen.store', $person->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="mb-2">
                                                                <label class="form-label" style="font-size: 0.85rem;">Nama Lengkap</label>
                                                                <input type="text" name="nama" class="form-control form-control-sm" required>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="form-label" style="font-size: 0.85rem;">Instansi / Tim</label>
                                                                <input type="text" name="instansi" class="form-control form-control-sm">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-2">
                                                                    <label class="form-label" style="font-size: 0.85rem;">Bank</label>
                                                                    <input type="text" name="bank" class="form-control form-control-sm" placeholder="BCA / Mandiri / dll">
                                                                </div>
                                                                <div class="col-md-6 mb-2">
                                                                    <label class="form-label" style="font-size: 0.85rem;">No. Rekening</label>
                                                                    <input type="text" name="norek" class="form-control form-control-sm">
                                                                </div>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="form-label" style="font-size: 0.85rem;">Keterangan</label>
                                                                <textarea name="keterangan" class="form-control form-control-sm" rows="2"></textarea>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="form-label" style="font-size: 0.85rem;">Foto Kehadiran (Opsional)</label>
                                                                <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" style="font-size: 0.85rem;">Tanda Tangan</label>
                                                                <div class="border rounded bg-light" style="position: relative;">
                                                                    <canvas id="signatureCanvas{{ $person->id }}" style="width: 100%; height: 150px; cursor: crosshair; touch-action: none;"></canvas>
                                                                </div>
                                                                <div class="mt-2 text-end">
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearSignature({{ $person->id }})"><i class="fas fa-eraser me-1"></i> Bersihkan</button>
                                                                </div>
                                                                <input type="hidden" name="tanda_tangan_base64" id="tandaTanganBase64{{ $person->id }}">
                                                            </div>
                                                            <button class="btn btn-primary btn-sm w-100 fw-bold">SIMPAN ABSEN</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

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
                        <div class="col-md-12">
                            <label class="form-label">Pilih Jadwal Lomba</label>
                            <select name="jadwal_pertandingan_id" class="form-select" id="jadwal_lomba_create" required>
                                <option value="">-- Pilih Jadwal Lomba --</option>
                                @foreach($jadwals as $jadwal)
                                    <option value="{{ $jadwal->id }}" data-tanggal="{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d') }}" data-venue="{{ $jadwal->venue }}" data-cabor="{{ $jadwal->jenis_cabor }}" data-kel="{{ $jadwal->kel_cabor }}">
                                        {{ optional($jadwal->kegiatan)->nama_kegiatan }} - {{ $jadwal->jenis_cabor }} ({{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Instansi (Tim)</label>
                            <input type="text" name="instansi" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lini 1</label>
                            <input type="text" name="lini1" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Lini 2</label>
                            <input type="text" name="lini2" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lini 3</label>
                            <input type="text" name="lini3" class="form-control">
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

@push('scripts')
<script>
    const sigCtxs = {};
    const sigCanvases = {};
    const isDrawings = {};
    
    function initSignatureCanvas(id) {
        if(sigCanvases[id]) return; // Already initialized
        
        const canvas = document.getElementById('signatureCanvas' + id);
        if(!canvas) return;
        
        const ctx = canvas.getContext('2d');
        const inputBase64 = document.getElementById('tandaTanganBase64' + id);
        
        sigCanvases[id] = canvas;
        sigCtxs[id] = ctx;
        isDrawings[id] = false;
        
        function resizeCanvas() {
            const ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            ctx.scale(ratio, ratio);
        }
        
        resizeCanvas();
        
        function getMousePos(canvasDom, mouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: mouseEvent.clientX - rect.left,
                y: mouseEvent.clientY - rect.top
            };
        }

        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }

        canvas.addEventListener("mousedown", function (e) {
            isDrawings[id] = true;
            var mousePos = getMousePos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(mousePos.x, mousePos.y);
            e.preventDefault();
        }, false);
        
        canvas.addEventListener("mouseup", function (e) { 
            isDrawings[id] = false; 
            inputBase64.value = canvas.toDataURL('image/png'); 
        }, false);
        
        canvas.addEventListener("mousemove", function (e) {
            if (isDrawings[id]) {
                var mousePos = getMousePos(canvas, e);
                ctx.lineTo(mousePos.x, mousePos.y);
                ctx.stroke();
            }
            e.preventDefault();
        }, false);
        
        canvas.addEventListener("touchstart", function (e) {
            isDrawings[id] = true;
            var touchPos = getTouchPos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(touchPos.x, touchPos.y);
            e.preventDefault();
        }, false);
        
        canvas.addEventListener("touchend", function (e) { 
            isDrawings[id] = false; 
            inputBase64.value = canvas.toDataURL('image/png'); 
        }, false);
        
        canvas.addEventListener("touchmove", function (e) {
            if (isDrawings[id]) {
                var touchPos = getTouchPos(canvas, e);
                ctx.lineTo(touchPos.x, touchPos.y);
                ctx.stroke();
            }
            e.preventDefault();
        }, false);
    }
    
    function clearSignature(id) {
        if(sigCtxs[id] && sigCanvases[id]) {
            sigCtxs[id].clearRect(0, 0, sigCanvases[id].width, sigCanvases[id].height);
            document.getElementById('tandaTanganBase64' + id).value = '';
        }
    }
    
    // Initialize canvases when modal is opened
    document.addEventListener('DOMContentLoaded', function () {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            modal.addEventListener('shown.bs.modal', function (event) {
                // Find person ID from modal ID (e.g. absenModal5 -> 5)
                const modalId = modal.getAttribute('id');
                if(modalId && modalId.startsWith('absenModal')) {
                    const personId = modalId.replace('absenModal', '');
                    initSignatureCanvas(personId);
                }
            });
        });
    });
</script>
@endpush
@endsection
