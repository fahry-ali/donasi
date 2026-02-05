@extends('layouts.admin')

@section('page-title', 'Detail Donasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.donasi.index') }}">Donasi</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2"></i>Detail Donasi</span>
                <span class="badge bg-{{ $donasi->status_badge_color }} fs-6">{{ ucfirst($donasi->status_donasi) }}</span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Informasi Donatur</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted" width="120">Nama</td>
                                <td class="fw-semibold">{{ $donasi->nama_donatur }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>{{ $donasi->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. HP</td>
                                <td>{{ $donasi->no_hp ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Informasi Donasi</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted" width="120">Kode</td>
                                <td><code class="fs-6">{{ $donasi->kode_transaksi }}</code></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Nominal</td>
                                <td class="fw-bold text-primary fs-5">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Metode</td>
                                <td>{{ ucfirst($donasi->metode_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal</td>
                                <td>{{ $donasi->created_at->format('d F Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Program Donasi</h6>
                    <div class="d-flex align-items-center gap-3">
                        @if($donasi->program->gambar)
                            <img src="{{ asset('storage/' . $donasi->program->gambar) }}" class="rounded" width="80" height="60" style="object-fit: cover;">
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $donasi->program->judul_program }}</h6>
                            <small class="text-muted">{{ $donasi->program->kategori->nama_kategori ?? '' }}</small>
                        </div>
                    </div>
                </div>
                
                @if($donasi->pesan)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Pesan Donatur</h6>
                        <div class="bg-light rounded p-3">
                            <em>"{{ $donasi->pesan }}"</em>
                        </div>
                    </div>
                @endif
                
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Bukti Transfer</h6>
                    @if($donasi->bukti_transfer)
                        <a href="{{ asset('storage/' . $donasi->bukti_transfer) }}" target="_blank">
                            <img src="{{ asset('storage/' . $donasi->bukti_transfer) }}" class="img-fluid rounded" style="max-height: 400px;">
                        </a>
                        <p class="small text-muted mt-2">Klik gambar untuk memperbesar</p>
                    @else
                        <p class="text-muted">Tidak ada bukti transfer</p>
                    @endif
                </div>
                
                @if($donasi->status_donasi == 'menunggu')
                    <hr>
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.donasi.approve', $donasi->id_donasi) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi donasi ini?')">
                                <i class="bi bi-check-circle me-1"></i>Terima Donasi
                            </button>
                        </form>
                        <form action="{{ route('admin.donasi.reject', $donasi->id_donasi) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak donasi ini?')">
                                <i class="bi bi-x-circle me-1"></i>Tolak Donasi
                            </button>
                        </form>
                        <a href="{{ route('admin.donasi.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                @else
                    <a href="{{ route('admin.donasi.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
