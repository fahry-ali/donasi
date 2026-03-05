<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display donatur dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Get donatur's recent donations
        $recentDonasi = Donasi::with('program')
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get donatur stats
        $totalDonasi = Donasi::where('id_user', $user->id_user)->count();
        $totalNominal = Donasi::where('id_user', $user->id_user)
            ->where('status_donasi', 'diterima')
            ->sum('nominal');
        $donasiPending = Donasi::where('id_user', $user->id_user)
            ->where('status_donasi', 'menunggu')
            ->count();
        $donasiDiterima = Donasi::where('id_user', $user->id_user)
            ->where('status_donasi', 'diterima')
            ->count();

        return view('donatur.dashboard', compact(
            'recentDonasi',
            'totalDonasi',
            'totalNominal',
            'donasiPending',
            'donasiDiterima'
        ));
    }
}
