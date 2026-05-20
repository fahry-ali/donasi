@extends('layouts.app')

@section('title', 'Kegiatan - Panti Bumi Damai')

@section('content')
@php
    $siteSettings = \App\Models\Setting::getSiteSettings();
    $profileSettings = \App\Models\Setting::getProfileSettings();
@endphp

<!-- Hero / Company Profile Section -->
<section style="background: linear-gradient(135deg, #064e3b 0%, #1e40af 100%); padding: 5rem 0; color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge bg-white text-dark px-3 py-2 mb-3" style="color: #064e3b !important;">
                    <i class="bi bi-building me-1"></i> Profil Yayasan
                </span>
                <h1 class="display-5 fw-bold mb-3">{{ $profileSettings['profil_nama'] }}</h1>
                <p class="lead opacity-90 mb-3">
                    {{ $profileSettings['profil_deskripsi1'] }}
                </p>
                <p class="opacity-75 mb-4">
                    {{ $profileSettings['profil_deskripsi2'] }}
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('programs.index') }}" class="btn btn-light btn-lg px-4" style="color: #064e3b;">
                        <i class="bi bi-heart-fill me-2"></i>Donasi Sekarang
                    </a>
                    <a href="#kegiatan-section" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-arrow-down me-2"></i>Lihat Kegiatan
                    </a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="text-center">
                    @if($siteSettings['hero_image'])
                        <img src="{{ asset($siteSettings['hero_image']) }}" 
                             alt="{{ $profileSettings['profil_nama'] }}" class="img-fluid rounded-4 shadow-lg" style="max-height: 400px; object-fit: cover;">
                    @else
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600&h=400&fit=crop" 
                             alt="{{ $profileSettings['profil_nama'] }}" class="img-fluid rounded-4 shadow-lg" style="max-height: 400px; object-fit: cover;">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi & Nilai Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Tentang Kami</h2>
            <p class="section-subtitle">Mengenal lebih dekat {{ $profileSettings['profil_nama'] }}</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 70px; height: 70px; background: linear-gradient(135deg, #d1fae5, #a7f3d0);">
                        <i class="bi bi-eye-fill fs-2" style="color: #059669;"></i>
                    </div>
                    <h5 class="fw-bold">Visi Kami</h5>
                    <p class="text-muted mb-0">{{ $profileSettings['profil_visi'] }}</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 70px; height: 70px; background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                        <i class="bi bi-bullseye fs-2" style="color: #2563eb;"></i>
                    </div>
                    <h5 class="fw-bold">Misi Kami</h5>
                    <p class="text-muted mb-0">{{ $profileSettings['profil_misi'] }}</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 70px; height: 70px; background: linear-gradient(135deg, #fef3c7, #fde68a);">
                        <i class="bi bi-stars fs-2" style="color: #d97706;"></i>
                    </div>
                    <h5 class="fw-bold">Nilai Kami</h5>
                    <p class="text-muted mb-0">{{ $profileSettings['profil_nilai'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kegiatan Section -->
<section class="py-5" id="kegiatan-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Kegiatan Kami</h2>
            <p class="section-subtitle">Lihat aktivitas dan perkembangan terbaru di panti asuhan kami</p>
        </div>

        <div class="row g-4">
            @forelse($kegiatan as $item)
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card h-100">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1509099836639-18ba1795216d?w=400&h=200&fit=crop" class="card-img-top" alt="{{ $item->judul }}">
                        @endif
                        <div class="card-body">
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $item->created_at->format('d M Y') }}</small>
                            <h5 class="card-title fw-bold mt-2">{{ $item->judul }}</h5>
                            <p class="card-text text-muted">{{ $item->short_description }}</p>
                            <a href="{{ route('kegiatan.show', $item->id_konten) }}" class="btn btn-outline-primary btn-sm">
                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-newspaper display-1 text-muted"></i>
                    <h5 class="mt-3">Belum Ada Kegiatan</h5>
                    <p class="text-muted">Konten kegiatan akan segera diperbarui.</p>
                </div>
            @endforelse
        </div>
        
        <div class="d-flex justify-content-center mt-5">
            {{ $kegiatan->links() }}
        </div>
    </div>
</section>
@endsection
