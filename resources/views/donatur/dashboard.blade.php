@extends('layouts.app')

@section('title', 'Dashboard Donatur - Panti Bumi Damai')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="mb-4">
            <h4 class="fw-bold">Selamat datang, {{ auth()->user()->nama }}!</h4>
            <p class="text-muted">Pantau riwayat donasi dan kontribusi Anda untuk panti asuhan</p>
        </div>

        <!-- Stats -->
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px;height:50px;">
                                <i class="bi bi-heart-fill fs-5"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold">{{ $totalDonasi }}</div>
                                <div class="text-muted small">Total Donasi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px;height:50px;">
                                <i class="bi bi-cash-stack fs-5"></i>
                            </div>
                            <div>
                                <div class="fs-5 fw-bold">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
                                <div class="text-muted small">Total Kontribusi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px;height:50px;">
                                <i class="bi bi-hourglass-split fs-5"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold">{{ $donasiPending }}</div>
                                <div class="text-muted small">Menunggu Verifikasi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px;height:50px;">
                                <i class="bi bi-check-circle-fill fs-5"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold">{{ $donasiDiterima }}</div>
                                <div class="text-muted small">Donasi Diterima</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Donations -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-clock-history me-2"></i>Riwayat Donasi Anda</span>
                    </div>
                    <div class="card-body">
                        @forelse($recentDonasi as $donasi)
                            <div class="d-flex align-items-start gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width:45px;height:45px;">
                                    <i class="bi bi-heart"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $donasi->program->judul_program ?? 'Program Dihapus' }}</h6>
                                    <div class="d-flex flex-wrap gap-2 align-items-center">
                                        <span class="fw-semibold text-primary">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</span>
                                        <small class="text-muted">•</small>
                                        <small class="text-muted">{{ $donasi->kode_transaksi }}</small>
                                        <small class="text-muted">•</small>
                                        <small class="text-muted">{{ $donasi->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-{{ $donasi->status_badge_color }} flex-shrink-0">
                                    {{ ucfirst($donasi->status_donasi) }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-2">Anda belum melakukan donasi</p>
                                <a href="{{ route('programs.index') }}" class="btn btn-primary">
                                    <i class="bi bi-heart me-1"></i>Donasi Sekarang
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
                        <a href="{{ route('programs.index') }}" class="btn btn-primary w-100 mb-2 py-3">
                            <i class="bi bi-heart-fill d-block fs-4 mb-1"></i>
                            Donasi Sekarang
                        </a>
                        <a href="{{ route('donasi.track') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-search d-block fs-4 mb-1"></i>
                            Lacak Donasi
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-person-circle me-2"></i>Info Akun
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <small class="text-muted d-block">Nama</small>
                                <span class="fw-semibold">{{ auth()->user()->nama }}</span>
                            </li>
                            <li class="mb-2">
                                <small class="text-muted d-block">Email</small>
                                <span class="fw-semibold">{{ auth()->user()->email }}</span>
                            </li>
                            <li>
                                <small class="text-muted d-block">No. HP</small>
                                <span class="fw-semibold">{{ auth()->user()->no_hp ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
