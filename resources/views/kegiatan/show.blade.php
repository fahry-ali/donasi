@extends('layouts.app')

@section('title', $konten->judul . ' - Panti Bumi Damai')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article data-aos="fade-up">
                    @if($konten->gambar)
                        <img src="{{ asset('storage/' . $konten->gambar) }}" class="img-fluid rounded-4 w-100 mb-4" alt="{{ $konten->judul }}" style="max-height: 400px; object-fit: cover;">
                    @endif
                    
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge bg-primary">Kegiatan</span>
                        <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $konten->created_at->format('d F Y') }}</small>
                    </div>
                    
                    <h1 class="fw-bold mb-4">{{ $konten->judul }}</h1>
                    
                    <div class="prose">
                        {!! nl2br(e($konten->deskripsi)) !!}
                    </div>
                    
                    <hr class="my-5">
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </article>
            </div>
            
            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4">Kegiatan Lainnya</h5>
                    @forelse($latestKegiatan as $item)
                        <div class="card mb-3">
                            <div class="card-body p-3">
                                <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                <h6 class="fw-bold mb-0">
                                    <a href="{{ route('kegiatan.show', $item->id_konten) }}" class="text-decoration-none text-dark">
                                        {{ $item->judul }}
                                    </a>
                                </h6>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Tidak ada kegiatan lainnya.</p>
                    @endforelse
                    
                    <a href="{{ route('programs.index') }}" class="btn btn-primary w-100 mt-3">
                        <i class="bi bi-heart me-1"></i>Donasi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
