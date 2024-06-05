<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RiwayatJabatan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_jabatan';

    protected $fillable = [
        'user_id',
        'nip_nrp',
        'status_nip_nrp',
        'kode_jenjang_jabatan',
        'kode_jabatan',
        'nama_jenjang_jabatan',
        'level_jenjang_jabatan',
        'nomor_sk',
        'tanggal_sk',
        'tmt_jabatan',
        'dokumen',
    ];

    protected $appends = [
        'document_url',
    ];

    public function getDokumenUrlAttribute()
    {
        return $this->dokumen ? Storage::disk('assets')->url($this->dokumen) : null;
    }
}
