<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SatpamAbsensiController extends Controller
{
    public function index(): View
    {
        return view('satpam.satpam-dashboard', [
            'absensiTerbaru' => Absensi::with('santri')->latest('tercatat_at')->limit(12)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'qr_token' => ['required', 'uuid', 'exists:santris,qr_token'],
        ], [
            'qr_token.exists' => 'QR santri tidak ditemukan. Periksa kembali KTS.',
        ]);

        $aksi = DB::transaction(function () use ($request, $data): string {
            $santri = Santri::where('qr_token', $data['qr_token'])->lockForUpdate()->firstOrFail();

            if ($santri->status_keberadaan === 'di_pesantren') {
                $perizinan = $santri->perizinans()
                    ->where('status', 'disetujui')
                    ->where('mulai_at', '<=', now())
                    ->where('kembali_sebelum', '>=', now())
                    ->lockForUpdate()
                    ->latest('mulai_at')
                    ->first();

                if (! $perizinan) {
                    throw ValidationException::withMessages([
                        'qr_token' => 'Santri belum memiliki izin keluar yang disetujui dan masih berlaku.',
                    ]);
                }

                $santri->update(['status_keberadaan' => 'izin_keluar']);
                Absensi::create([
                    'santri_id' => $santri->id,
                    'satpam_id' => $request->user()->id,
                    'perizinan_id' => $perizinan->id,
                    'jenis' => 'keluar',
                    'tercatat_at' => now(),
                ]);

                return 'keluar';
            }

            $absensiKeluar = $santri->absensis()
                ->where('jenis', 'keluar')
                ->whereNotNull('perizinan_id')
                ->latest('tercatat_at')
                ->lockForUpdate()
                ->first();
            $perizinan = $absensiKeluar?->perizinan;

            $santri->update(['status_keberadaan' => 'di_pesantren']);

            if ($perizinan) {
                $perizinan->update([
                    'status' => 'selesai',
                    'kembali_at' => now(),
                ]);
            }

            Absensi::create([
                'santri_id' => $santri->id,
                'satpam_id' => $request->user()->id,
                'perizinan_id' => $perizinan?->id,
                'jenis' => 'masuk',
                'tercatat_at' => now(),
            ]);

            return 'masuk';
        });

        return redirect()->route('satpam.dashboard')->with(
            'status',
            $aksi === 'keluar' ? 'Absensi keluar berhasil dicatat.' : 'Absensi masuk berhasil dicatat.',
        );
    }
}
