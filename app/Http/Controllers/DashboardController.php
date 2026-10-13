<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Perizinan;
use App\Models\Santri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        return match ($request->user()->role) {
            'admin' => redirect()->route('admin.users.index'),
            'pengurus' => redirect()->route('pengurus.dashboard'),
            'satpam' => redirect()->route('satpam.dashboard'),
            'wali_santri' => redirect()->route('wali.dashboard'),
            default => abort(403),
        };
    }

    public function pengurus(): View
    {
        return view('pengurus.dashboard', [
            'jumlahSantri' => Santri::count(),
            'izinMenunggu' => Perizinan::where('status', 'menunggu')->count(),
            'sedangKeluar' => Santri::where('status_keberadaan', 'izin_keluar')->count(),
            'absensiTerbaru' => Absensi::with(['santri', 'satpam'])->latest('tercatat_at')->limit(8)->get(),
        ]);
    }

    public function wali(Request $request): View
    {
        $santris = $request->user()->waliSantri?->santris()
            ->with([
                'absensis' => fn ($query) => $query->with('satpam')->latest('tercatat_at')->limit(10),
                'perizinans' => fn ($query) => $query->latest(),
            ])
            ->get() ?? collect();

        return view('wali.wali-dashboard', compact('santris'));
    }
}
