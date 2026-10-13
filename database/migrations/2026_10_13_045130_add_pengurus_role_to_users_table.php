<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'pengurus', 'satpam', 'wali_santri') NOT NULL");

            return;
        }

        Schema::table('users', function (Blueprint $table): void {
            $table->enum('role', ['admin', 'pengurus', 'satpam', 'wali_santri'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('users')->where('role', 'pengurus')->exists()) {
            throw new RuntimeException('Pengurus accounts must be removed or reassigned before rolling back this migration.');
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'satpam', 'wali_santri') NOT NULL");

            return;
        }

        Schema::table('users', function (Blueprint $table): void {
            $table->enum('role', ['admin', 'satpam', 'wali_santri'])->change();
        });
    }
};
