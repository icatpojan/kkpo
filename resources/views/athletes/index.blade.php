@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Atlet</h1>
        <a href="{{ route('athletes.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Atlet</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Cabor</th>
                            <th>L/P</th>
                            <th>Tgl Lahir</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($athletes as $athlete)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $athlete->nik }}</td>
                            <td>{{ $athlete->name }}</td>
                            <td>{{ $athlete->cabangOlahraga->name ?? '-' }}</td>
                            <td>{{ $athlete->gender }}</td>
                            <td>{{ $athlete->dob }}</td>
                            <td>
                                <a href="{{ route('athletes.show', $athlete->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('athletes.edit', $athlete->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('athletes.destroy', $athlete->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
