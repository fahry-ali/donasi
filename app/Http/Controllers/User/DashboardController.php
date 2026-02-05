<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\UsulanProgram;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display user dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Get user's recent proposals
        $recentUsulan = UsulanProgram::where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get user stats
        $totalUsulan = UsulanProgram::where('id_user', $user->id_user)->count();
        $usulanDiterima = UsulanProgram::where('id_user', $user->id_user)
            ->where('status_usulan', 'diterima')
            ->count();
        $usulanPending = UsulanProgram::where('id_user', $user->id_user)
            ->where('status_usulan', 'menunggu')
            ->count();
        $usulanDitolak = UsulanProgram::where('id_user', $user->id_user)
            ->where('status_usulan', 'ditolak')
            ->count();

        return view('user.dashboard', compact(
            'recentUsulan',
            'totalUsulan',
            'usulanDiterima',
            'usulanPending',
            'usulanDitolak'
        ));
    }
}
