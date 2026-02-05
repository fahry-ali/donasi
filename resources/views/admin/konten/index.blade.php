@extends('layouts.admin')

@section('page-title', 'Konten Kegiatan')
@section('breadcrumb')
    <li class="breadcrumb-item active">Konten</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-newspaper me-2"></i>Daftar Konten Kegiatan</span>
        <a href="{{ route('admin.konten.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Tambah Konten
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Konten</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konten as $k)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($k->gambar)
                                        <img src="{{ asset('storage/' . $k->gambar) }}" class="rounded" width="60" height="45" style="object-fit: cover;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:60px;height:45px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ Str::limit($k->judul, 50) }}</h6>
                                        <small class="text-muted">{{ Str::limit($k->deskripsi, 60) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $k->creator->nama ?? '-' }}</td>
                            <td>{{ $k->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kegiatan.show', $k->id_konten) }}" target="_blank" class="btn btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.konten.edit', $k->id_konten) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.konten.destroy', $k->id_konten) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Hapus konten ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-2">Belum ada konten kegiatan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $konten->links() }}
    </div>
</div>
@endsection
