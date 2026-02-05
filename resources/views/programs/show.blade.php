@extends('layouts.app')

@section('title', $program->judul_program . ' - Panti Bumi Damai')

@push('styles')
<style>
    .program-image {
        height: 400px;
        object-fit: cover;
    }
    
    @media (max-width: 768px) {
        .program-image {
            height: 220px;
        }
        
        .sticky-sidebar {
            position: relative !important;
            top: 0 !important;
        }
        
        .donation-amount h4 {
            font-size: 1rem !important;
        }
        
        .col-lg-8 h2 {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .program-image {
            height: 180px;
        }
    }
</style>
@endpush

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8" data-aos="fade-right">
                <!-- Program Image -->
                <div class="card mb-4">
                    @if($program->gambar)
                        <img src="{{ asset('storage/' . $program->gambar) }}" class="card-img-top rounded-4 program-image" alt="{{ $program->judul_program }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=800&h=400&fit=crop" class="card-img-top rounded-4 program-image" alt="{{ $program->judul_program }}">
                    @endif
                </div>
                
                <!-- Program Info -->
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge" style="background: #d1fae5; color: #059669;">{{ $program->kategori->nama_kategori ?? 'Umum' }}</span>
                            <span class="badge" style="background: {{ $program->sumber_program == 'yayasan' ? '#dbeafe' : '#fef3c7' }}; color: {{ $program->sumber_program == 'yayasan' ? '#1d4ed8' : '#d97706' }};">
                                {{ ucfirst($program->sumber_program) }}
                            </span>
                            @if($program->status_program == 'selesai')
                                <span class="badge bg-secondary">Program Selesai</span>
                            @endif
                        </div>
                        
                        <h2 class="fw-bold mb-4">{{ $program->judul_program }}</h2>
                        
                        <div class="prose">
                            {!! nl2br(e($program->deskripsi)) !!}
                        </div>
                    </div>
                </div>
                
                <!-- Progress Updates -->
                @if($program->updateProgres->count() > 0)
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Update Progres</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @foreach($program->updateProgres as $update)
                                    <div class="d-flex gap-3 mb-4">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                {{ $update->persentase }}%
                                            </div>
                                        </div>
                                        <div>
                                            <small class="text-muted">{{ $update->created_at->format('d M Y, H:i') }}</small>
                                            <p class="mb-0">{{ $update->deskripsi_update }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4" data-aos="fade-left">
                <!-- Donation Progress Card -->
                <div class="card mb-4 sticky-top sticky-sidebar" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Progres Donasi</h5>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Terkumpul</span>
                                <span class="fw-bold">{{ number_format($program->progress_percentage, 1) }}%</span>
                            </div>
                            <div class="progress mb-3" style="height: 12px;">
                                <div class="progress-bar" style="width: {{ $program->progress_percentage }}%"></div>
                            </div>
                            <div class="row text-center donation-amount">
                                <div class="col-6">
                                    <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($program->dana_terkumpul, 0, ',', '.') }}</h4>
                                    <small class="text-muted">Terkumpul</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="fw-bold mb-0">Rp {{ number_format($program->target_dana, 0, ',', '.') }}</h4>
                                    <small class="text-muted">Target</small>
                                </div>
                            </div>
                        </div>
                        
                        @if($program->isAktif())
                            <a href="{{ route('donasi.create', $program->id_program) }}" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-heart-fill me-2"></i>Donasi Sekarang
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg w-100" disabled>
                                Program Telah Selesai
                            </button>
                        @endif
                        
                        <hr class="my-4">
                        
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-person-circle fs-4 text-muted"></i>
                            <div>
                                <small class="text-muted">Dibuat oleh</small>
                                <p class="mb-0 fw-semibold">{{ $program->creator->nama ?? 'Admin' }}</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-calendar3 fs-4 text-muted"></i>
                            <div>
                                <small class="text-muted">Tanggal Dibuat</small>
                                <p class="mb-0 fw-semibold">{{ $program->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Donors -->
                @if($program->donasiDiterima->count() > 0)
                    <div class="card">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><i class="bi bi-people me-2"></i>Donatur Terbaru</h6>
                        </div>
                        <div class="card-body">
                            @foreach($program->donasiDiterima->take(5) as $donasi)
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-circle bg-primary-light text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #d1fae5 !important; color: #059669 !important;">
                                        {{ strtoupper(substr($donasi->nama_donatur, 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-semibold">{{ $donasi->nama_donatur }}</p>
                                        <small class="text-muted">{{ $donasi->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="text-primary fw-bold">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Related Programs -->
        @if($relatedPrograms->count() > 0)
            <div class="mt-5">
                <h4 class="fw-bold mb-4">Program Serupa</h4>
                <div class="row g-4">
                    @foreach($relatedPrograms as $related)
                        <div class="col-md-4">
                            <div class="card h-100">
                                @if($related->gambar)
                                    <img src="{{ asset('storage/' . $related->gambar) }}" class="card-img-top" alt="{{ $related->judul_program }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&h=200&fit=crop" class="card-img-top" alt="{{ $related->judul_program }}">
                                @endif
                                <div class="card-body">
                                    <h6 class="fw-bold">{{ $related->judul_program }}</h6>
                                    <div class="progress mb-2" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{ $related->progress_percentage }}%"></div>
                                    </div>
                                    <a href="{{ route('programs.show', $related->id_program) }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
