<?php

namespace App\Models;

use Database\Factories\SantriFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Santri extends Model
{
    /** @use HasFactory<SantriFactory> */
    use HasFactory;

    protected $fillable = [
        'nisn',
        'nama',
        'kamar',
        'nama_orang_tua',
        'nomor_darurat',
        'wali_santri_id',
        'status_keberadaan',
    ];

    protected static function booted(): void
    {
        static::creating(function (Santri $santri): void {
            $santri->qr_token ??= (string) Str::uuid();
        });
    }

    public function waliSantri(): BelongsTo
    {
        return $this->belongsTo(WaliSantri::class);
    }

    public function perizinans(): HasMany
    {
        return $this->hasMany(Perizinan::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
