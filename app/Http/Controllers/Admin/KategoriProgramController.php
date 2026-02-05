<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProgram;
use Illuminate\Http\Request;

class KategoriProgramController extends Controller
{
    /**
     * Display list of categories.
     */
    public function index()
    {
        $kategori = KategoriProgram::withCount('programs')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Store new category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_program,nama_kategori',
        ]);

        KategoriProgram::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update category.
     */
    public function update(Request $request, $id)
    {
        $kategori = KategoriProgram::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_program,nama_kategori,' . $id . ',id_kategori',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Delete category.
     */
    public function destroy($id)
    {
        $kategori = KategoriProgram::findOrFail($id);
        
        if ($kategori->programs()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki program.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
