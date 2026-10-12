<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliSantri extends Model
{
    protected $table = 'wali_santris';

    protected $fillable = [
        'user_id',
        'alamat',
        'nomor_telepon',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
