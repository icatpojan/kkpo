@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-dark fw-bold"><i class="fas fa-home me-2 text-primary"></i> Pengaturan Hero (Beranda)</h4>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('hero.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Banner</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul', $hero->judul) }}" required>
                            <small class="text-muted">Gunakan <code>&lt;span&gt;teks&lt;/span&gt;</code> untuk memberi warna khusus (biru muda) pada kata tertentu.</small>
                            @error('judul') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Sub-judul / Deskripsi Singkat</label>
                            <textarea name="sub_judul" class="form-control" rows="4" required>{{ old('sub_judul', $hero->sub_judul) }}</textarea>
                            @error('sub_judul') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar Hero (Kanan)</label>
                            <div class="mb-3 text-center" style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 15px;">
                                @if($hero->gambar)
                                    <img src="{{ Storage::url($hero->gambar) }}" alt="Hero Image" class="img-fluid rounded shadow-sm" style="max-height: 180px; object-fit: contain;">
                                @else
                                    <img src="{{ asset('images/hero-medical.png') }}" alt="Default Hero Image" class="img-fluid rounded shadow-sm" style="max-height: 180px; object-fit: contain;">
                                @endif
                            </div>
                            <input type="file" name="gambar" class="form-control" accept="image/*" style="border-radius: 8px;">
                            <small class="text-muted mt-1 d-block">Kosongkan jika tidak ingin mengubah gambar.</small>
                            @error('gambar') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
