<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\ParamsWebsite;
use App\Models\User;

class SejawatAppController extends Controller
{
    protected $model;

    protected $modelUser;

    protected $module = 'TELAAH_SEJAWAT';

    public function __construct()
    {
        $this->model = new ParamsWebsite();
        $this->modelUser = new User();
    }

    public function index()
    {
        $banner = Banner::where('kode', 'TELAAH_SEJAWAT')->first();
        $item = $this->model->getSingleData($this->module, 'DESCRIPTION');
        $linkApp = $this->model->getSingleData($this->module, 'LINK_APP');
        $jumlahUser = [
            'anggota_biasa' => $this->modelUser->countUserByRole(2),
            'anggota_luar_biasa' => $this->modelUser->countUserByRole(3),
            'anggota_kehormatan' => $this->modelUser->countUserByRole(4),
        ];

        $data = [
            'title' => 'Sejawat App',
            'item' => $item,
            'jumlah_user' => $jumlahUser,
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'link_app' => $linkApp,
        ];

        return view('pages.sejawat-app', $data);
    }
}
