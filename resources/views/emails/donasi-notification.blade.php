<x-mail::message>
# 🙏 Terima Kasih Atas Donasi Anda!

Halo **{{ $donasi->nama_donatur }}**,

Donasi Anda telah berhasil dikirim dan sedang menunggu verifikasi dari tim kami.

---

<div style="text-align: center; background: #f0fdf4; padding: 20px; border-radius: 10px; margin: 20px 0;">
<small style="color: #666;">Kode Transaksi Anda</small><br>
<span style="font-size: 24px; font-weight: bold; color: #10b981; letter-spacing: 2px;">{{ $donasi->kode_transaksi }}</span><br>
<small style="color: #666;">Simpan kode ini untuk melacak status donasi</small>
</div>

---

## 📋 Detail Donasi

| | |
|:--|--:|
| **Program** | {{ $program->nama_program ?? 'Program Donasi' }} |
| **Nama Donatur** | {{ $donasi->nama_donatur }} |
| **Nominal** | **Rp {{ number_format($donasi->nominal, 0, ',', '.') }}** |
| **Metode** | {{ ucfirst($donasi->metode_pembayaran) }} |
| **Status** |  Menunggu Verifikasi |
| **Tanggal** | {{ $donasi->created_at->format('d M Y, H:i') }} WIB |

@if($donasi->pesan)
---
**Pesan/Doa Anda:**
> {{ $donasi->pesan }}
@endif

---

<x-mail::button :url="url('/lacak-donasi?kode=' . $donasi->kode_transaksi)" color="success">
🔍 Lacak Status Donasi
</x-mail::button>

Kami akan segera memverifikasi donasi Anda. Terima kasih atas kebaikan hati Anda! ❤️

Salam hangat,<br>
**Tim Panti Asuhan Bumi Damai**

<small style="color: #999;">Email ini dikirim otomatis. Jika Anda tidak melakukan donasi, abaikan email ini.</small>
</x-mail::message>
