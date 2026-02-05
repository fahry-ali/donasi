@extends('layouts.admin')

@section('page-title', 'Review Usulan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.usulan.index') }}">Usulan</a></li>
    <li class="breadcrumb-item active">Review</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-text me-2"></i>Detail Usulan Program</span>
                <span class="badge bg-{{ $usulan->status_badge_color }} fs-6">{{ ucfirst($usulan->status_usulan) }}</span>
            </div>
            <div class="card-body">
                <h4 class="fw-bold mb-3">{{ $usulan->judul_usulan }}</h4>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-person text-muted"></i>
                            <span>{{ $usulan->user->nama }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-envelope text-muted"></i>
                            <span>{{ $usulan->user->email }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-geo-alt text-muted"></i>
                            <span>{{ $usulan->lokasi }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-calendar3 text-muted"></i>
                            <span>{{ $usulan->created_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h6 class="text-muted mb-3">Deskripsi Usulan</h6>
                <div class="bg-light rounded p-4 mb-4">
                    {!! nl2br(e($usulan->deskripsi)) !!}
                </div>
                
                @if($usulan->foto_pendukung)
                    <h6 class="text-muted mb-3">Foto Pendukung</h6>
                    <a href="{{ asset('storage/' . $usulan->foto_pendukung) }}" target="_blank">
                        <img src="{{ asset('storage/' . $usulan->foto_pendukung) }}" class="img-fluid rounded" style="max-height: 300px;">
                    </a>
                @endif
                
                @if($usulan->catatan_admin)
                    <hr>
                    <h6 class="text-muted mb-3">Catatan Admin</h6>
                    <div class="alert alert-info">
                        {{ $usulan->catatan_admin }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        @if($usulan->status_usulan == 'menunggu')
            <!-- Convert to Program -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-arrow-repeat me-2"></i>Konversi ke Program
                </div>
                <div class="card-body">
                    <p class="small text-muted">Terima usulan dan buat program donasi baru dari usulan ini.</p>
                    <form action="{{ route('admin.usulan.convert', $usulan->id_usulan) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kategori Program</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Dana</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="target_dana" class="form-control" min="100000" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Konversi usulan ini menjadi program?')">
                            <i class="bi bi-check-circle me-1"></i>Konversi ke Program
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Approve Only -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-check-lg me-2"></i>Terima Usulan
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.usulan.approve', $usulan->id_usulan) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea name="catatan_admin" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-1"></i>Terima
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Reject -->
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-x-lg me-2"></i>Tolak Usulan
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.usulan.reject', $usulan->id_usulan) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="catatan_admin" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Tolak usulan ini?')">
                            <i class="bi bi-x-circle me-1"></i>Tolak
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('admin.usulan.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        @endif
    </div>
</div>
@endsection
