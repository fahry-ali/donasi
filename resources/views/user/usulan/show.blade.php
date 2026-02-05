@extends('layouts.user')

@section('title', 'Detail Usulan - Panti Bumi Damai')

@section('content')
<div class="mb-4">
    <a href="{{ route('user.usulan.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Usulan
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-text me-2"></i>Detail Usulan Program</span>
                <span class="badge bg-{{ $usulan->status_badge_color }} fs-6">{{ ucfirst($usulan->status_usulan) }}</span>
            </div>
            <div class="card-body p-4">
                <h4 class="fw-bold mb-3">{{ $usulan->judul_usulan }}</h4>
                
                <div class="d-flex flex-wrap gap-4 mb-4 text-muted">
                    <div>
                        <i class="bi bi-geo-alt me-1"></i>{{ $usulan->lokasi }}
                    </div>
                    <div>
                        <i class="bi bi-calendar3 me-1"></i>{{ $usulan->created_at->format('d F Y, H:i') }}
                    </div>
                </div>
                
                <hr>
                
                <h6 class="text-muted mb-3">Deskripsi</h6>
                <div class="bg-light rounded p-4 mb-4">
                    {!! nl2br(e($usulan->deskripsi)) !!}
                </div>
                
                @if($usulan->foto_pendukung)
                    <h6 class="text-muted mb-3">Foto Pendukung</h6>
                    <img src="{{ asset('storage/' . $usulan->foto_pendukung) }}" class="img-fluid rounded" style="max-height: 300px;">
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Status Usulan
            </div>
            <div class="card-body">
                @if($usulan->status_usulan == 'menunggu')
                    <div class="text-center py-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px;">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                        <h6 class="fw-bold">Menunggu Review</h6>
                        <p class="text-muted small mb-0">Usulan Anda sedang dalam proses review oleh tim kami. Harap tunggu notifikasi selanjutnya.</p>
                    </div>
                @elseif($usulan->status_usulan == 'diterima')
                    <div class="text-center py-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px;">
                            <i class="bi bi-check-lg fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-success">Usulan Diterima</h6>
                        <p class="text-muted small mb-0">Selamat! Usulan Anda telah diterima dan akan diproses lebih lanjut.</p>
                    </div>
                @else
                    <div class="text-center py-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px;">
                            <i class="bi bi-x-lg fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-danger">Usulan Ditolak</h6>
                        <p class="text-muted small mb-0">Maaf, usulan Anda tidak dapat kami proses saat ini.</p>
                    </div>
                @endif
                
                @if($usulan->catatan_admin)
                    <hr>
                    <h6 class="text-muted mb-2">Catatan dari Admin:</h6>
                    <div class="alert alert-secondary mb-0">
                        {{ $usulan->catatan_admin }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
