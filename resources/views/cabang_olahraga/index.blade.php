@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Cabang Olahraga</h1>
        <a href="{{ route('cabang-olahraga.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Cabor</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Cabor</th>
                            <th>Deskripsi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cabors as $cabor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cabor->name }}</td>
                            <td>{{ $cabor->description }}</td>
                            <td>
                                <a href="{{ route('cabang-olahraga.edit', $cabor->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('cabang-olahraga.destroy', $cabor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
