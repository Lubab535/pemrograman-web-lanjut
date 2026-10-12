<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->foreignId('wali_santri_id')->nullable()->after('id')->constrained('wali_santris')->nullOnDelete();
            $table->uuid('qr_token')->nullable()->unique()->after('nomor_darurat');
        });

        DB::table('santris')->whereNull('qr_token')->orderBy('id')->each(function (object $santri): void {
            DB::table('santris')->where('id', $santri->id)->update(['qr_token' => (string) Str::uuid()]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->dropForeign(['wali_santri_id']);
            $table->dropUnique(['qr_token']);
            $table->dropColumn(['wali_santri_id', 'qr_token']);
        });
    }
};
