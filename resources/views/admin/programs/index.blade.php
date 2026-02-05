@extends('layouts.admin')

@section('page-title', 'Kelola Program Donasi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Program Donasi</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-collection me-2"></i>Daftar Program Donasi</span>
        <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Tambah Program
        </a>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-4">
            <div class="col-md-4">
                <form action="{{ route('admin.programs.index') }}" method="GET">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </form>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Kategori</th>
                        <th>Target</th>
                        <th>Terkumpul</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $program)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($program->gambar)
                                        <img src="{{ asset('storage/' . $program->gambar) }}" class="rounded" width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ Str::limit($program->judul_program, 40) }}</h6>
                                        <small class="text-muted">{{ $program->sumber_program }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $program->kategori->nama_kategori ?? '-' }}</td>
                            <td>Rp {{ number_format($program->target_dana, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($program->dana_terkumpul, 0, ',', '.') }}</td>
                            <td style="width: 150px;">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $program->progress_percentage }}%"></div>
                                </div>
                                <small>{{ number_format($program->progress_percentage, 1) }}%</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $program->status_program == 'aktif' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($program->status_program) }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.programs.edit', $program->id_program) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.programs.progress', $program->id_program) }}"><i class="bi bi-graph-up me-2"></i>Update Progres</a></li>
                                        <li><a class="dropdown-item" href="{{ route('programs.show', $program->id_program) }}" target="_blank"><i class="bi bi-eye me-2"></i>Lihat</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.programs.destroy', $program->id_program) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-2">Belum ada program donasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $programs->links() }}
    </div>
</div>
@endsection
