@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Pengaturan Web (Beranda)</h1>
            <p class="mb-0" style="color: #475569; font-size: 0.95rem;">Kelola tampilan banner dan teks di halaman utama aplikasi.</p>
        </div>
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
                                    <img src="{{ asset($hero->gambar) }}" alt="Hero Image" class="img-fluid rounded shadow-sm" style="max-height: 180px; object-fit: contain;">
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
