@extends('layouts.app')

@section('title', 'Pilihan Donasi - ' . $program->judul_program)

@push('styles')
<style>
    .choice-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent !important;
        position: relative;
        overflow: hidden;
    }
    
    .choice-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .choice-card:hover {
        border-color: var(--primary) !important;
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.15) !important;
    }
    
    .choice-card:hover::before {
        opacity: 1;
    }
    
    .choice-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        transition: all 0.3s ease;
    }
    
    .choice-card:hover .choice-icon {
        transform: scale(1.1);
    }
    
    .icon-guest {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #059669;
    }
    
    .icon-login {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1d4ed8;
    }
    
    .choice-features {
        list-style: none;
        padding: 0;
        margin: 1.5rem 0;
    }
    
    .choice-features li {
        padding: 0.4rem 0;
        color: #64748b;
        font-size: 0.95rem;
    }
    
    .choice-features li i {
        color: var(--primary);
        margin-right: 0.5rem;
    }
    
    .program-mini-card {
        background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        border: 1px solid #bbf7d0;
        border-radius: 16px;
        padding: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .choice-icon {
            width: 64px;
            height: 64px;
            font-size: 1.5rem;
        }
        
        .choice-card .card-body {
            padding: 1.5rem !important;
        }
    }
</style>
@endpush

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Program Info -->
                <div class="program-mini-card mb-4" data-aos="fade-up">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; min-width: 50px;">
                            <i class="bi bi-heart-fill text-primary fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Berdonasi untuk program:</small>
                            <h6 class="fw-bold mb-0">{{ $program->judul_program }}</h6>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="fw-bold mb-2">Pilih Cara Berdonasi</h3>
                    <p class="text-muted">Anda bisa berdonasi langsung sebagai tamu atau login untuk pengalaman yang lebih lengkap</p>
                </div>

                <!-- Choice Cards -->
                <div class="row g-4 justify-content-center">
                    <!-- Guest Donation -->
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="card choice-card h-100" onclick="window.location='{{ route('donasi.create', $program->id_program) }}?guest=1'">
                            <div class="card-body p-4 p-lg-5 text-center">
                                <div class="choice-icon icon-guest">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Donasi sebagai Tamu</h5>
                                <p class="text-muted mb-3">Langsung berdonasi tanpa perlu membuat akun atau login</p>
                                
                                <ul class="choice-features text-start">
                                    <li><i class="bi bi-check-circle-fill"></i>Proses cepat & mudah</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Tanpa perlu registrasi</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Isi data donatur secara manual</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Dapatkan kode pelacakan donasi</li>
                                </ul>
                                
                                <a href="{{ route('donasi.create', $program->id_program) }}?guest=1" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Lanjut Tanpa Login
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Login Donation -->
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="card choice-card h-100" onclick="window.location='{{ route('donatur.login') }}?redirect={{ urlencode(route('donasi.create', $program->id_program)) }}'">
                            <div class="card-body p-4 p-lg-5 text-center">
                                <div class="choice-icon icon-login">
                                    <i class="bi bi-person-check"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Login & Donasi</h5>
                                <p class="text-muted mb-3">Masuk ke akun donatur untuk pengalaman berdonasi yang lebih lengkap</p>
                                
                                <ul class="choice-features text-start">
                                    <li><i class="bi bi-check-circle-fill"></i>Data terisi otomatis</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Riwayat donasi tercatat</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Dashboard donatur pribadi</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Notifikasi status donasi</li>
                                </ul>
                                
                                <a href="{{ route('donatur.login') }}?redirect={{ urlencode(route('donasi.create', $program->id_program)) }}" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login Dulu
                                </a>
                                
                                <p class="mt-3 mb-0">
                                    <small class="text-muted">Belum punya akun? 
                                        <a href="{{ route('donatur.register') }}" class="text-primary fw-semibold">Daftar di sini</a>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('programs.show', $program->id_program) }}" class="text-muted">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Detail Program
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
