<?php

namespace App\Http\Controllers;

use App\Models\ProgramDonasi;
use App\Models\KategoriProgram;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display list of donation programs.
     */
    public function index(Request $request)
    {
        $query = ProgramDonasi::with('kategori')->aktif();

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('judul_program', 'like', '%' . $request->search . '%');
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(9);
        $kategori = KategoriProgram::all();

        return view('programs.index', compact('programs', 'kategori'));
    }

    /**
     * Display program detail.
     */
    public function show($id)
    {
        $program = ProgramDonasi::with(['kategori', 'updateProgres' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'donasiDiterima' => function($query) {
            $query->orderBy('created_at', 'desc')->take(10);
        }])->findOrFail($id);

        // Get related programs
        $relatedPrograms = ProgramDonasi::where('id_kategori', $program->id_kategori)
            ->where('id_program', '!=', $program->id_program)
            ->aktif()
            ->take(3)
            ->get();

        return view('programs.show', compact('program', 'relatedPrograms'));
    }
}
