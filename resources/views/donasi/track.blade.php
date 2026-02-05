@extends('layouts.app')

@section('title', 'Lacak Donasi - Panti Bumi Damai')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card" data-aos="fade-up">
                    <div class="card-body p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-primary-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: #d1fae5 !important;">
                                <i class="bi bi-search fs-2 text-primary"></i>
                            </div>
                            <h3 class="fw-bold">Lacak Donasi</h3>
                            <p class="text-muted">Masukkan kode transaksi untuk melihat status donasi Anda</p>
                        </div>
                        
                        <form action="{{ route('donasi.track') }}" method="GET">
                            <div class="input-group mb-4">
                                <input type="text" name="kode" class="form-control form-control-lg" 
                                       placeholder="Masukkan kode transaksi" value="{{ $kode ?? '' }}" required>
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="bi bi-search"></i> Lacak
                                </button>
                            </div>
                        </form>
                        
                        @if(isset($kode) && $kode)
                            @if($donasi)
                                <div class="border rounded-3 p-4">
                                    <div class="text-center mb-3">
                                        @if($donasi->isDiterima())
                                            <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                                <i class="bi bi-check-lg fs-3 text-white"></i>
                                            </div>
                                            <h5 class="text-success fw-bold">Donasi Diterima</h5>
                                        @elseif($donasi->isDitolak())
                                            <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                                <i class="bi bi-x-lg fs-3 text-white"></i>
                                            </div>
                                            <h5 class="text-danger fw-bold">Donasi Ditolak</h5>
                                        @else
                                            <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                                <i class="bi bi-hourglass-split fs-3 text-white"></i>
                                            </div>
                                            <h5 class="text-warning fw-bold">Menunggu Verifikasi</h5>
                                        @endif
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <small class="text-muted">Kode Transaksi</small>
                                            <p class="fw-bold mb-0">{{ $donasi->kode_transaksi }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Tanggal</small>
                                            <p class="fw-semibold mb-0">{{ $donasi->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted">Program</small>
                                            <p class="fw-semibold mb-0">{{ $donasi->program->judul_program }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Nama Donatur</small>
                                            <p class="fw-semibold mb-0">{{ $donasi->nama_donatur }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Nominal</small>
                                            <p class="fw-bold text-primary mb-0">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center p-4">
                                    <i class="bi bi-exclamation-circle display-3 text-muted"></i>
                                    <h5 class="mt-3">Donasi Tidak Ditemukan</h5>
                                    <p class="text-muted">Kode transaksi "{{ $kode }}" tidak ditemukan dalam sistem kami.</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
