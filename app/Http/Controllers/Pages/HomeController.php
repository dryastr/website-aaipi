<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\AdBanner;
use App\Models\CategoryOnGaleri;
use App\Models\FungsiUnitKerja;
use App\Models\GaleriKategori;
use App\Models\News;
use App\Models\ParamsWebsite;
use App\Models\Pertanyaan;
use App\Models\ProgramKerja;
use App\Models\Sponsor;
use App\Models\StrukturOrganisasi;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $modelNews;

    protected $modelUser;

    protected $modelParams;

    protected $modelGallery;

    protected $modelSponsor;

    public function __construct()
    {
        $this->modelNews = new News();
        $this->modelUser = new User();
        $this->modelParams = new ParamsWebsite();
        $this->modelGallery = new GaleriKategori();
        $this->modelSponsor = new Sponsor();

    }

    public function index()
    {

        $programkerja = ProgramKerja::all();
        $pertanyaan = Pertanyaan::where('is_displayed', true)->get();
        $sliderBanner = Banner::where('kode', 'BERANDA_SLIDER')->latest()->get();
        $sliderKontak = Banner::where('kode', 'BERANDA_KONTAK')->first();
        $sliderKursus = Banner::where('kode', 'BERANDA_KURSUS')->first();
        $item_sejarah = $this->modelParams->getSingleData('TENTANG_KAMI', 'SEJARAH_SINGKAT');
        $visimisi = $this->modelParams->getSingleData('TENTANG_KAMI', 'VISI_MISI');
        $galery = $this->modelGallery->select('*')->orderBy('created_at', 'DESC');
        $title_content = ProgramKerja::whereNotNull('title_content')->first(['title_content']);
        $alamat = $this->modelParams->getSingleData('KONTAK', 'KONTAK_HUBUNGI_KAMI');
        $berita = $this->modelNews->newsHomePage();
        $fungsiUnitKerja = FungsiUnitKerja::all();
        $jumlahUser = [
            'anggota_biasa' => $this->modelUser->countUserByRole(2),
            'anggota_luar_biasa' => $this->modelUser->countUserByRole(3),
            'anggota_kehormatan' => $this->modelUser->countUserByRole(4),
        ];
        $strukturOrganisasi = StrukturOrganisasi::all();
        $category = CategoryOnGaleri::select('id', 'kode', 'title', 'date', 'location')->get();
        $adBanners = AdBanner::all();
        $sponsor = $this->modelSponsor->whereDate('expired_at', '>=', date('Y-m-d'))->get();
        $data = [
            'visimisi' => $visimisi,
            'alamat' => $alamat,
            'title' => 'Home',
            'item_sejarah' => $item_sejarah,
            'pertanyaan' => $pertanyaan,
            'title_content' => $title_content ? $title_content->title_content : null,
            'programkerja' => $programkerja,
            'sliderBanner' => $sliderBanner,
            'sliderKontak' => $sliderKontak ? $sliderKontak->image_url : asset('assets/img/call/01.jpg'),
            'sliderKursus' => $sliderKursus,
            'galery' => $galery->get(),
            'galery_count' => $galery->count(),
            'berita' => $berita,
            'fungsiUnitKerja' => $fungsiUnitKerja,
            'jumlah_user' => $jumlahUser,
            'strukturOrganisasi' => $strukturOrganisasi,
            'category' => $category,
            'sponsor' => $sponsor,
            'adBanners' => $adBanners,
        ];

        $client = new Client();
        $data['apiData'] = [];

        try {
            // Mengirimkan permintaan GET ke endpoint API
            $response = $client->request('GET', 'https://dev-lms.aaipi.id/api/development/courses', [
                'headers' => [
                    'x-api-key' => '1234',
                    'Accept' => 'application/json',
                ],
            ]);

            // Mendapatkan data dari respons
            $apiData = json_decode($response->getBody(), true);
            // dd($apiData);

            // Menambahkan data API ke dalam array $data
            $data['apiData'] = $apiData;

        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            $data['error'] = $e->getMessage();
        }

        return view('pages.home', $data);
    }

    public function getAllGallery(){
        $allGallery = GaleriKategori::all();
        return response()->json([
            'data' => $allGallery
        ], 200);
    }

    public function getCategoryGallery($id){
        $allCategory = GaleriKategori::select("*")->where("category", $id)->get();
        $kode = CategoryOnGaleri::whereId($id)->first();
        return response()->json([
            'data' => $allCategory,
            'kode' => $kode
        ], 200);
    }

    public function programkerjaselengkapnya($id)
    {
        $kerja = ProgramKerja::findOrFail($id);

        $data = [
            'title' => $kerja->title,
            'kerja' => $kerja,
        ];

        return view('pages/proker-selengkapnya/selengkapnya', $data);
    }

    public function selengkapnya($id)
    {
        $banners = Banner::findOrFail($id);
        $data = [
            'title' => 'Asosiasi Auditor Intern Pemerintah Indonesia',
            'banners' => $banners,
        ];

        return view('pages/home-selengkapnya/selengkapnya', $data);
    }

    public function gallery(Request $request)
    {
        $bannerSelengkapnya = Banner::where('kode', 'PUBLIKASI')->first();
        $query = $this->modelGallery
            ->orderBy('created_at', 'DESC')
            ->paginate(9)->withQueryString();

        $data = [
            'title' => 'Gallery',
            'data' => $query,
            'bannerSelengkapnya' => $bannerSelengkapnya ? $bannerSelengkapnya->image_url : asset('assets/img/call/01.jpg'),
        ];

        return view('pages.gallery', $data);
    }
}
