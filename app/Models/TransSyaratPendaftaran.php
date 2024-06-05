<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransSyaratPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'trans_syarat_pendaftaran';

    protected $fillable = [
        'user_id',
        'ref_id',
        'value',
    ];
}
