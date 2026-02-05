<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';
    protected $primaryKey = 'id_donasi';

    protected $fillable = [
        'id_program',
        'nama_donatur',
        'email',
        'no_hp',
        'nominal',
        'metode_pembayaran',
        'bukti_transfer',
        'status_donasi',
        'kode_transaksi',
        'pesan',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    /**
     * Boot method to auto-generate transaction code.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($donasi) {
            if (empty($donasi->kode_transaksi)) {
                $donasi->kode_transaksi = self::generateKodeTransaksi();
            }
        });
    }

    /**
     * Generate unique transaction code.
     */
    public static function generateKodeTransaksi(): string
    {
        do {
            $code = 'DNT-' . strtoupper(Str::random(8)) . '-' . date('Ymd');
        } while (self::where('kode_transaksi', $code)->exists());

        return $code;
    }

    /**
     * Get the program for this donation.
     */
    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'id_program', 'id_program');
    }

    /**
     * Check if donation is pending.
     */
    public function isPending(): bool
    {
        return $this->status_donasi === 'menunggu';
    }

    /**
     * Check if donation is accepted.
     */
    public function isDiterima(): bool
    {
        return $this->status_donasi === 'diterima';
    }

    /**
     * Check if donation is rejected.
     */
    public function isDitolak(): bool
    {
        return $this->status_donasi === 'ditolak';
    }

    /**
     * Scope for pending donations.
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status_donasi', 'menunggu');
    }

    /**
     * Scope for accepted donations.
     */
    public function scopeDiterima($query)
    {
        return $query->where('status_donasi', 'diterima');
    }

    /**
     * Get badge color for status.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status_donasi) {
            'menunggu' => 'warning',
            'diterima' => 'success',
            'ditolak' => 'danger',
            default => 'secondary',
        };
    }
}
