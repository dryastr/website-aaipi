<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BiayaKeanggotaan;
use App\Models\PembayaranKeanggotaan;
use Illuminate\Support\Facades\Cookie;

class AppController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();

    }

    public function index()
    {

        $userMember = auth()->user()->getMe();
        // Ambil informasi biaya keanggotaan yang aktif
        $biayaKeanggotaanAktif = BiayaKeanggotaan::where('tahun', date('Y'))
        ->where('status', 'active')
        ->where('jenis_keanggotaan', $userMember['role']['id'] == 2 ? 'anggota-biasa' : 'anggota-luar-biasa')
        ->first();

        $pembayaran = PembayaranKeanggotaan::where('user_id', $userMember['id'])
            ->get();

        // Ambil informasi tagihan keanggotaan user untuk tahun ini
        $tagihanBelumDibayar = $biayaKeanggotaanAktif ? $this->getTagihanBelumDibayar($userMember['id'], $biayaKeanggotaanAktif->id) : [];



        $token = Cookie::get('app_token');
        $renewal=$this->getRenewal();
        $data = [
            'title' => 'App',
            'user' => auth()->user()->getMe(),
            'app_token' => $token,
            'renewal' => $renewal,
            'tagihans' => $tagihanBelumDibayar,
        ];

        return view('member.pages.app.index', $data);
    }


    private function getTagihanBelumDibayar($userId, $biayaKeanggotaanId)
    {
        // Ambil informasi tagihan yang belum dibayar
        $tagihanBelumDibayar = BiayaKeanggotaan::where('id', $biayaKeanggotaanId)
            ->whereDoesntHave('pembayaran', function ($query) use ($userId) {
                $query->where('user_id', $userId)->whereNotIn('status', ['ditolak']);
            })
            ->get();

        return $tagihanBelumDibayar;
    }



    private function getRenewal()
    {
        try {
            // Dapatkan informasi pengguna yang terautentikasi
            $user = auth()->user()->getMe();

            // Pastikan $user tidak null dan memiliki indeks 'role'
            if ($user && isset($user['role'])) {
                // Pastikan indeks 'role' memiliki nilai dan memiliki indeks 'id'
                $jenis_keanggotaan = $user['role']['id'] == 2 ? 'anggota-biasa' : 'anggota-luar-biasa';

                // Ambil informasi biaya keanggotaan yang aktif
                $biayaKeanggotaanAktif = BiayaKeanggotaan::where('tahun', date('Y'))
                    ->where('status', 'active')
                    ->where('jenis_keanggotaan', $jenis_keanggotaan)
                    ->first();

                // Pastikan biaya keanggotaan aktif tidak null
                if ($biayaKeanggotaanAktif) {
                    // Dapatkan tagihan yang belum dibayar
                    $tagihanBelumDibayar = $this->getTagihanBelumDibayar($user['id'], $biayaKeanggotaanAktif->id);

                    $renewal = 0;

                    // Periksa apakah pengguna memiliki tagihan yang belum dibayar
                    if (count($tagihanBelumDibayar) > 0) {
                        // Dapatkan pembayaran terakhir
                        $getLastPaid = PembayaranKeanggotaan::where('user_id', $user->id)
                            ->orderBy('id', 'desc')
                            ->first();

                        // Hitung periode perpanjangan jika pembayaran terakhir ada
                        if ($getLastPaid) {
                            $renewal = now()->diffInDays($getLastPaid->tanggal_expired);
                        }
                    }

                    return $renewal;
                } else {
                    // Handle jika tidak ada biaya keanggotaan aktif
                    throw new \Exception('Tidak ada biaya keanggotaan aktif');
                }
            } else {
                // Handle jika $user null atau tidak memiliki indeks 'role'
                throw new \Exception('Pengguna tidak terautentikasi atau tidak memiliki peran');
            }
        } catch (\Exception $e) {
            // Tangani error dan kembalikan nilai default atau lempar kembali error
            return 0; // Nilai default untuk periode perpanjangan
        }
    }
}
