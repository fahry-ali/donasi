@extends('layouts.admin')

@section('title', 'Pengaturan Pembayaran')
@section('page-title', 'Pengaturan Pembayaran')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-gear me-2"></i>Pengaturan Informasi Pembayaran
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h6 class="fw-bold mb-3"><i class="bi bi-bank me-2"></i>Rekening Bank 1 (Utama)</h6>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" name="bank1_nama" class="form-control @error('bank1_nama') is-invalid @enderror" 
                                   value="{{ old('bank1_nama', $settings['bank1_nama']) }}" placeholder="Bank BCA" required>
                            @error('bank1_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="bank1_norek" class="form-control @error('bank1_norek') is-invalid @enderror" 
                                   value="{{ old('bank1_norek', $settings['bank1_norek']) }}" placeholder="123-456-7890" required>
                            @error('bank1_norek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Atas Nama <span class="text-danger">*</span></label>
                            <input type="text" name="bank1_atas_nama" class="form-control @error('bank1_atas_nama') is-invalid @enderror" 
                                   value="{{ old('bank1_atas_nama', $settings['bank1_atas_nama']) }}" placeholder="Yayasan Bumi Damai" required>
                            @error('bank1_atas_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-3"><i class="bi bi-bank me-2"></i>Rekening Bank 2 (Opsional)</h6>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" name="bank2_nama" class="form-control" 
                                   value="{{ old('bank2_nama', $settings['bank2_nama']) }}" placeholder="Bank Mandiri">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="bank2_norek" class="form-control" 
                                   value="{{ old('bank2_norek', $settings['bank2_norek']) }}" placeholder="098-765-4321">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" name="bank2_atas_nama" class="form-control" 
                                   value="{{ old('bank2_atas_nama', $settings['bank2_atas_nama']) }}" placeholder="Yayasan Bumi Damai">
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h6 class="fw-bold mb-3"><i class="bi bi-qr-code me-2"></i>Pengaturan QRIS</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Gambar QRIS</label>
                            <input type="file" name="qris_image" class="form-control @error('qris_image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                            @error('qris_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($settings['qris_image'])
                                <div class="mt-3">
                                    <label class="form-label text-muted">Gambar QRIS Saat Ini:</label>
                                    <div class="border rounded p-2 bg-light text-center">
                                        <img src="{{ asset($settings['qris_image']) }}" alt="QRIS" class="img-fluid" style="max-height: 150px;">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">QRIS Atas Nama <span class="text-danger">*</span></label>
                            <input type="text" name="qris_atas_nama" class="form-control @error('qris_atas_nama') is-invalid @enderror" 
                                   value="{{ old('qris_atas_nama', $settings['qris_atas_nama']) }}" placeholder="Yayasan Bumi Damai" required>
                            @error('qris_atas_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Informasi
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Pengaturan ini akan ditampilkan pada:
                </p>
                <ul class="small text-muted">
                    <li>Halaman form donasi</li>
                    <li>Footer website</li>
                </ul>
                <hr>
                <p class="text-muted small mb-0">
                    <i class="bi bi-lightbulb me-1"></i>
                    Pastikan informasi rekening dan QRIS sudah benar sebelum menyimpan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
