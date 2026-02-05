@extends('layouts.admin')

@section('page-title', 'Kelola Donasi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Donasi</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-cash-coin me-2"></i>Daftar Donasi Masuk
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-4">
            <div class="col-md-3">
                <form action="{{ route('admin.donasi.index') }}" method="GET" id="filterForm">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>
            <div class="col-md-4">
                <form action="{{ route('admin.donasi.index') }}" method="GET">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama/kode..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Donatur</th>
                        <th>Program</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donasi as $d)
                        <tr>
                            <td><code>{{ $d->kode_transaksi }}</code></td>
                            <td>
                                <div>{{ $d->nama_donatur }}</div>
                                <small class="text-muted">{{ $d->email ?? '-' }}</small>
                            </td>
                            <td>{{ Str::limit($d->program->judul_program, 30) }}</td>
                            <td class="fw-bold text-primary">Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
                            <td>{{ $d->created_at->format('d M Y') }}<br><small class="text-muted">{{ $d->created_at->format('H:i') }}</small></td>
                            <td>
                                <span class="badge bg-{{ $d->status_badge_color }}">
                                    {{ ucfirst($d->status_donasi) }}
                                </span>
                            </td>
                            <td>
                                @if($d->status_donasi == 'menunggu')
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.donasi.show', $d->id_donasi) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.donasi.approve', $d->id_donasi) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi donasi ini?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.donasi.reject', $d->id_donasi) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak donasi ini?')">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <a href="{{ route('admin.donasi.show', $d->id_donasi) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-2">Tidak ada donasi ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $donasi->withQueryString()->links() }}
    </div>
</div>
@endsection
