<?php

namespace App\Models;

use Database\Factories\AbsensiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    /** @use HasFactory<AbsensiFactory> */
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'satpam_id',
        'perizinan_id',
        'jenis',
        'tercatat_at',
    ];

    protected function casts(): array
    {
        return ['tercatat_at' => 'datetime'];
    }

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function satpam(): BelongsTo
    {
        return $this->belongsTo(User::class, 'satpam_id');
    }

    public function perizinan(): BelongsTo
    {
        return $this->belongsTo(Perizinan::class);
    }
}
