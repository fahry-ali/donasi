<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    /**
     * Display list of donations.
     */
    public function index(Request $request)
    {
        $query = Donasi::with('program');

        if ($request->filled('status')) {
            $query->where('status_donasi', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_donatur', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_transaksi', 'like', '%' . $request->search . '%');
            });
        }

        $donasi = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.donasi.index', compact('donasi'));
    }

    /**
     * Show donation detail.
     */
    public function show($id)
    {
        $donasi = Donasi::with('program')->findOrFail($id);
        return view('admin.donasi.show', compact('donasi'));
    }

    /**
     * Approve donation.
     */
    public function approve($id)
    {
        $donasi = Donasi::findOrFail($id);
        
        if ($donasi->status_donasi !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Donasi ini sudah diproses sebelumnya.');
        }

        $donasi->update(['status_donasi' => 'diterima']);

        // Update dana terkumpul
        $program = ProgramDonasi::find($donasi->id_program);
        $program->increment('dana_terkumpul', $donasi->nominal);

        // Check if target reached
        if ($program->dana_terkumpul >= $program->target_dana) {
            $program->update(['status_program' => 'selesai']);
        }

        return redirect()->route('admin.donasi.index')
            ->with('success', 'Donasi berhasil dikonfirmasi. Dana terkumpul telah diperbarui.');
    }

    /**
     * Reject donation.
     */
    public function reject($id)
    {
        $donasi = Donasi::findOrFail($id);
        
        if ($donasi->status_donasi !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Donasi ini sudah diproses sebelumnya.');
        }

        $donasi->update(['status_donasi' => 'ditolak']);

        return redirect()->route('admin.donasi.index')
            ->with('success', 'Donasi telah ditolak.');
    }
}
