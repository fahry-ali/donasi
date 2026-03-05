@extends('layouts.app')

@section('title', 'Pilih Jenis Akun - Panti Bumi Damai')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5" data-aos="fade-up">
                    <div class="rounded-circle bg-primary-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: #d1fae5 !important;">
                        <i class="bi bi-person-plus-fill fs-2 text-primary"></i>
                    </div>
                    <h3 class="fw-bold">Daftar Akun Baru</h3>
                    <p class="text-muted">Pilih jenis akun yang sesuai dengan kebutuhan Anda</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <!-- Donatur Card -->
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="card h-100 text-center border-0" style="cursor: pointer;" onclick="window.location='{{ route('donatur.register') }}'">
                            <div class="card-body p-4">
                                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-heart-fill fs-1 text-success"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Donatur</h4>
                                <p class="text-muted mb-4">Daftar sebagai donatur untuk berdonasi ke program-program panti asuhan dan pantau riwayat donasi Anda.</p>
                                <ul class="list-unstyled text-start mb-4">
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Berdonasi ke program panti</li>
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Pantau riwayat donasi</li>
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Lacak status donasi</li>
                                </ul>
                                <a href="{{ route('donatur.register') }}" class="btn btn-primary w-100 py-2">
                                    <i class="bi bi-heart me-2"></i>Daftar sebagai Donatur
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Masyarakat Card -->
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="card h-100 text-center border-0" style="cursor: pointer;" onclick="window.location='{{ route('register') }}'">
                            <div class="card-body p-4">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-people-fill fs-1 text-primary"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Masyarakat</h4>
                                <p class="text-muted mb-4">Daftar sebagai masyarakat untuk mengajukan usulan program bantuan ke panti asuhan.</p>
                                <ul class="list-unstyled text-start mb-4">
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Ajukan usulan program</li>
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Pantau status usulan</li>
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Lihat progres program</li>
                                </ul>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 py-2">
                                    <i class="bi bi-people me-2"></i>Daftar sebagai Masyarakat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="300">
                    <span class="text-muted">Sudah punya akun?</span>
                    <a href="{{ route('donatur.login') }}" class="text-primary fw-semibold text-decoration-none">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
