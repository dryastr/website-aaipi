<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendidikan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pendidikan';

    protected $fillable = [
        'user_id',
        'gelar_depan',
        'gelar_belakang',
        'nomor_ijazah',
        'tanggal_ijazah',
        'dokumen',
        'strata',
        'perguruan_tinggi',
        'program_studi',
    ];
}
