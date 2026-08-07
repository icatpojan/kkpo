@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Update Status Insiden</h1>
        <a href="{{ route('incidents.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('incidents.update', $incident->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Status Penanganan <span class="text-danger">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="reported" {{ $incident->status == 'reported' ? 'selected' : '' }}>Dilaporkan</option>
                        <option value="in_treatment" {{ $incident->status == 'in_treatment' ? 'selected' : '' }}>Dalam Perawatan</option>
                        <option value="recovered" {{ $incident->status == 'recovered' ? 'selected' : '' }}>Sembuh</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Update Deskripsi / Catatan Tambahan <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $incident->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
