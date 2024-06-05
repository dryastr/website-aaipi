<?php

namespace App\Models;

use App\Traits\ModelBootObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaKeanggotaan extends Model
{
    use HasFactory;
    use ModelBootObserver;

    protected $table = 'ref_biaya_keanggotaan';

    protected $fillable = [
        'biaya',
        'tahun',
        'status',
        'jenis_keanggotaan',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $appends = [
        'biaya_rupiah',
    ];

    public function getBiayaRupiahAttribute()
    {
        return 'Rp. '.number_format($this->biaya, 2);
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranKeanggotaan::class, 'tagihan_id', 'id');
    }

    public function biayaAktif()
    {
        $query = $this->select('*')
            ->where('tahun', date('Y'))
            ->where('status', 'active')
            ->first();

        return $query;
    }
}
