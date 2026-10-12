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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->cascadeOnDelete();
            $table->foreignId('satpam_id')->constrained('users');
            $table->foreignId('perizinan_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('jenis', ['keluar', 'masuk']);
            $table->timestamp('tercatat_at')->useCurrent();
            $table->timestamps();

            $table->index(['santri_id', 'tercatat_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
