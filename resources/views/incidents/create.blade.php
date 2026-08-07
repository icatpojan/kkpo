@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lapor Insiden</h1>
        <a href="{{ route('incidents.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pilih Atlet <span class="text-danger">*</span></label>
                        <select name="athlete_id" class="form-control" required>
                            <option value="">-- Pilih Atlet --</option>
                            @foreach($athletes as $athlete)
                                <option value="{{ $athlete->id }}">{{ $athlete->nik }} - {{ $athlete->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kejadian <span class="text-danger">*</span></label>
                        <input type="date" name="incident_date" class="form-control" value="{{ old('incident_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Event/Kegiatan</label>
                        <input type="text" name="event_name" class="form-control" value="{{ old('event_name') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lokasi Kejadian <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Deskripsi Cedera / Penanganan Awal <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto Kejadian (Opsional)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                </div>

                <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> Lapor Insiden</button>
            </form>
        </div>
    </div>
</div>
@endsection
