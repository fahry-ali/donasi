@extends('layouts.user')

@section('title', 'Usulan Saya - Panti Bumi Damai')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Usulan Program Saya</h4>
        <p class="text-muted mb-0">Kelola semua usulan program bantuan yang Anda ajukan</p>
    </div>
    <a href="{{ route('user.usulan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Ajukan Usulan
    </a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-4">
            <div class="col-md-3">
                <form action="{{ route('user.usulan.index') }}" method="GET">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Usulan</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usulan as $u)
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ Str::limit($u->judul_usulan, 40) }}</h6>
                                <small class="text-muted">{{ Str::limit($u->deskripsi, 50) }}</small>
                            </td>
                            <td><i class="bi bi-geo-alt me-1 text-muted"></i>{{ $u->lokasi }}</td>
                            <td>{{ $u->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $u->status_badge_color }}">
                                    {{ ucfirst($u->status_usulan) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('user.usulan.show', $u->id_usulan) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-2">Anda belum mengajukan usulan program</p>
                                <a href="{{ route('user.usulan.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Ajukan Usulan Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $usulan->withQueryString()->links() }}
    </div>
</div>
@endsection
