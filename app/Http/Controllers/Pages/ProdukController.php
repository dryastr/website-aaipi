<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\ParamsWebsite;


class ProdukController extends Controller
{
    // protected $dirView;
    protected $model;

    protected $modelParams;

    protected $modelBanner;

    public function __construct()
    {
        // $this->dirView = 'dashboard.kontak.';
        $this->modelParams = new ParamsWebsite();
        $this->modelBanner = new Banner();
        $this->model = new ParamsWebsite();
    }

    public function komiteStandar()
    {
        $banner = $this->modelBanner->where('kode', 'SEJARAH_SINGKAT')->first();
        $item = $this->modelParams->getSingleData('TENTANG_KAMI', 'SEJARAH_SINGKAT');

        $data = [
            'title' => 'Sejarah Singkat',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
        ];

        return view('pages.produk.komite-standar', $data);
    }

    public function komiteTelaah()
    {

        $banner = $this->modelBanner->where('kode', 'VISI_DAN_MISI')->first();
        $item = $this->modelParams->getSingleData('TENTANG_KAMI', 'VISI_MISI');

        $data = [
            'title' => 'Visi dan Misi',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
        ];

        return view('pages.produk.komite-telaah-sejawat', $data);
    }

    public function komiteKodeEtik()
    {
        $proker = $this->model->all();
        $banner = $this->modelBanner->where('kode', 'PROGRAM_KERJA')->first();
        $item = $this->modelParams->getSingleData('PROGRAM_KERJA', 'DATA_PROGRAM');

        $data = [
            'title' => 'Program Kerja',
            'proker' => $proker,
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
        ];

        return view('pages.produk.komite-kode-etik', $data);
    }

    public function komiteProfesi()
    {
        $banner = $this->modelBanner->where('kode', 'STRUKTUR_ORGANISASI')->first();
        $item = $this->modelParams->getSingleData('TENTANG_KAMI', 'STRUKTUR_ORGANISASI');

        $data = [
            'title' => 'Struktur Organisasi',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
        ];

        return view('pages.produk.komite-pengembangan-profesi', $data);
    }

}
