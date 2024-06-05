<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    protected $model;

    protected $modelBanner;

    public function __construct()
    {
        $this->model = new News();
        $this->modelBanner = new Banner();
    }

    public function index(Request $request)
    {
        $query = $this->model
            ->where('status', 'publish')
            ->when($request->search, function (Builder $builder) use ($request) {
                $builder->where('title', 'like', "%{$request->search}%")->orWhere('content', 'like', "%{$request->search}%");
            })
            ->when(($request->tahun && $request->bulan), function (Builder $builder) use ($request) {
                $builder
                    ->whereRaw('YEAR(`created_at`) = "'.$request->tahun.'" AND MONTH(`created_at`) = "'.$request->bulan.'"');
            })
            ->paginate(2)->withQueryString();

        $banner = $this->modelBanner->where('kode', 'PUBLIKASI')->first();

        $data = [
            'title' => 'Publikasi',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'data' => $query,
            'recent_post' => $this->model->newsHomePage(),
            'list_archives' => $this->model->getListArchives(),
        ];

        return view('pages.publikasi', $data);
    }
}
