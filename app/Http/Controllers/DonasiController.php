<?php

namespace App\Http\Controllers;

use App\Mail\DonasiNotification;
use App\Models\Donasi;
use App\Models\ProgramDonasi;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    /**
     * Show donation form.
     */
    public function create($programId)
    {
        $program = ProgramDonasi::findOrFail($programId);
        
        if (!$program->isAktif()) {
            return redirect()->route('programs.show', $programId)
                ->with('error', 'Program donasi ini sudah tidak aktif.');
        }

        $paymentSettings = Setting::getPaymentSettings();

        return view('donasi.create', compact('program', 'paymentSettings'));
    }

    /**
     * Store donation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_program' => 'required|exists:program_donasi,id_program',
            'nama_donatur' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'no_hp' => 'nullable|string|max:20',
            'nominal' => 'required|numeric|min:10000',
            'metode_pembayaran' => 'required|in:transfer,qris',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'pesan' => 'nullable|string|max:500',
        ], [
            'nama_donatur.required' => 'Nama donatur wajib diisi.',
            'nominal.required' => 'Nominal donasi wajib diisi.',
            'nominal.min' => 'Minimal donasi adalah Rp 10.000.',
            'bukti_transfer.required' => 'Bukti transfer wajib diupload.',
            'bukti_transfer.image' => 'File harus berupa gambar.',
            'bukti_transfer.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // Store bukti transfer
        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        }

        // Create donation
        $donasi = Donasi::create([
            'id_program' => $request->id_program,
            'nama_donatur' => $request->nama_donatur,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'nominal' => $request->nominal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_transfer' => $buktiPath,
            'pesan' => $request->pesan,
            'status_donasi' => 'menunggu',
        ]);

        // Load program for email
        $donasi->load('program');

        // Send email notification if email provided
        if ($donasi->email) {
            try {
                Mail::to($donasi->email)->send(new DonasiNotification($donasi));
            } catch (\Exception $e) {
                \Log::error('Email Error: ' . $e->getMessage());
            }
        }

        return redirect()->route('donasi.success', $donasi->kode_transaksi);
    }

    /**
     * Show success page.
     */
    public function success($kodeTransaksi)
    {
        $donasi = Donasi::with('program')
            ->where('kode_transaksi', $kodeTransaksi)
            ->firstOrFail();

        return view('donasi.success', compact('donasi'));
    }

    /**
     * Track donation by code.
     */
    public function track(Request $request)
    {
        $kode = $request->kode;
        $donasi = null;

        if ($kode) {
            $donasi = Donasi::with('program')
                ->where('kode_transaksi', $kode)
                ->first();
        }

        return view('donasi.track', compact('donasi', 'kode'));
    }
}
