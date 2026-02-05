@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div>
                    <div class="value">Rp {{ number_format($totalDonasi/1000000, 1) }}Jt</div>
                    <div class="label">Total Donasi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="value">{{ $donasiPending }}</div>
                    <div class="label">Donasi Pending</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-collection"></i>
                </div>
                <div>
                    <div class="value">{{ $programAktif }}</div>
                    <div class="label">Program Aktif</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-chat-left-text"></i>
                </div>
                <div>
                    <div class="value">{{ $usulanPending }}</div>
                    <div class="label">Usulan Pending</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Pending Donations -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Donasi Menunggu Verifikasi</span>
                <a href="{{ route('admin.donasi.index', ['status' => 'menunggu']) }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($recentDonasi as $donasi)
                    <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                            {{ strtoupper(substr($donasi->nama_donatur, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $donasi->nama_donatur }}</h6>
                            <small class="text-muted">{{ Str::limit($donasi->program->judul_program, 30) }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-primary">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</div>
                            <small class="text-muted">{{ $donasi->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4 mb-0">Tidak ada donasi pending</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Proposals -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-chat-square-text me-2"></i>Usulan Program Terbaru</span>
                <a href="{{ route('admin.usulan.index', ['status' => 'menunggu']) }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($recentUsulan as $usulan)
                    <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $usulan->judul_usulan }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-geo-alt me-1"></i>{{ $usulan->lokasi }}
                                • oleh {{ $usulan->user->nama }}
                            </small>
                        </div>
                        <a href="{{ route('admin.usulan.show', $usulan->id_usulan) }}" class="btn btn-sm btn-outline-primary">Review</a>
                    </div>
                @empty
                    <p class="text-muted text-center py-4 mb-0">Tidak ada usulan pending</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('admin.programs.create') }}" class="btn btn-primary w-100 py-3">
                            <i class="bi bi-plus-circle d-block fs-4 mb-1"></i>
                            Tambah Program
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.donasi.index', ['status' => 'menunggu']) }}" class="btn btn-warning w-100 py-3">
                            <i class="bi bi-check-circle d-block fs-4 mb-1"></i>
                            Verifikasi Donasi
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.konten.create') }}" class="btn btn-info w-100 py-3 text-white">
                            <i class="bi bi-newspaper d-block fs-4 mb-1"></i>
                            Tambah Konten
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-secondary w-100 py-3">
                            <i class="bi bi-globe d-block fs-4 mb-1"></i>
                            Lihat Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
