@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Atlet</h1>
        <div>
            <!-- PDF Export Button could be placed here -->
            <a href="{{ route('athletes.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Profil Atlet</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $athlete->name }}</p>
                    <p><strong>NIK:</strong> {{ $athlete->nik }}</p>
                    <p><strong>Cabor:</strong> {{ $athlete->cabangOlahraga->name ?? '-' }}</p>
                    <p><strong>BPJS:</strong> {{ $athlete->bpjs_number ?? '-' }}</p>
                    <p><strong>L/P:</strong> {{ $athlete->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                    <p><strong>Tgl Lahir:</strong> {{ $athlete->dob }}</p>
                    <p><strong>Alamat:</strong> {{ $athlete->address }}</p>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Dokumen</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($athlete->documents as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                {{ strtoupper($doc->type) }}
                                <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fas fa-download"></i> Unduh</a>
                            </li>
                        @empty
                            <li class="list-group-item px-0">Belum ada dokumen.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Riwayat Insiden / Cedera</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Event</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($athlete->incidents as $incident)
                                <tr>
                                    <td>{{ $incident->incident_date }}</td>
                                    <td>{{ $incident->event_name }}</td>
                                    <td>{{ $incident->location }}</td>
                                    <td>
                                        <span class="badge bg-{{ $incident->status == 'reported' ? 'warning' : ($incident->status == 'in_treatment' ? 'primary' : 'success') }}">
                                            {{ ucfirst($incident->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada riwayat cedera.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
