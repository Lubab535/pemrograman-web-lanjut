<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satpam extends Model
{
    protected $table = 'satpams';

    protected $fillable = [
        'user_id',
        'nomor_induk_karyawan',
        'shift',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
