<?php

namespace App\Models;

use Database\Factories\PerizinanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perizinan extends Model
{
    /** @use HasFactory<PerizinanFactory> */
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'dibuat_oleh',
        'disetujui_oleh',
        'alasan',
        'mulai_at',
        'kembali_sebelum',
        'status',
        'catatan_penolakan',
        'kembali_at',
    ];

    protected function casts(): array
    {
        return [
            'mulai_at' => 'datetime',
            'kembali_sebelum' => 'datetime',
            'kembali_at' => 'datetime',
        ];
    }

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
