@extends('layouts.app')

@section('title', 'Kegiatan - Panti Bumi Damai')

@section('content')
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <h1 class="section-title">Kegiatan Kami</h1>
            <p class="section-subtitle">Lihat aktivitas dan perkembangan terbaru di panti asuhan kami</p>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
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
