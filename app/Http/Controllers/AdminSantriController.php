<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminSantriController extends Controller
{
    public function index(): View
    {
        return $this->listing();
    }

    public function create(): View
    {
        return $this->listing();
    }

    public function store(Request $request): RedirectResponse
    {
        Santri::create($this->validatedData($request));

        return redirect()->route('pengurus.santris.index')->with('status', 'Data santri berhasil ditambahkan.');
    }

    public function edit(Santri $santri): View
    {
        return $this->listing($santri);
    }

    public function update(Request $request, Santri $santri): RedirectResponse
    {
        $santri->update($this->validatedData($request, $santri));

        return redirect()->route('pengurus.santris.index')->with('status', 'Data santri berhasil diperbarui.');
    }

    public function destroy(Santri $santri): RedirectResponse
    {
        if ($santri->absensis()->exists() || $santri->perizinans()->exists()) {
            return redirect()->route('pengurus.santris.index')->withErrors([
                'santri' => 'Data santri tidak dapat dihapus karena sudah memiliki riwayat izin atau absensi.',
            ]);
        }

        $santri->delete();

        return redirect()->route('pengurus.santris.index')->with('status', 'Data santri berhasil dihapus.');
    }

    private function listing(?Santri $santriToEdit = null): View
    {
        return view('pengurus.santris.index', [
            'santris' => Santri::with('waliSantri.user')->latest()->get(),
            'waliSantris' => WaliSantri::with('user')->orderBy('id')->get(),
            'santriToEdit' => $santriToEdit,
        ]);
    }

    private function validatedData(Request $request, ?Santri $santri = null): array
    {
        return $request->validate([
            'nisn' => ['required', 'string', 'max:255', Rule::unique('santris', 'nisn')->ignore($santri)],
            'nama' => ['required', 'string', 'max:255'],
            'kamar' => ['required', 'string', 'max:100'],
            'nama_orang_tua' => ['required', 'string', 'max:255'],
            'nomor_darurat' => ['required', 'string', 'max:30'],
            'wali_santri_id' => ['nullable', 'integer', 'exists:wali_santris,id'],
        ]);
    }
}
