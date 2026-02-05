@extends('layouts.user')

@section('title', 'Ajukan Usulan - Panti Bumi Damai')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Ajukan Usulan Program Baru
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Petunjuk:</strong> Sampaikan informasi lokasi dan kebutuhan program selengkap mungkin agar tim kami dapat mempertimbangkan usulan Anda dengan baik.
                </div>
                
                <form action="{{ route('user.usulan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Judul Usulan <span class="text-danger">*</span></label>
                        <input type="text" name="judul_usulan" class="form-control @error('judul_usulan') is-invalid @enderror" 
                               value="{{ old('judul_usulan') }}" placeholder="Contoh: Bantuan Pendidikan untuk Anak-anak Desa..." required>
                        @error('judul_usulan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" 
                               value="{{ old('lokasi') }}" placeholder="Contoh: Desa Sukamaju, Kec. Ciamis, Jawa Barat" required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="6" placeholder="Jelaskan kondisi di lokasi, apa yang dibutuhkan, dan mengapa program ini penting..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Foto Pendukung (Opsional)</label>
                        <input type="file" name="foto_pendukung" class="form-control @error('foto_pendukung') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Foto lokasi atau kondisi saat ini.</small>
                        @error('foto_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i>Kirim Usulan
                        </button>
                        <a href="{{ route('user.usulan.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
