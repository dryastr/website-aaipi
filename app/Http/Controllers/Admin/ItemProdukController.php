<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FungsiUnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Banner;
use App\Models\ParamsWebsite;

class ItemProdukController extends Controller
{

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

    public function index(){
        $data = FungsiUnitKerja::all();
        $currentRoute = Route::current()->getName();
        $banner = $this->modelBanner->where('kode', 'PRODUK')->first();
        $item = $this->modelParams->getSingleData('TENTANG_KAMI', 'PRODUK');

        $dataBreadCrumbs = [
            'title' => 'Produk',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
        ];
        // return view('pages.produk.komite-standar', $data);
        return view('pages.produk.item', compact('data', 'currentRoute'), $dataBreadCrumbs);
        // return $data;
    }
}
