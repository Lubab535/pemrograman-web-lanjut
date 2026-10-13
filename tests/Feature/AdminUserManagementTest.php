<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Satpam;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_pengurus_and_satpam_accounts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Pengurus Baru',
            'email' => 'pengurus@example.com',
            'role' => 'pengurus',
            'password' => 'temporary-password',
            'password_confirmation' => 'temporary-password',
        ])->assertRedirect(route('admin.users.index'));

        $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Satpam Baru',
            'email' => 'satpam@example.com',
            'role' => 'satpam',
            'password' => 'temporary-password',
            'password_confirmation' => 'temporary-password',
            'nomor_induk_karyawan' => 'SAT-2026-002',
            'shift' => 'malam',
        ])->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['email' => 'pengurus@example.com', 'role' => 'pengurus']);
        $satpam = User::where('email', 'satpam@example.com')->firstOrFail();
        $this->assertDatabaseHas('satpams', [
            'user_id' => $satpam->id,
            'nomor_induk_karyawan' => 'SAT-2026-002',
            'shift' => 'malam',
        ]);
    }

    public function test_admin_cannot_create_another_admin_through_the_user_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Admin Baru',
            'email' => 'another-admin@example.com',
            'role' => 'admin',
            'password' => 'temporary-password',
            'password_confirmation' => 'temporary-password',
        ])->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', ['email' => 'another-admin@example.com']);
    }

    public function test_admin_can_update_and_delete_an_existing_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'pengurus', 'name' => 'Pengurus Lama']);

        $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => 'Pengurus Baru',
            'email' => 'pengurus-baru@example.com',
        ])->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Pengurus Baru',
            'email' => 'pengurus-baru@example.com',
            'username' => 'pengurus-baru@example.com',
        ]);

        $this->actingAs($admin)->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_their_own_account_from_user_management(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->delete(route('admin.users.destroy', $admin))
            ->assertSessionHasErrors('user');

        $this->assertModelExists($admin);
    }

    public function test_admin_cannot_delete_the_last_admin_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anotherAdmin = User::factory()->create(['role' => 'admin']);
        $anotherAdmin->delete();

        $this->actingAs($admin)->delete(route('admin.users.destroy', $admin))
            ->assertSessionHasErrors('user');

        $this->assertModelExists($admin);
    }

    public function test_admin_cannot_delete_satpam_with_attendance_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $satpam = User::factory()->create(['role' => 'satpam']);
        Satpam::create([
            'user_id' => $satpam->id,
            'nomor_induk_karyawan' => 'SAT-2026-003',
            'shift' => 'pagi',
        ]);
        Absensi::factory()->create(['satpam_id' => $satpam->id]);

        $this->actingAs($admin)->delete(route('admin.users.destroy', $satpam))
            ->assertSessionHasErrors('user');

        $this->assertModelExists($satpam);
    }

    public function test_pengurus_cannot_access_admin_user_management(): void
    {
        $pengurus = User::factory()->create(['role' => 'pengurus']);

        $this->actingAs($pengurus)->get(route('admin.users.index'))->assertForbidden();
    }
}
