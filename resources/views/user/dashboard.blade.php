@extends('layouts.user')

@section('title', 'Dashboard - Panti Bumi Damai')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Selamat datang, {{ auth()->user()->nama }}! 👋</h4>
    <p class="text-muted">Kelola usulan program dan pantau kontribusi Anda untuk panti asuhan</p>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-chat-left-text"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalUsulan }}</div>
                    <div class="text-muted small">Total Usulan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $usulanPending }}</div>
                    <div class="text-muted small">Menunggu Review</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $usulanDiterima }}</div>
                    <div class="text-muted small">Usulan Diterima</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold">{{ $usulanDitolak }}</div>
                    <div class="text-muted small">Usulan Ditolak</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Proposals -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Usulan Terbaru Anda</span>
                <a href="{{ route('user.usulan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($recentUsulan as $usulan)
                    <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center flex-shrink-0" style="width:45px;height:45px;">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $usulan->judul_usulan }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-geo-alt me-1"></i>{{ $usulan->lokasi }}
                                • {{ $usulan->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $usulan->status_badge_color }}">
                            {{ ucfirst($usulan->status_usulan) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                        <p class="text-muted mt-2">Anda belum mengajukan usulan program</p>
                        <a href="{{ route('user.usulan.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Ajukan Usulan Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-lightning me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <a href="{{ route('user.usulan.create') }}" class="btn btn-primary w-100 mb-2 py-3">
                    <i class="bi bi-plus-circle d-block fs-4 mb-1"></i>
                    Ajukan Usulan Program
                </a>
                <a href="{{ route('programs.index') }}" class="btn btn-outline-primary w-100 py-3">
                    <i class="bi bi-heart d-block fs-4 mb-1"></i>
                    Donasi Sekarang
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Panduan
            </div>
            <div class="card-body">
                <ul class="mb-0 ps-3">
                    <li class="mb-2">Ajukan usulan program bantuan untuk lokasi yang membutuhkan</li>
                    <li class="mb-2">Sertakan lokasi dan deskripsi yang jelas</li>
                    <li class="mb-2">Tim kami akan mereview usulan Anda</li>
                    <li>Usulan yang diterima akan menjadi program donasi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
