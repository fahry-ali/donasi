<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramDonasi;
use App\Models\Donasi;
use App\Models\UsulanProgram;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        // Statistics
        $totalDonasi = Donasi::diterima()->sum('nominal');
        $donasiPending = Donasi::menunggu()->count();
        $usulanPending = UsulanProgram::menunggu()->count();
        $programAktif = ProgramDonasi::aktif()->count();
        $totalUser = User::where('role', 'masyarakat')->count();

        // Recent pending donations
        $recentDonasi = Donasi::with('program')
            ->menunggu()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent pending proposals
        $recentUsulan = UsulanProgram::with('user')
            ->menunggu()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Monthly donation stats for chart
        $monthlyDonasi = Donasi::diterima()
            ->selectRaw('MONTH(created_at) as month, SUM(nominal) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalDonasi',
            'donasiPending',
            'usulanPending',
            'programAktif',
            'totalUser',
            'recentDonasi',
            'recentUsulan',
            'monthlyDonasi'
        ));
    }
}
