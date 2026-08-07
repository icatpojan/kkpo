@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Insiden (Cedera)</h1>
        <a href="{{ route('incidents.create') }}" class="btn btn-danger"><i class="fas fa-plus"></i> Lapor Insiden</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Atlet</th>
                            <th>Event</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incidents as $incident)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $incident->incident_date }}</td>
                            <td>{{ $incident->athlete->name ?? '-' }}</td>
                            <td>{{ $incident->event_name }}</td>
                            <td>
                                <span class="badge bg-{{ $incident->status == 'reported' ? 'warning' : ($incident->status == 'in_treatment' ? 'primary' : 'success') }}">
                                    {{ ucfirst($incident->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('incidents.show', $incident->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('incidents.edit', $incident->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('incidents.destroy', $incident->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
