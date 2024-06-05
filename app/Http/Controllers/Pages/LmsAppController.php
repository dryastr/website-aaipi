<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\ParamsWebsite;

class LmsAppController extends Controller
{
    protected $model;

    protected $module = 'ELMS_AAIPI';

    public function __construct()
    {
        $this->model = new ParamsWebsite();
    }

    public function show()
    {
        $banner = Banner::where('kode', 'ELMS_AAIPI')->first();
        $item = $this->model->getSingleData($this->module, 'DESCRIPTION');
        $linkApp = $this->model->getSingleData($this->module, 'LINK_APP');

        $data = [
            'title' => 'Lms',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'item' => $item,
            'link_app' => $linkApp,
        ];

        return view('pages.lms-app', $data);
    }
}
