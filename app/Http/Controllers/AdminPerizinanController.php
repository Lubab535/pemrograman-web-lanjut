<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\Santri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPerizinanController extends Controller
{
    public function index(): View
    {
        return view('pengurus.perizinans.index', [
            'perizinans' => Perizinan::with(['santri', 'pembuat', 'penyetuju'])->latest()->get(),
            'santris' => Santri::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'santri_id' => ['required', 'integer', 'exists:santris,id'],
            'alasan' => ['required', 'string', 'max:2000'],
            'mulai_at' => ['required', 'date_format:Y-m-d\TH:i'],
            'kembali_sebelum' => ['required', 'date_format:Y-m-d\TH:i', 'after:mulai_at'],
        ]);

        $request->user()->perizinansDibuat()->create($data + ['status' => 'menunggu']);

        return redirect()->route('pengurus.perizinans.index')->with('status', 'Permintaan izin berhasil dicatat.');
    }

    public function update(Request $request, Perizinan $perizinan): RedirectResponse
    {
        abort_if(
            $perizinan->status === 'selesai' || $perizinan->santri->status_keberadaan === 'izin_keluar',
            409,
            'Perizinan tidak dapat diubah setelah santri melakukan scan keluar.',
        );

        $data = $request->validate([
            'status' => ['required', 'in:menunggu,disetujui,ditolak'],
            'catatan_penolakan' => ['nullable', 'string', 'max:2000'],
        ]);

        $perizinan->update([
            'status' => $data['status'],
            'disetujui_oleh' => $data['status'] === 'disetujui' ? $request->user()->id : null,
            'catatan_penolakan' => $data['status'] === 'ditolak' ? ($data['catatan_penolakan'] ?? null) : null,
        ]);

        return redirect()->route('pengurus.perizinans.index')->with('status', 'Status izin berhasil diperbarui.');
    }
}
