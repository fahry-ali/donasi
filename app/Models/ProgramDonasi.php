<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramDonasi extends Model
{
    use HasFactory;

    protected $table = 'program_donasi';
    protected $primaryKey = 'id_program';

    protected $fillable = [
        'id_kategori',
        'judul_program',
        'deskripsi',
        'target_dana',
        'dana_terkumpul',
        'status_program',
        'sumber_program',
        'gambar',
        'created_by',
    ];

    protected $casts = [
        'target_dana' => 'decimal:2',
        'dana_terkumpul' => 'decimal:2',
    ];

    /**
     * Get the category of this program.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriProgram::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Get the admin who created this program.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    /**
     * Get donations for this program.
     */
    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_program', 'id_program');
    }

    /**
     * Get confirmed donations for this program.
     */
    public function donasiDiterima()
    {
        return $this->donasi()->where('status_donasi', 'diterima');
    }

    /**
     * Get progress updates for this program.
     */
    public function updateProgres()
    {
        return $this->hasMany(UpdateProgres::class, 'id_program', 'id_program');
    }

    /**
     * Get donation progress percentage.
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->target_dana == 0) return 0;
        return min(100, ($this->dana_terkumpul / $this->target_dana) * 100);
    }

    /**
     * Check if program is active.
     */
    public function isAktif(): bool
    {
        return $this->status_program === 'aktif';
    }

    /**
     * Scope for active programs.
     */
    public function scopeAktif($query)
    {
        return $query->where('status_program', 'aktif');
    }

    /**
     * Scope for completed programs.
     */
    public function scopeSelesai($query)
    {
        return $query->where('status_program', 'selesai');
    }
}
