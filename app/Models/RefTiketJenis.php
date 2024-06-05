<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefTiketJenis extends Model
{
    use HasFactory;

    protected $table = 'ref_tiket_jenis';

    protected $fillable = [
        'nama', 'prioritas',
    ];

    public function tikets()
    {
        return $this->hasMany(TransTiket::class, 'ref_tiket_jenis_id');
    }
}
