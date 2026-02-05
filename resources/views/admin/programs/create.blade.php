@extends('layouts.admin')

@section('page-title', 'Tambah Program Donasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.programs.index') }}">Program</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Tambah Program Donasi Baru
            </div>
            <div class="card-body">
                <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Judul Program <span class="text-danger">*</span></label>
                        <input type="text" name="judul_program" class="form-control @error('judul_program') is-invalid @enderror" 
                               value="{{ old('judul_program') }}" required>
                        @error('judul_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sumber Program <span class="text-danger">*</span></label>
                            <select name="sumber_program" class="form-select @error('sumber_program') is-invalid @enderror" required>
                                <option value="yayasan" {{ old('sumber_program') == 'yayasan' ? 'selected' : '' }}>Yayasan</option>
                                <option value="masyarakat" {{ old('sumber_program') == 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="5" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Target Dana <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="target_dana" class="form-control @error('target_dana') is-invalid @enderror" 
                                   value="{{ old('target_dana') }}" min="100000" required>
                        </div>
                        @error('target_dana')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Gambar Program</label>
                        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan Program
                        </button>
                        <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
