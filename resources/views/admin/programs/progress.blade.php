@extends('layouts.admin')

@section('page-title', 'Update Progres Program')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.programs.index') }}">Program</a></li>
    <li class="breadcrumb-item active">Progres</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i>Tambah Update Progres
            </div>
            <div class="card-body">
                <h5 class="fw-bold mb-3">{{ $program->judul_program }}</h5>
                
                <form action="{{ route('admin.programs.progress.store', $program->id_program) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Update <span class="text-danger">*</span></label>
                        <textarea name="deskripsi_update" class="form-control" rows="4" required placeholder="Jelaskan perkembangan program...">{{ old('deskripsi_update') }}</textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Persentase Progres <span class="text-danger">*</span></label>
                            <div class="input-group" style="max-width: 200px;">
                                <input type="number" name="persentase" class="form-control" value="{{ old('persentase', 0) }}" min="0" max="100" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dana yang Digunakan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="dana_digunakan" class="form-control" value="{{ old('dana_digunakan') }}" min="0" placeholder="0">
                            </div>
                            <small class="text-muted">Opsional. Masukkan jumlah dana yang sudah digunakan.</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Foto Progres</label>
                        <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted">Opsional. Upload foto progres pembangunan (JPG/PNG, maks 2MB).</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Update
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history me-2"></i>Riwayat Update
            </div>
            <div class="card-body">
                @forelse($program->updateProgres->sortByDesc('created_at') as $update)
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                {{ $update->persentase }}%
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted">{{ $update->created_at->format('d M Y, H:i') }}</small>
                            <p class="mb-1">{{ $update->deskripsi_update }}</p>
                            
                            @if($update->dana_digunakan)
                                <span class="badge bg-warning text-dark me-2">
                                    <i class="bi bi-cash-stack me-1"></i>Dana Digunakan: Rp {{ number_format($update->dana_digunakan, 0, ',', '.') }}
                                </span>
                            @endif
                            
                            @if($update->foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $update->foto) }}" class="rounded border" style="max-width: 300px; max-height: 200px; object-fit: cover;" alt="Foto Progres">
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4 mb-0">Belum ada update progres</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Info Program</div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Dana Terkumpul</small>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar" style="width: {{ $program->progress_percentage }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold text-primary">Rp {{ number_format($program->dana_terkumpul, 0, ',', '.') }}</span>
                        <span class="text-muted">{{ number_format($program->progress_percentage, 1) }}%</span>
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Target Dana</small>
                    <p class="fw-semibold mb-0">Rp {{ number_format($program->target_dana, 0, ',', '.') }}</p>
                </div>
                
                @php
                    $totalDanaDigunakan = $program->updateProgres->sum('dana_digunakan');
                @endphp
                @if($totalDanaDigunakan > 0)
                <div class="mb-3">
                    <small class="text-muted">Total Dana Digunakan</small>
                    <p class="fw-semibold mb-0 text-warning">Rp {{ number_format($totalDanaDigunakan, 0, ',', '.') }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Sisa Dana</small>
                    <p class="fw-semibold mb-0 text-success">Rp {{ number_format($program->dana_terkumpul - $totalDanaDigunakan, 0, ',', '.') }}</p>
                </div>
                @endif
                
                <div class="mb-3">
                    <small class="text-muted">Status</small>
                    <p class="mb-0">
                        <span class="badge bg-{{ $program->status_program == 'aktif' ? 'success' : 'secondary' }}">
                            {{ ucfirst($program->status_program) }}
                        </span>
                    </p>
                </div>
                <a href="{{ route('admin.programs.edit', $program->id_program) }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-pencil me-1"></i>Edit Program
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
