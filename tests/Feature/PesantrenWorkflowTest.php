<?php

namespace Tests\Feature;

use App\Models\Perizinan;
use App\Models\Santri;
use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PesantrenWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_satpam_records_exit_and_return_against_an_approved_permit(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $satpam = User::factory()->create(['role' => 'satpam']);
        $santri = Santri::factory()->create();
        $perizinan = Perizinan::factory()->for($santri)->create([
            'dibuat_oleh' => $admin->id,
            'status' => 'disetujui',
            'mulai_at' => now()->subHour(),
            'kembali_sebelum' => now()->addHours(4),
        ]);

        $this->actingAs($satpam)->post(route('satpam.absensi.store'), ['qr_token' => $santri->qr_token])
            ->assertRedirect(route('satpam.dashboard'))
            ->assertSessionHas('status', 'Absensi keluar berhasil dicatat.');

        $this->assertDatabaseHas('santris', ['id' => $santri->id, 'status_keberadaan' => 'izin_keluar']);
        $this->assertDatabaseHas('absensis', ['santri_id' => $santri->id, 'jenis' => 'keluar', 'perizinan_id' => $perizinan->id]);

        $this->actingAs($satpam)->post(route('satpam.absensi.store'), ['qr_token' => $santri->qr_token])
            ->assertRedirect(route('satpam.dashboard'))
            ->assertSessionHas('status', 'Absensi masuk berhasil dicatat.');

        $this->assertDatabaseHas('santris', ['id' => $santri->id, 'status_keberadaan' => 'di_pesantren']);
        $this->assertDatabaseHas('perizinans', ['id' => $perizinan->id, 'status' => 'selesai']);
        $this->assertDatabaseCount('absensis', 2);
    }

    public function test_satpam_cannot_record_exit_without_a_current_approved_permit(): void
    {
        $satpam = User::factory()->create(['role' => 'satpam']);
        $santri = Santri::factory()->create();

        $this->actingAs($satpam)->post(route('satpam.absensi.store'), ['qr_token' => $santri->qr_token])
            ->assertSessionHasErrors('qr_token');

        $this->assertDatabaseHas('santris', ['id' => $santri->id, 'status_keberadaan' => 'di_pesantren']);
        $this->assertDatabaseCount('absensis', 0);
    }

    public function test_admin_creates_and_approves_a_permit(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $santri = Santri::factory()->create();
        $mulaiAt = now()->addHour()->format('Y-m-d\TH:i');
        $kembaliSebelum = now()->addHours(5)->format('Y-m-d\TH:i');

        $this->actingAs($admin)->post(route('admin.perizinans.store'), [
            'santri_id' => $santri->id,
            'alasan' => 'Keperluan keluarga',
            'mulai_at' => $mulaiAt,
            'kembali_sebelum' => $kembaliSebelum,
        ])->assertRedirect(route('admin.perizinans.index'));

        $perizinan = Perizinan::firstOrFail();
        $this->assertSame('menunggu', $perizinan->status);
        $this->assertSame($admin->id, $perizinan->dibuat_oleh);

        $this->actingAs($admin)->patch(route('admin.perizinans.update', $perizinan), [
            'status' => 'disetujui',
        ])->assertRedirect(route('admin.perizinans.index'));

        $this->assertDatabaseHas('perizinans', [
            'id' => $perizinan->id,
            'status' => 'disetujui',
            'disetujui_oleh' => $admin->id,
        ]);
    }

    public function test_satpam_cannot_open_admin_santri_management(): void
    {
        $satpam = User::factory()->create(['role' => 'satpam']);

        $this->actingAs($satpam)->get(route('admin.santris.index'))->assertForbidden();
    }

    public function test_guardian_only_sees_santri_linked_to_their_account(): void
    {
        $wali = User::factory()->create(['role' => 'wali_santri']);
        $waliProfile = WaliSantri::create([
            'user_id' => $wali->id,
            'alamat' => 'Jl. Pesantren',
            'no_telepon' => '081234567890',
        ]);
        $linkedSantri = Santri::factory()->create([
            'nama' => 'Santri Anak',
            'wali_santri_id' => $waliProfile->id,
        ]);
        Santri::factory()->create(['nama' => 'Santri Lain']);

        $this->actingAs($wali)->get(route('wali.dashboard'))
            ->assertOk()
            ->assertSeeText($linkedSantri->nama)
            ->assertDontSeeText('Santri Lain');
    }

    public function test_role_dashboards_render_for_their_actors(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $satpam = User::factory()->create(['role' => 'satpam']);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->assertSeeText('Dashboard Admin Pesantren');
        $this->actingAs($admin)->get(route('admin.santris.index'))->assertOk()->assertSeeText('Data Santri dan QR KTS');
        $this->actingAs($admin)->get(route('admin.perizinans.index'))->assertOk()->assertSeeText('Perizinan Santri');
        $this->actingAs($satpam)->get(route('satpam.dashboard'))->assertOk()->assertSeeText('Pindai KTS');
    }

    public function test_admin_creates_a_santri_with_a_generated_qr_token(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.santris.store'), [
            'nisn' => '1234567890',
            'nama' => 'Santri Baru',
            'kamar' => 'B-02',
            'nama_orang_tua' => 'Orang Tua',
            'nomor_darurat' => '081234567890',
        ])->assertRedirect(route('admin.santris.index'));

        $santri = Santri::where('nisn', '1234567890')->firstOrFail();
        $this->assertNotEmpty($santri->qr_token);
        $this->assertDatabaseHas('santris', [
            'id' => $santri->id,
            'status_keberadaan' => 'di_pesantren',
        ]);
    }
}
