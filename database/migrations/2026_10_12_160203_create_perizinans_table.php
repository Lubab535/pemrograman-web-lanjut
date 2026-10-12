<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perizinans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->text('alasan');
            $table->timestamp('mulai_at');
            $table->timestamp('kembali_sebelum');
            $table->string('status')->default('menunggu');
            $table->text('catatan_penolakan')->nullable();
            $table->timestamp('kembali_at')->nullable();
            $table->timestamps();

            $table->index(['santri_id', 'status', 'mulai_at', 'kembali_sebelum']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinans');
    }
};
