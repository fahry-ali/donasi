@extends('layouts.app')

@section('title', 'Program Donasi - Panti Bumi Damai')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <h1 class="section-title">Program Donasi</h1>
            <p class="section-subtitle mb-4">Pilih program yang ingin Anda dukung dan jadilah bagian dari perubahan</p>
            
            <!-- Filter -->
            <form action="{{ route('programs.index') }}" method="GET" class="row g-3 justify-content-center">
                <div class="col-md-4">
                    <select name="kategori" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari program..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Programs List -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($programs as $program)
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card h-100">
                        @if($program->gambar)
                            <img src="{{ asset('storage/' . $program->gambar) }}" class="card-img-top" alt="{{ $program->judul_program }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=200&fit=crop" class="card-img-top" alt="{{ $program->judul_program }}">
                        @endif
                        <div class="card-body">
                            <span class="badge mb-2" style="background: #d1fae5; color: #059669;">
                                {{ $program->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                            <h5 class="card-title fw-bold">{{ $program->judul_program }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($program->deskripsi, 100) }}</p>
                            
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
                    <h5 class="mt-3">Program Tidak Ditemukan</h5>
                    <p class="text-muted">Tidak ada program yang sesuai dengan filter Anda.</p>
                    <a href="{{ route('programs.index') }}" class="btn btn-outline-primary">Reset Filter</a>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $programs->withQueryString()->links() }}
        </div>
    </div>
</section>
@endsection
