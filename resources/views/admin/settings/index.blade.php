@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Site & Logo Settings --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-globe me-2"></i>Pengaturan Website
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Website</label>
                            <input type="text" name="site_name" class="form-control"
                                   value="{{ old('site_name', $siteSettings['site_name']) }}" placeholder="Bumi Damai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. WhatsApp Konfirmasi</label>
                            <input type="text" name="wa_konfirmasi" class="form-control"
                                   value="{{ old('wa_konfirmasi', $siteSettings['wa_konfirmasi']) }}" placeholder="6281234567890">
                            <small class="text-muted">Format: 628xxx (tanpa +)</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Logo Website</label>
                            <input type="file" name="site_logo" class="form-control @error('site_logo') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, SVG, WebP. Maks 2MB.</small>
                            @error('site_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($siteSettings['site_logo'])
                                <div class="mt-2">
                                    <small class="text-muted d-block">Logo Saat Ini:</small>
                                    <img src="{{ asset($siteSettings['site_logo']) }}" alt="Logo" class="img-fluid border rounded p-1" style="max-height: 50px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hero Section Settings --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-image me-2"></i>Pengaturan Hero (Halaman Utama)
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Badge Teks</label>
                        <input type="text" name="hero_badge" class="form-control"
                               value="{{ old('hero_badge', $siteSettings['hero_badge']) }}" placeholder="Yayasan Sosial Kemanusiaan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Hero</label>
                        <input type="text" name="hero_title" class="form-control"
                               value="{{ old('hero_title', $siteSettings['hero_title']) }}" placeholder="Berbagi Kebahagiaan untuk Anak-Anak Panti">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Hero</label>
                        <textarea name="hero_subtitle" class="form-control" rows="3" placeholder="Deskripsi singkat...">{{ old('hero_subtitle', $siteSettings['hero_subtitle']) }}</textarea>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Foto Hero</label>
                        <input type="file" name="hero_image" class="form-control @error('hero_image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, WebP. Maks 5MB. Ukuran rekomendasi: 600x400px.</small>
                        @error('hero_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($siteSettings['hero_image'])
                            <div class="mt-2">
                                <small class="text-muted d-block">Foto Hero Saat Ini:</small>
                                <img src="{{ asset($siteSettings['hero_image']) }}" alt="Hero" class="img-fluid border rounded" style="max-height: 150px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Payment Settings --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-credit-card me-2"></i>Pengaturan Pembayaran
                </div>
                <div class="card-body">
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
                </div>
            </div>

            <div class="d-flex gap-2 mb-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Simpan Semua Pengaturan
                </button>
            </div>
        </form>
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
                    <li><strong>Logo & Nama</strong> — Navbar di semua halaman</li>
                    <li><strong>Hero</strong> — Halaman utama (beranda)</li>
                    <li><strong>No. WhatsApp</strong> — Tombol konfirmasi setelah donasi</li>
                    <li><strong>Pembayaran</strong> — Form donasi & footer</li>
                </ul>
                <hr>
                <p class="text-muted small mb-0">
                    <i class="bi bi-lightbulb me-1"></i>
                    Pastikan semua informasi sudah benar sebelum menyimpan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
