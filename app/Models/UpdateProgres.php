<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UpdateProgres extends Model
{
    use HasFactory;

    protected $table = 'update_progres';
    protected $primaryKey = 'id_update';

    protected $fillable = [
        'id_program',
        'deskripsi_update',
        'persentase',
    ];

    /**
     * Get the program for this update.
     */
    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'id_program', 'id_program');
    }
}
