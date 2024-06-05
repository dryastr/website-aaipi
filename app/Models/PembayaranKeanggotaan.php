<?php

namespace App\Models;

use App\Traits\ModelBootObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranKeanggotaan extends Model
{
    use HasFactory;
    use ModelBootObserver;

    protected $table = 'trans_pembayaran_keanggotaan';

    protected $fillable = [
        'user_id',
        'tagihan_id',
        'tagihan',
        'nominal_bayar',
        'status',
        'catatan',
        'alasan',
        'tanggal_bayar',
        'tanggal_expired',
        'approval_at',
        'approval_by',
        'approval_by_name',
        'rejected_at',
        'rejected_by',
        'rejected_by_name',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $appends = [
        'pid',
        'tagihan_rupiah',
        'nominal_bayar_rupiah',
        'status_description',
        'status_active',
    ];

    public function getPidAttribute()
    {
        return security()->encrypt($this->id);
    }

    public function getTagihanRupiahAttribute()
    {
        return 'Rp. '.number_format($this->tagihan, 2);
    }

    public function getNominalBayarRupiahAttribute()
    {
        return 'Rp. '.number_format($this->nominal_bayar, 2);
    }

    public function getStatusDescriptionAttribute()
    {
        if ($this->status == 'verifikasi-pembayaran') {
            return 'Verifikasi Pembayaran';
        } elseif ($this->status == 'terverifikasi') {
            return 'Terverifikasi';
        } elseif ($this->status == 'ditolak') {
            return 'Ditolak';
        } else {
            return '-';
        }
    }

    public function getStatusActiveAttribute()
    {
        $today = Carbon::now();
        if ($this->tanggal_expired) {
            $tanggal_expired = new Carbon($this->tanggal_expired);
            $selisih = $today->startOfDay()->diffInDays($tanggal_expired->startOfDay(), false);

            return [
                'status' => $selisih > 0,
                'selisih' => $selisih,
            ];
        } else {
            return null;
        }
    }

    public function refTagihan()
    {
        return $this->belongsTo(BiayaKeanggotaan::class, 'tagihan_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'table_id', 'id')->where('parent_table', 'trans_pembayaran_keanggotaan');
    }
}
