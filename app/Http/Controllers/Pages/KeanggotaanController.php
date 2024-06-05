<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\SyaratPendaftaran;
use App\Models\User;
use Illuminate\Http\Request;

class KeanggotaanController extends Controller
{
    protected $model;

    protected $modelBanner;

    protected $modelUser;

    public function __construct()
    {
        $this->model = new User();
        $this->modelBanner = new Banner();
        $this->modelUser = new User();
        $this->modelSyaratPendaftaran = new SyaratPendaftaran();
    }

    public function index(Request $request)
    {
        $query = $this->model
            ->where('status', 'active')
            ->whereNotIn('role_id', [1])
            ->with(['role'])
            ->paginate(8)->withQueryString();

        $banner = $this->modelBanner->where('kode', 'KEANGGOTAAN')->first();
        $jumlahUser = [
            'anggota_biasa' => $this->modelUser->countUserByRole(2),
            'anggota_luar_biasa' => $this->modelUser->countUserByRole(3),
            'anggota_kehormatan' => $this->modelUser->countUserByRole(4),
        ];

        $data = [
            'title' => 'Keanggotaan',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'data' => $query,
            'jumlah_user' => $jumlahUser,
            'persyaratan' => $this->modelSyaratPendaftaran->getAll(),
        ];

        return view('pages.keanggotaan', $data);
    }
}
