<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pekerjaan';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jabatan',
        'deskripsi',
    ];
}
