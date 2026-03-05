@extends('layouts.app')

@section('title', 'Login - Panti Bumi Damai')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card" data-aos="fade-up">
                    <div class="card-body p-4 p-lg-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-primary-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: #d1fae5 !important;">
                                <i class="bi bi-box-arrow-in-right fs-2 text-primary"></i>
                            </div>
                            <h3 class="fw-bold">Masuk ke Akun</h3>
                            <p class="text-muted">Login untuk semua jenis akun (Admin, Masyarakat, Donatur)</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mb-3">
                                <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('donatur.login.store') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="email@example.com" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Masukkan password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                                    <label for="remember" class="form-check-label text-muted">Ingat saya</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>

                            <div class="text-center">
                                <span class="text-muted">Belum punya akun?</span>
                                <a href="{{ route('register.choice') }}" class="text-primary fw-semibold text-decoration-none">Daftar sekarang</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
