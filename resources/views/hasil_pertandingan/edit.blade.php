@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('hasil-pertandingan.index') }}" class="btn btn-light me-3 border" style="border-radius: 8px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h3 class="fw-bold mb-0" style="color: #0f172a;">Edit Hasil Pertandingan</h3>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Perbarui data perolehan medali untuk cabor {{ $hasil->cabor }}.</p>
        </div>
    </div>

    @if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
        <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Terdapat kesalahan pada input:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('hasil-pertandingan.update', $hasil->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <!-- Informasi Kegiatan & Pertandingan -->
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white p-3 border-bottom">
                        <span class="fw-bold text-dark"><i class="fas fa-info-circle text-primary me-2"></i> Info Event & Pertandingan</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kegiatan / Event <span class="text-danger">*</span></label>
                            <select name="kegiatan_id" class="form-select select2-kegiatan" required>
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach($kegiatans as $k)
                                    <option value="{{ $k->id }}" {{ old('kegiatan_id', $hasil->kegiatan_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Cabang Olahraga <span class="text-danger">*</span></label>
                            <select name="cabor" id="selectCabor" class="form-select select2-cabor" required>
                                <option value="">-- Pilih Cabor --</option>
                                @foreach($cabors as $c)
                                    <option value="{{ $c->nama }}" {{ old('cabor', $hasil->cabor) == $c->nama ? 'selected' : '' }}>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor / Kategori Pertandingan</label>
                            <input type="text" name="nomor_pertandingan" class="form-control" placeholder="Contoh: Tunggal Putra, Lari 100m, Kelas 60 Kg" value="{{ old('nomor_pertandingan', $hasil->nomor_pertandingan) }}">
                            <div class="form-text">Boleh dikosongkan jika mewakili cabor secara umum.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Pertandingan</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $hasil->tanggal) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan / Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)...">{{ old('keterangan', $hasil->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peraih Medali -->
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-header bg-white p-3 border-bottom">
                        <span class="fw-bold text-dark"><i class="fas fa-medal text-warning me-2"></i> Peraih Medali</span>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- 1. Medali Emas (Gold) -->
                        <div class="p-3 mb-4 rounded-3 border border-warning border-opacity-50" style="background-color: #fefce8;">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-warning text-dark me-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; border-radius: 50%; font-size: 0.9rem;">
                                    <i class="fas fa-medal"></i>
                                </span>
                                <h6 class="fw-bold text-dark mb-0">Medali Emas (Juara 1)</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Pilih Atlet</label>
                                    <select name="emas_pelaku_id" id="emas_pelaku_id" class="form-select select2-atlet" onchange="autoFillKontingen(this, 'emas_kontingen')">
                                        <option value="">-- Pilih Atlet (Opsional) --</option>
                                        @foreach($atlits as $a)
                                            <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}" {{ old('emas_pelaku_id', $hasil->emas_pelaku_id) == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama }} ({{ $a->cabor ?? 'Atlet' }} - {{ $a->kontingen }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Kontingen / Daerah Asal</label>
                                    <select name="emas_kontingen" id="emas_kontingen" class="form-select">
                                        <option value="">-- Pilih Kontingen / Kota --</option>
                                        @foreach($kotas as $kota)
                                            <option value="{{ $kota->nama }}" {{ old('emas_kontingen', $hasil->emas_kontingen) == $kota->nama ? 'selected' : '' }}>
                                                {{ $kota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Medali Perak (Silver) -->
                        <div class="p-3 mb-4 rounded-3 border border-secondary border-opacity-25" style="background-color: #f8fafc;">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-secondary text-white me-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; border-radius: 50%; font-size: 0.9rem;">
                                    <i class="fas fa-medal"></i>
                                </span>
                                <h6 class="fw-bold text-dark mb-0">Medali Perak (Juara 2)</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Pilih Atlet</label>
                                    <select name="perak_pelaku_id" id="perak_pelaku_id" class="form-select select2-atlet" onchange="autoFillKontingen(this, 'perak_kontingen')">
                                        <option value="">-- Pilih Atlet (Opsional) --</option>
                                        @foreach($atlits as $a)
                                            <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}" {{ old('perak_pelaku_id', $hasil->perak_pelaku_id) == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama }} ({{ $a->cabor ?? 'Atlet' }} - {{ $a->kontingen }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Kontingen / Daerah Asal</label>
                                    <select name="perak_kontingen" id="perak_kontingen" class="form-select">
                                        <option value="">-- Pilih Kontingen / Kota --</option>
                                        @foreach($kotas as $kota)
                                            <option value="{{ $kota->nama }}" {{ old('perak_kontingen', $hasil->perak_kontingen) == $kota->nama ? 'selected' : '' }}>
                                                {{ $kota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Medali Perunggu 1 (Bronze) -->
                        <div class="p-3 mb-4 rounded-3 border border-warning border-opacity-25" style="background-color: #fffbeb;">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge text-white me-2 d-flex align-items-center justify-content-center" style="background-color: #d97706; width: 28px; height: 28px; border-radius: 50%; font-size: 0.9rem;">
                                    <i class="fas fa-medal"></i>
                                </span>
                                <h6 class="fw-bold text-dark mb-0">Medali Perunggu (Juara 3)</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Pilih Atlet</label>
                                    <select name="perunggu_pelaku_id" id="perunggu_pelaku_id" class="form-select select2-atlet" onchange="autoFillKontingen(this, 'perunggu_kontingen')">
                                        <option value="">-- Pilih Atlet (Opsional) --</option>
                                        @foreach($atlits as $a)
                                            <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}" {{ old('perunggu_pelaku_id', $hasil->perunggu_pelaku_id) == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama }} ({{ $a->cabor ?? 'Atlet' }} - {{ $a->kontingen }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Kontingen / Daerah Asal</label>
                                    <select name="perunggu_kontingen" id="perunggu_kontingen" class="form-select">
                                        <option value="">-- Pilih Kontingen / Kota --</option>
                                        @foreach($kotas as $kota)
                                            <option value="{{ $kota->nama }}" {{ old('perunggu_kontingen', $hasil->perunggu_kontingen) == $kota->nama ? 'selected' : '' }}>
                                                {{ $kota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Medali Perunggu 2 (Opsional / Bersama) -->
                        <div class="p-3 mb-4 rounded-3 border border-dashed border-secondary border-opacity-50" style="background-color: #fafafa;">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge text-white me-2 d-flex align-items-center justify-content-center" style="background-color: #b45309; width: 28px; height: 28px; border-radius: 50%; font-size: 0.9rem;">
                                    <i class="fas fa-medal"></i>
                                </span>
                                <h6 class="fw-bold text-dark mb-0">Medali Perunggu 2 (Juara 3 Bersama / Cabor Beladiri) <span class="text-muted fw-normal small">(Opsional)</span></h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Pilih Atlet</label>
                                    <select name="perunggu2_pelaku_id" id="perunggu2_pelaku_id" class="form-select select2-atlet" onchange="autoFillKontingen(this, 'perunggu2_kontingen')">
                                        <option value="">-- Pilih Atlet (Opsional) --</option>
                                        @foreach($atlits as $a)
                                            <option value="{{ $a->id }}" data-kontingen="{{ $a->kontingen }}" {{ old('perunggu2_pelaku_id', $hasil->perunggu2_pelaku_id) == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama }} ({{ $a->cabor ?? 'Atlet' }} - {{ $a->kontingen }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Kontingen / Daerah Asal</label>
                                    <select name="perunggu2_kontingen" id="perunggu2_kontingen" class="form-select">
                                        <option value="">-- Pilih Kontingen / Kota --</option>
                                        @foreach($kotas as $kota)
                                            <option value="{{ $kota->nama }}" {{ old('perunggu2_kontingen', $hasil->perunggu2_kontingen) == $kota->nama ? 'selected' : '' }}>
                                                {{ $kota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('hasil-pertandingan.index') }}" class="btn btn-light px-4 border" style="border-radius: 8px;">Batal</a>
                            <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-save me-2"></i> Perbarui Hasil Pertandingan
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

@push('scripts')
<script>
function autoFillKontingen(selectElem, targetKontingenId) {
    const selectedOption = selectElem.options[selectElem.selectedIndex];
    const kontingen = selectedOption.getAttribute('data-kontingen');
    if (kontingen) {
        const targetSelect = document.getElementById(targetKontingenId);
        if (targetSelect) {
            for (let i = 0; i < targetSelect.options.length; i++) {
                if (targetSelect.options[i].value === kontingen || targetSelect.options[i].text.toUpperCase() === kontingen.toUpperCase()) {
                    targetSelect.selectedIndex = i;
                    break;
                }
            }
        }
    }
}
</script>
@endpush
@endsection
