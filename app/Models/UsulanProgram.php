<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsulanProgram extends Model
{
    use HasFactory;

    protected $table = 'usulan_program';
    protected $primaryKey = 'id_usulan';

    protected $fillable = [
        'id_user',
        'judul_usulan',
        'lokasi',
        'deskripsi',
        'foto_pendukung',
        'status_usulan',
        'catatan_admin',
    ];

    /**
     * Get the user who submitted this proposal.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Check if proposal is pending.
     */
    public function isPending(): bool
    {
        return $this->status_usulan === 'menunggu';
    }

    /**
     * Check if proposal is accepted.
     */
    public function isDiterima(): bool
    {
        return $this->status_usulan === 'diterima';
    }

    /**
     * Check if proposal is rejected.
     */
    public function isDitolak(): bool
    {
        return $this->status_usulan === 'ditolak';
    }

    /**
     * Scope for pending proposals.
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status_usulan', 'menunggu');
    }

    /**
     * Get badge color for status.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status_usulan) {
            'menunggu' => 'warning',
            'diterima' => 'success',
            'ditolak' => 'danger',
            default => 'secondary',
        };
    }
}
