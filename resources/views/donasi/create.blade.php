@extends('layouts.app')

@section('title', 'Donasi untuk ' . $program->judul_program)

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card" data-aos="fade-up">
                    <div class="card-body p-4 p-lg-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-primary-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: #d1fae5 !important;">
                                <i class="bi bi-heart-fill fs-2 text-primary"></i>
                            </div>
                            <h3 class="fw-bold">Form Donasi</h3>
                            <p class="text-muted">{{ $program->judul_program }}</p>
                        </div>
                        
                        <!-- Bank Info -->
                        <div id="bank-info" class="alert" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                            <h6 class="fw-bold mb-3"><i class="bi bi-bank me-2"></i>Transfer ke Rekening:</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong>{{ $paymentSettings['bank1_nama'] }}</strong><br>
                                    <span class="fs-5 fw-bold text-primary">{{ $paymentSettings['bank1_norek'] }}</span><br>
                                    <small>a.n. {{ $paymentSettings['bank1_atas_nama'] }}</small>
                                </div>
                                @if($paymentSettings['bank2_nama'] && $paymentSettings['bank2_norek'])
                                <div class="col-md-6 mb-2">
                                    <strong>{{ $paymentSettings['bank2_nama'] }}</strong><br>
                                    <span class="fs-5 fw-bold text-primary">{{ $paymentSettings['bank2_norek'] }}</span><br>
                                    <small>a.n. {{ $paymentSettings['bank2_atas_nama'] }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- QRIS Info -->
                        <div id="qris-info" class="alert" style="background: #f0fdf4; border: 1px solid #bbf7d0; display: none;">
                            <h6 class="fw-bold mb-3"><i class="bi bi-qr-code me-2"></i>Scan QRIS untuk Pembayaran:</h6>
                            <div class="text-center">
                                <div class="bg-white p-3 rounded d-inline-block mb-3" style="border: 2px dashed #10b981;">
                                    <!-- QRIS Code Image -->
                                    <img src="{{ asset($paymentSettings['qris_image']) }}" alt="QRIS Code" class="img-fluid" style="max-width: 250px; height: auto;">
                                </div>
                                <p class="text-muted mb-1"><small>Scan QR code di atas menggunakan aplikasi e-wallet atau mobile banking Anda</small></p>
                                <p class="fw-semibold text-primary">a.n. {{ $paymentSettings['qris_atas_nama'] }}</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('donasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_program" value="{{ $program->id_program }}">
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_donatur" class="form-control @error('nama_donatur') is-invalid @enderror" 
                                           value="{{ old('nama_donatur') }}" placeholder="Masukkan nama Anda" required>
                                    @error('nama_donatur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" placeholder="email@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">No. HP/WhatsApp</label>
                                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                           value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nominal Donasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="nominal" class="form-control @error('nominal') is-invalid @enderror" 
                                               value="{{ old('nominal') }}" placeholder="100000" min="10000" required>
                                    </div>
                                    <small class="text-muted">Minimal Rp 10.000</small>
                                    @error('nominal')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Quick Amount Buttons -->
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @foreach([50000, 100000, 250000, 500000, 1000000] as $amount)
                                            <button type="button" class="btn btn-outline-primary btn-sm" 
                                                    onclick="document.querySelector('input[name=nominal]').value = {{ $amount }}">
                                                Rp {{ number_format($amount, 0, ',', '.') }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Metode Pembayaran <span class="text-danger">*</span></label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="radio" name="metode_pembayaran" value="transfer" id="transfer" class="btn-check" checked>
                                            <label for="transfer" class="btn btn-outline-primary w-100 py-3">
                                                <i class="bi bi-bank fs-4 d-block mb-1"></i>
                                                Transfer Bank
                                            </label>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="metode_pembayaran" value="qris" id="qris" class="btn-check">
                                            <label for="qris" class="btn btn-outline-primary w-100 py-3">
                                                <i class="bi bi-qr-code fs-4 d-block mb-1"></i>
                                                QRIS
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Upload Bukti Transfer <span class="text-danger">*</span></label>
                                    <input type="file" name="bukti_transfer" class="form-control @error('bukti_transfer') is-invalid @enderror" 
                                           accept="image/*" required>
                                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                                    @error('bukti_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Pesan / Doa (Opsional)</label>
                                    <textarea name="pesan" class="form-control" rows="3" placeholder="Tulis pesan atau doa Anda...">{{ old('pesan') }}</textarea>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-heart-fill me-2"></i>Konfirmasi Donasi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('programs.show', $program->id_program) }}" class="text-muted">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Detail Program
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const transferRadio = document.getElementById('transfer');
    const qrisRadio = document.getElementById('qris');
    const bankInfo = document.getElementById('bank-info');
    const qrisInfo = document.getElementById('qris-info');
    
    function togglePaymentInfo() {
        if (qrisRadio.checked) {
            bankInfo.style.display = 'none';
            qrisInfo.style.display = 'block';
        } else {
            bankInfo.style.display = 'block';
            qrisInfo.style.display = 'none';
        }
    }
    
    // Add event listeners
    transferRadio.addEventListener('change', togglePaymentInfo);
    qrisRadio.addEventListener('change', togglePaymentInfo);
    
    // Initial state
    togglePaymentInfo();
});
</script>
@endpush
