@extends('layouts.admin')

@section('page-title', 'Kategori Program')
@section('breadcrumb')
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Baru
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" 
                               value="{{ old('nama_kategori') }}" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus-circle me-1"></i>Tambah
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-tags me-2"></i>Daftar Kategori
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Jumlah Program</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori as $k)
                                <tr>
                                    <td>
                                        <form action="{{ route('admin.kategori.update', $k->id_kategori) }}" method="POST" class="d-flex gap-2">
                                            @csrf @method('PUT')
                                            <input type="text" name="nama_kategori" class="form-control form-control-sm" 
                                                   value="{{ $k->nama_kategori }}" style="max-width: 200px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary" title="Simpan">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $k->programs_count }} program</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Hapus kategori ini?')"
                                                    {{ $k->programs_count > 0 ? 'disabled' : '' }}>
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <p class="text-muted mb-0">Belum ada kategori</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
