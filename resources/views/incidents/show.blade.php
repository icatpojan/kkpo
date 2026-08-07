@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Insiden</h1>
        <a href="{{ route('incidents.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Informasi Kejadian</h6>
                </div>
                <div class="card-body">
                    <p><strong>Tanggal:</strong> {{ $incident->incident_date }}</p>
                    <p><strong>Lokasi:</strong> {{ $incident->location }}</p>
                    <p><strong>Event:</strong> {{ $incident->event_name ?? '-' }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $incident->status == 'reported' ? 'warning' : ($incident->status == 'in_treatment' ? 'primary' : 'success') }}">
                            {{ ucfirst($incident->status) }}
                        </span>
                    </p>
                    <hr>
                    <h6><strong>Deskripsi:</strong></h6>
                    <p>{{ $incident->description }}</p>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Informasi Atlet</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $incident->athlete->name ?? '-' }}</p>
                    <p><strong>NIK:</strong> {{ $incident->athlete->nik ?? '-' }}</p>
                    <a href="{{ route('athletes.show', $incident->athlete_id) }}" class="btn btn-sm btn-outline-primary">Lihat Profil Atlet</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-secondary text-white">
                    <h6 class="m-0 font-weight-bold">Foto Dokumentasi</h6>
                </div>
                <div class="card-body text-center">
                    @if($incident->photo_path)
                        <img src="{{ asset('storage/' . $incident->photo_path) }}" alt="Foto Insiden" class="img-fluid rounded">
                    @else
                        <p class="text-muted">Tidak ada foto dokumentasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
