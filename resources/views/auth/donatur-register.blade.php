@extends('layouts.app')

@section('title', 'Daftar Akun Donatur - Panti Bumi Damai')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card" data-aos="fade-up">
                    <div class="card-body p-4 p-lg-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-primary-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: #d1fae5 !important;">
                                <i class="bi bi-person-plus-fill fs-2 text-primary"></i>
                            </div>
                            <h3 class="fw-bold">Daftar Akun Donatur</h3>
                            <p class="text-muted">Buat akun untuk mulai berdonasi dan pantau riwayat donasi Anda</p>
                        </div>

                        <form method="POST" action="{{ route('donatur.register.store') }}">
                            @csrf

                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required autofocus>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="email@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- No HP -->
                            <div class="mb-3">
                                <label for="no_hp" class="form-label fw-semibold">No. HP/WhatsApp</label>
                                <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                       value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                                       placeholder="Ulangi password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                            </button>

                            <div class="text-center">
                                <span class="text-muted">Sudah punya akun?</span>
                                <a href="{{ route('donatur.login') }}" class="text-primary fw-semibold text-decoration-none">Masuk di sini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
