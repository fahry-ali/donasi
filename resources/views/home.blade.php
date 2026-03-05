@extends('layouts.app')

@section('title', 'Donasi Panti Bumi Damai - Berbagi untuk Kebaikan')

@section('content')
<!-- Hero Section -->
@php
    $siteSettings = \App\Models\Setting::getSiteSettings();
@endphp
<section class="hero-section" style="background: linear-gradient(135deg, #064e3b 0%, #1e40af 100%); padding: 6rem 0; color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge bg-white text-primary-dark px-3 py-2 mb-3" style="color: #064e3b !important;">
                    <i class="bi bi-heart-fill me-1"></i> {{ $siteSettings['hero_badge'] }}
                </span>
                <h1 class="display-4 fw-bold mb-4">{{ $siteSettings['hero_title'] }}</h1>
                <p class="lead mb-4 opacity-75">{{ $siteSettings['hero_subtitle'] }}</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('programs.index') }}" class="btn btn-light btn-lg px-4" style="color: #064e3b;">
                        <i class="bi bi-hand-index-thumb me-2"></i>Donasi Sekarang
                    </a>
                    <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-play-circle me-2"></i>Lihat Kegiatan
                    </a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="text-center">
                    @if($siteSettings['hero_image'])
                        <img src="{{ asset($siteSettings['hero_image']) }}" 
                             alt="Hero Image" class="img-fluid rounded-4 shadow-lg" style="max-height: 400px; object-fit: cover;">
                    @else
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600&h=400&fit=crop" 
                             alt="Anak-anak Panti" class="img-fluid rounded-4 shadow-lg" style="max-height: 400px; object-fit: cover;">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5" style="margin-top: -3rem;">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                <div class="card h-100 text-center p-4">
                    <div class="display-4 fw-bold text-primary mb-2">Rp {{ number_format($totalDonasi/1000000, 0, ',', '.') }}Jt+</div>
                    <p class="text-muted mb-0">Total Donasi Terkumpul</p>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 text-center p-4">
                    <div class="display-4 fw-bold text-primary mb-2">{{ $totalDonatur }}</div>
                    <p class="text-muted mb-0">Donatur Baik Hati</p>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 text-center p-4">
                    <div class="display-4 fw-bold text-primary mb-2">{{ $totalProgram }}</div>
                    <p class="text-muted mb-0">Program Donasi</p>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 text-center p-4">
                    <div class="display-4 fw-bold text-primary mb-2">{{ $programSelesai }}</div>
                    <p class="text-muted mb-0">Program Terpenuhi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Programs Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Program Donasi Aktif</h2>
            <p class="section-subtitle">Pilih program yang ingin Anda dukung dan jadilah bagian dari perubahan</p>
        </div>
        
        <div class="row g-4">
            @forelse($programs as $program)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card h-100">
                        @if($program->gambar)
                            <img src="{{ asset('storage/' . $program->gambar) }}" class="card-img-top" alt="{{ $program->judul_program }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=200&fit=crop" class="card-img-top" alt="{{ $program->judul_program }}">
                        @endif
                        <div class="card-body">
                            <span class="badge bg-primary-light text-primary mb-2" style="background: #d1fae5 !important; color: #059669 !important;">
                                {{ $program->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                            <h5 class="card-title fw-bold">{{ $program->judul_program }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($program->deskripsi, 80) }}</p>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Terkumpul</span>
                                    <span class="fw-bold">{{ number_format($program->progress_percentage, 0) }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $program->progress_percentage }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between small mt-2">
                                    <span class="text-primary fw-bold">Rp {{ number_format($program->dana_terkumpul, 0, ',', '.') }}</span>
                                    <span class="text-muted">dari Rp {{ number_format($program->target_dana, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('programs.show', $program->id_program) }}" class="btn btn-primary w-100">
                                <i class="bi bi-heart me-1"></i> Donasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada program donasi aktif saat ini.</p>
                </div>
            @endforelse
        </div>
        
        @if($programs->count() >= 6)
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('programs.index') }}" class="btn btn-outline-primary btn-lg px-5">
                    Lihat Semua Program <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- How It Works -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Cara Berdonasi</h2>
            <p class="section-subtitle">Berdonasi dengan mudah dan transparan hanya dalam 3 langkah</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="text-center p-4">
                    <div class="rounded-circle bg-primary-light d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; background: #d1fae5 !important;">
                        <i class="bi bi-search fs-2 text-primary"></i>
                    </div>
                    <h5 class="fw-bold">1. Pilih Program</h5>
                    <p class="text-muted">Pilih program donasi yang ingin Anda dukung sesuai dengan minat dan kemampuan Anda.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center p-4">
                    <div class="rounded-circle bg-primary-light d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; background: #d1fae5 !important;">
                        <i class="bi bi-credit-card fs-2 text-primary"></i>
                    </div>
                    <h5 class="fw-bold">2. Transfer & Upload Bukti</h5>
                    <p class="text-muted">Transfer ke rekening kami dan upload bukti transfer melalui form yang tersedia.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center p-4">
                    <div class="rounded-circle bg-primary-light d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; background: #d1fae5 !important;">
                        <i class="bi bi-check-circle fs-2 text-primary"></i>
                    </div>
                    <h5 class="fw-bold">3. Donasi Terverifikasi</h5>
                    <p class="text-muted">Tim kami akan memverifikasi donasi Anda dan dana akan disalurkan ke program terkait.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Activities Section -->
@if($kegiatan->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Kegiatan Terbaru</h2>
            <p class="section-subtitle">Lihat aktivitas dan perkembangan di panti asuhan kami</p>
        </div>
        
        <div class="row g-4">
            @foreach($kegiatan as $item)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
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
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5 bg-primary text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;">
    <div class="container text-center py-4" data-aos="fade-up">
        <h2 class="display-6 fw-bold mb-3">Ingin Mengajukan Program Bantuan?</h2>
        <p class="lead mb-4 opacity-75">Jika Anda mengetahui lokasi yang membutuhkan bantuan, ajukan usulan program kepada kami</p>
        @auth
            @if(auth()->user()->isMasyarakat())
                <a href="{{ route('user.usulan.create') }}" class="btn btn-light btn-lg px-5" style="color: #059669;">
                    <i class="bi bi-plus-circle me-2"></i>Ajukan Usulan Program
                </a>
            @endif
        @else
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5" style="color: #059669;">
                <i class="bi bi-person-plus me-2"></i>Daftar untuk Mengajukan
            </a>
        @endauth
    </div>
</section>
@endsection
