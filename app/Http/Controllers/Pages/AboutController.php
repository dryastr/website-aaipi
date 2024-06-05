<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\AnggaranDasar;
use App\Models\Banner;
use App\Models\ParamsWebsite;
use App\Models\ProgramKerja;

class AboutController extends Controller
{
    // protected $dirView;
    protected $model;

    protected $modelParams;

    protected $modelBanner;

    public function __construct()
    {
        // $this->dirView = 'dashboard.kontak.';
        $this->model = new ProgramKerja();
        $this->modelParams = new ParamsWebsite();
        $this->modelBanner = new Banner();
    }

    public function history()
    {
        $banner = $this->modelBanner->where('kode', 'SEJARAH_SINGKAT')->first();
        $item = $this->modelParams->getSingleData('TENTANG_KAMI', 'SEJARAH_SINGKAT');

        $data = [
            'title' => 'Sejarah Singkat',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
        ];

        return view('pages.about.history', $data);
    }

    public function visiDanMisi()
    {

        $banner = $this->modelBanner->where('kode', 'VISI_DAN_MISI')->first();
        $item = $this->modelParams->getSingleData('TENTANG_KAMI', 'VISI_MISI');

        $data = [
            'title' => 'Visi dan Misi',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
        ];

        return view('pages.about.visi-dan-misi', $data);
    }

    public function programKerja()
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

        return view('pages.about.program-kerja', $data);
    }

    public function strukturOrganisasi()
    {
        $banner = $this->modelBanner->where('kode', 'STRUKTUR_ORGANISASI')->first();
        $item = $this->modelParams->getSingleData('TENTANG_KAMI', 'STRUKTUR_ORGANISASI');

        $data = [
            'title' => 'Struktur Organisasi',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
        ];

        return view('pages.about.struktur-organisasi', $data);
    }

    public function anggarandasar()
    {
        $banner = $this->modelBanner->where('kode', 'ANGGARAN_DASAR')->first();
        $item = $this->modelParams->getSingleData('TENTANG_KAMI', 'ANGGARAN_DASAR');
        $fileAnggaran = AnggaranDasar::orderBy('created_at', 'DESC')->get();

        $data = [
            'title' => 'Anggaran Dasar',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
            'file_anggaran' => $fileAnggaran,
        ];

        return view('pages.about.anggaran-dasar', $data);
    }
}
