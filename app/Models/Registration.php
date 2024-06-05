<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'user_id',
        'no_telp',
        'nama_instansi',
        'jabatan',
        'alamat',
        'status_approval',
        'set_daftar_ulang',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
