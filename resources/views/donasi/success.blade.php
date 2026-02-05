@extends('layouts.app')

@section('title', 'Donasi Berhasil - Panti Bumi Damai')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card text-center" data-aos="zoom-in">
                    <div class="card-body p-5">
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-check-lg fs-1 text-white"></i>
                        </div>
                        
                        <h2 class="fw-bold mb-3">Terima Kasih!</h2>
                        <p class="text-muted mb-4">Donasi Anda telah berhasil dikirim dan sedang menunggu verifikasi dari tim kami.</p>
                        
                        <div class="bg-light rounded-3 p-4 mb-4">
                            <small class="text-muted">Kode Transaksi Anda</small>
                            <h3 class="text-primary fw-bold mb-0">{{ $donasi->kode_transaksi }}</h3>
                            <small class="text-muted">Simpan kode ini untuk melacak status donasi Anda</small>
                        </div>
                        
                        <div class="text-start mb-4">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Program</span>
                                <span class="fw-semibold">{{ $donasi->program->judul_program }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Nama Donatur</span>
                                <span class="fw-semibold">{{ $donasi->nama_donatur }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Nominal</span>
                                <span class="fw-bold text-primary">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Metode</span>
                                <span class="fw-semibold">{{ ucfirst($donasi->metode_pembayaran) }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">Status</span>
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('donasi.track') }}?kode={{ $donasi->kode_transaksi }}" class="btn btn-outline-primary">
                                <i class="bi bi-search me-2"></i>Lacak Status Donasi
                            </a>
                            <a href="{{ route('programs.index') }}" class="btn btn-primary">
                                <i class="bi bi-heart me-2"></i>Donasi Lagi
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-light">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
