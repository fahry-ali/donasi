<?php

namespace App\Http\Controllers;

use App\Models\ProgramDonasi;
use App\Models\KontenKegiatan;
use App\Models\Donasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get active programs
        $programs = ProgramDonasi::with('kategori')
            ->aktif()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Get latest activities
        $kegiatan = KontenKegiatan::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get statistics
        $totalDonasi = Donasi::diterima()->sum('nominal');
        $totalDonatur = Donasi::diterima()->count();
        $totalProgram = ProgramDonasi::count();
        $programSelesai = ProgramDonasi::selesai()->count();

        return view('home', compact(
            'programs',
            'kegiatan',
            'totalDonasi',
            'totalDonatur',
            'totalProgram',
            'programSelesai'
        ));
    }
}
