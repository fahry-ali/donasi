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
     * If user is not logged in, show choice page (guest or login).
     * If user is logged in as donatur, go directly to form.
     */
    public function create($programId)
    {
        $program = ProgramDonasi::findOrFail($programId);
        
        if (!$program->isAktif()) {
            return redirect()->route('programs.show', $programId)
                ->with('error', 'Program donasi ini sudah tidak aktif.');
        }

        // If authenticated as donatur, go directly to donation form
        if (auth()->check() && auth()->user()->isDonatur()) {
            $paymentSettings = Setting::getPaymentSettings();
            return view('donasi.create', compact('program', 'paymentSettings'));
        }

        // If authenticated but not donatur
        if (auth()->check() && !auth()->user()->isDonatur()) {
            // Allow non-donatur users to also see the choice page
            // or redirect them to guest mode
        }

        // If guest=1 query param, show donation form in guest mode
        if (request()->query('guest') == '1') {
            $paymentSettings = Setting::getPaymentSettings();
            $isGuest = true;
            return view('donasi.create', compact('program', 'paymentSettings', 'isGuest'));
        }

        // Show choice page (guest or login)
        return view('donasi.choice', compact('program'));
    }

    /**
     * Store donation.
     * Supports both authenticated donatur and guest donations.
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'id_program' => 'required|exists:program_donasi,id_program',
            'nominal' => 'required|numeric|min:10000',
            'metode_pembayaran' => 'required|in:transfer,qris',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'pesan' => 'nullable|string|max:500',
        ];

        $messages = [
            'nominal.required' => 'Nominal donasi wajib diisi.',
            'nominal.min' => 'Minimal donasi adalah Rp 10.000.',
            'bukti_transfer.required' => 'Bukti transfer wajib diupload.',
            'bukti_transfer.image' => 'File harus berupa gambar.',
            'bukti_transfer.max' => 'Ukuran file maksimal 2MB.',
        ];

        // Guest mode: require manual donor info
        $isGuest = !auth()->check() || !auth()->user()->isDonatur();
        
        if ($isGuest) {
            $rules['nama_donatur'] = 'required|string|max:100';
            $rules['email'] = 'required|email|max:100';
            $rules['no_hp'] = 'nullable|string|max:20';
            $messages['nama_donatur.required'] = 'Nama donatur wajib diisi.';
            $messages['email.required'] = 'Email wajib diisi.';
            $messages['email.email'] = 'Format email tidak valid.';
        }

        $request->validate($rules, $messages);

        // Store bukti transfer
        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        }

        // Build donation data
        if ($isGuest) {
            // Guest donation - no user linked
            $donasiData = [
                'id_program' => $request->id_program,
                'id_user' => null,
                'nama_donatur' => $request->nama_donatur,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ];
        } else {
            // Authenticated donatur
            $user = auth()->user();
            $donasiData = [
                'id_program' => $request->id_program,
                'id_user' => $user->id_user,
                'nama_donatur' => $user->nama,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
            ];
        }

        $donasiData['nominal'] = $request->nominal;
        $donasiData['metode_pembayaran'] = $request->metode_pembayaran;
        $donasiData['bukti_transfer'] = $buktiPath;
        $donasiData['pesan'] = $request->pesan;
        $donasiData['status_donasi'] = 'menunggu';

        $donasi = Donasi::create($donasiData);

        // Load program for email
        $donasi->load('program');

        // Send email notification
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
