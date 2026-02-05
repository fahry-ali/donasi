<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramDonasi;
use App\Models\KategoriProgram;
use App\Models\UpdateProgres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramDonasiController extends Controller
{
    /**
     * Display list of programs.
     */
    public function index(Request $request)
    {
        $query = ProgramDonasi::with('kategori');

        if ($request->filled('status')) {
            $query->where('status_program', $request->status);
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.programs.index', compact('programs'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $kategori = KategoriProgram::all();
        return view('admin.programs.create', compact('kategori'));
    }

    /**
     * Store new program.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_program,id_kategori',
            'judul_program' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'target_dana' => 'required|numeric|min:100000',
            'sumber_program' => 'required|in:yayasan,masyarakat',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('programs', 'public');
        }

        ProgramDonasi::create([
            'id_kategori' => $request->id_kategori,
            'judul_program' => $request->judul_program,
            'deskripsi' => $request->deskripsi,
            'target_dana' => $request->target_dana,
            'sumber_program' => $request->sumber_program,
            'gambar' => $gambarPath,
            'created_by' => auth()->user()->id_user,
        ]);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program donasi berhasil ditambahkan.');
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $program = ProgramDonasi::findOrFail($id);
        $kategori = KategoriProgram::all();
        return view('admin.programs.edit', compact('program', 'kategori'));
    }

    /**
     * Update program.
     */
    public function update(Request $request, $id)
    {
        $program = ProgramDonasi::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:kategori_program,id_kategori',
            'judul_program' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'target_dana' => 'required|numeric|min:100000',
            'status_program' => 'required|in:aktif,selesai',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($program->gambar) {
                Storage::disk('public')->delete($program->gambar);
            }
            $program->gambar = $request->file('gambar')->store('programs', 'public');
        }

        $program->update([
            'id_kategori' => $request->id_kategori,
            'judul_program' => $request->judul_program,
            'deskripsi' => $request->deskripsi,
            'target_dana' => $request->target_dana,
            'status_program' => $request->status_program,
            'gambar' => $program->gambar,
        ]);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program donasi berhasil diperbarui.');
    }

    /**
     * Delete program.
     */
    public function destroy($id)
    {
        $program = ProgramDonasi::findOrFail($id);
        
        if ($program->gambar) {
            Storage::disk('public')->delete($program->gambar);
        }

        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program donasi berhasil dihapus.');
    }

    /**
     * Show progress update form.
     */
    public function showProgress($id)
    {
        $program = ProgramDonasi::with('updateProgres')->findOrFail($id);
        return view('admin.programs.progress', compact('program'));
    }

    /**
     * Store progress update.
     */
    public function storeProgress(Request $request, $id)
    {
        $request->validate([
            'deskripsi_update' => 'required|string',
            'persentase' => 'required|integer|min:0|max:100',
        ]);

        UpdateProgres::create([
            'id_program' => $id,
            'deskripsi_update' => $request->deskripsi_update,
            'persentase' => $request->persentase,
        ]);

        return redirect()->route('admin.programs.progress', $id)
            ->with('success', 'Update progres berhasil ditambahkan.');
    }
}
