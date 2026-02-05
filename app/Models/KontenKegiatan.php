<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KontenKegiatan extends Model
{
    use HasFactory;

    protected $table = 'konten_kegiatan';
    protected $primaryKey = 'id_konten';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'created_by',
    ];

    /**
     * Get the admin who created this content.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    /**
     * Get short description.
     */
    public function getShortDescriptionAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->deskripsi), 150);
    }
}
