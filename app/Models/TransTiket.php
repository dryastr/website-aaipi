<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransTiket extends Model
{
    use HasFactory;

    protected $table = 'trans_tiket';

    protected $fillable = [
        'judul', 'deskripsi', 'ref_tiket_jenis_id', 'prioritas', 'attachment', 'user_id',
    ];

    public function jenisTiket()
    {
        return $this->belongsTo(RefTiketJenis::class, 'ref_tiket_jenis_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
