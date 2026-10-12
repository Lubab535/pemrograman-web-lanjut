<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WaliSantri extends Model
{
    protected $table = 'wali_santris';

    protected $fillable = [
        'user_id',
        'alamat',
        'no_telepon',
    ];

    // Relasi ke tabel users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function santris(): HasMany
    {
        return $this->hasMany(Santri::class);
    }
}
