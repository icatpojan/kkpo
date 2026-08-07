@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Atlet</h1>
        <a href="{{ route('athletes.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('athletes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cabang Olahraga <span class="text-danger">*</span></label>
                        <select name="cabang_olahraga_id" class="form-control" required>
                            <option value="">-- Pilih Cabor --</option>
                            @foreach($cabors as $cabor)
                                <option value="{{ $cabor->id }}">{{ $cabor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No BPJS</label>
                        <input type="text" name="bpjs_number" class="form-control" value="{{ old('bpjs_number') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="gender" class="form-control" required>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                    
                    <hr>
                    <h5 class="mb-3">Dokumen Pendukung</h5>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">File KTP (JPG/PNG/PDF)</label>
                        <input type="file" name="ktp_file" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">File BPJS (JPG/PNG/PDF)</label>
                        <input type="file" name="bpjs_file" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
            </form>
        </div>
    </div>
</div>
@endsection
