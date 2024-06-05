<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KotaKab extends Model
{
    use HasFactory;

    protected $table = 'ref_kota_kab';

    protected $fillable = [
        'ref_provinsi_id',
        'kode',
        'nama',
        'is_active',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'ref_provinsi_id', 'id');
    }
}
