<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UsulanProgram;
use Illuminate\Http\Request;

class UsulanProgramController extends Controller
{
    /**
     * Display list of user's proposals.
     */
    public function index()
    {
        $usulan = UsulanProgram::where('id_user', auth()->user()->id_user)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.usulan.index', compact('usulan'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('user.usulan.create');
    }

    /**
     * Store new proposal.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_usulan' => 'required|string|max:150',
            'lokasi' => 'required|string|max:150',
            'deskripsi' => 'required|string|min:50',
            'foto_pendukung' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'deskripsi.min' => 'Deskripsi minimal 50 karakter.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_pendukung')) {
            $fotoPath = $request->file('foto_pendukung')->store('usulan', 'public');
        }

        UsulanProgram::create([
            'id_user' => auth()->user()->id_user,
            'judul_usulan' => $request->judul_usulan,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'foto_pendukung' => $fotoPath,
        ]);

        return redirect()->route('user.usulan.index')
            ->with('success', 'Usulan program berhasil diajukan. Silakan tunggu proses review dari admin.');
    }

    /**
     * Show proposal detail.
     */
    public function show($id)
    {
        $usulan = UsulanProgram::where('id_user', auth()->user()->id_user)
            ->findOrFail($id);

        return view('user.usulan.show', compact('usulan'));
    }
}
