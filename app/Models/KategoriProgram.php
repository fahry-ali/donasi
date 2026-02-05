<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriProgram extends Model
{
    use HasFactory;

    protected $table = 'kategori_program';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Get programs in this category.
     */
    public function programs()
    {
        return $this->hasMany(ProgramDonasi::class, 'id_kategori', 'id_kategori');
    }
}
