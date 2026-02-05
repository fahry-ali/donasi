<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsulanProgram;
use App\Models\ProgramDonasi;
use App\Models\KategoriProgram;
use Illuminate\Http\Request;

class UsulanProgramController extends Controller
{
    /**
     * Display list of proposals.
     */
    public function index(Request $request)
    {
        $query = UsulanProgram::with('user');

        if ($request->filled('status')) {
            $query->where('status_usulan', $request->status);
        }

        $usulan = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.usulan.index', compact('usulan'));
    }

    /**
     * Show proposal detail.
     */
    public function show($id)
    {
        $usulan = UsulanProgram::with('user')->findOrFail($id);
        $kategori = KategoriProgram::all();
        return view('admin.usulan.show', compact('usulan', 'kategori'));
    }

    /**
     * Approve proposal.
     */
    public function approve(Request $request, $id)
    {
        $usulan = UsulanProgram::findOrFail($id);
        
        if ($usulan->status_usulan !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Usulan ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string',
        ]);

        $usulan->update([
            'status_usulan' => 'diterima',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.usulan.index')
            ->with('success', 'Usulan program berhasil diterima.');
    }

    /**
     * Reject proposal.
     */
    public function reject(Request $request, $id)
    {
        $usulan = UsulanProgram::findOrFail($id);
        
        if ($usulan->status_usulan !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Usulan ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'catatan_admin' => 'required|string',
        ], [
            'catatan_admin.required' => 'Catatan alasan penolakan wajib diisi.',
        ]);

        $usulan->update([
            'status_usulan' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.usulan.index')
            ->with('success', 'Usulan program telah ditolak.');
    }

    /**
     * Convert proposal to donation program.
     */
    public function convertToProgram(Request $request, $id)
    {
        $usulan = UsulanProgram::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:kategori_program,id_kategori',
            'target_dana' => 'required|numeric|min:100000',
        ]);

        // Create new program from proposal
        ProgramDonasi::create([
            'id_kategori' => $request->id_kategori,
            'judul_program' => $usulan->judul_usulan,
            'deskripsi' => $usulan->deskripsi . "\n\nLokasi: " . $usulan->lokasi,
            'target_dana' => $request->target_dana,
            'sumber_program' => 'masyarakat',
            'gambar' => $usulan->foto_pendukung,
            'created_by' => auth()->user()->id_user,
        ]);

        // Update proposal status
        $usulan->update([
            'status_usulan' => 'diterima',
            'catatan_admin' => 'Usulan telah dikonversi menjadi program donasi.',
        ]);

        return redirect()->route('admin.usulan.index')
            ->with('success', 'Usulan berhasil dikonversi menjadi program donasi.');
    }
}
