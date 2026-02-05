<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontenKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontenKegiatanController extends Controller
{
    /**
     * Display list of content.
     */
    public function index()
    {
        $konten = KontenKegiatan::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.konten.index', compact('konten'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.konten.create');
    }

    /**
     * Store new content.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('kegiatan', 'public');
        }

        KontenKegiatan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
            'created_by' => auth()->user()->id_user,
        ]);

        return redirect()->route('admin.konten.index')
            ->with('success', 'Konten kegiatan berhasil ditambahkan.');
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $konten = KontenKegiatan::findOrFail($id);
        return view('admin.konten.edit', compact('konten'));
    }

    /**
     * Update content.
     */
    public function update(Request $request, $id)
    {
        $konten = KontenKegiatan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($konten->gambar) {
                Storage::disk('public')->delete($konten->gambar);
            }
            $konten->gambar = $request->file('gambar')->store('kegiatan', 'public');
        }

        $konten->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $konten->gambar,
        ]);

        return redirect()->route('admin.konten.index')
            ->with('success', 'Konten kegiatan berhasil diperbarui.');
    }

    /**
     * Delete content.
     */
    public function destroy($id)
    {
        $konten = KontenKegiatan::findOrFail($id);
        
        if ($konten->gambar) {
            Storage::disk('public')->delete($konten->gambar);
        }

        $konten->delete();

        return redirect()->route('admin.konten.index')
            ->with('success', 'Konten kegiatan berhasil dihapus.');
    }
}
