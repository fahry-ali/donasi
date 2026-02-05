@extends('layouts.admin')

@section('page-title', 'Edit Konten')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.konten.index') }}">Konten</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil me-2"></i>Edit Konten Kegiatan
            </div>
            <div class="card-body">
                <form action="{{ route('admin.konten.update', $konten->id_konten) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" 
                               value="{{ old('judul', $konten->judul) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="8" required>{{ old('deskripsi', $konten->deskripsi) }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Gambar</label>
                        @if($konten->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $konten->gambar) }}" class="rounded" width="200">
                            </div>
                        @endif
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.konten.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
