<?php

namespace App\Http\Controllers;

use App\Models\KontenKegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display list of activities.
     */
    public function index()
    {
        $kegiatan = KontenKegiatan::orderBy('created_at', 'desc')
            ->paginate(9);

        return view('kegiatan.index', compact('kegiatan'));
    }

    /**
     * Display activity detail.
     */
    public function show($id)
    {
        $konten = KontenKegiatan::findOrFail($id);
        
        $latestKegiatan = KontenKegiatan::where('id_konten', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('kegiatan.show', compact('konten', 'latestKegiatan'));
    }
}
