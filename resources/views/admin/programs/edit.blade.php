@extends('layouts.admin')

@section('page-title', 'Edit Program Donasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.programs.index') }}">Program</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil me-2"></i>Edit Program Donasi
            </div>
            <div class="card-body">
                <form action="{{ route('admin.programs.update', $program->id_program) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Judul Program <span class="text-danger">*</span></label>
                        <input type="text" name="judul_program" class="form-control @error('judul_program') is-invalid @enderror" 
                               value="{{ old('judul_program', $program->judul_program) }}" required>
                        @error('judul_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="id_kategori" class="form-select" required>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" {{ $program->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status_program" class="form-select" required>
                                <option value="aktif" {{ $program->status_program == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ $program->status_program == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="5" required>{{ old('deskripsi', $program->deskripsi) }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Target Dana <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="target_dana" class="form-control" 
                                   value="{{ old('target_dana', $program->target_dana) }}" min="100000" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Gambar Program</label>
                        @if($program->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $program->gambar) }}" class="rounded" width="200">
                            </div>
                        @endif
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
