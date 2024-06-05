<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPangkat extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pangkat';

    protected $fillable = [
        'user_id',
        'jabatan_id',
        'nama_pangkat',
    ];

    public function jabatan()
    {
        return $this->hasOne(RiwayatJabatan::class, 'id', 'jabatan_id');
    }
}
