<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Banner\CreateRequest;
use App\Http\Requests\Dashboard\Banner\UpdateRequest;
use App\Http\Requests\Dashboard\Banner\ActionsRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    protected $dirView;
    protected $model;
    protected $module = 'KONTAK';

    public function __construct()
    {
        // $this->middleware('can:CMS.banner.view')->only(['index', 'getView']);
        // $this->middleware('can:CMS.banner.create')->only(['create', 'store']);
        // $this->middleware('can:CMS.banner.edit')->only(['edit', 'update']);
        // $this->middleware('can:CMS.banner.delete')->only(['delete']);
        $this->dirView = 'admin.pages.CMS.banner.';
        $this->model = new Banner();
    }

    public function index()
{
    $banners = Banner::all();

    $data = [
        'title' => 'Banner',
        'banners' => $banners,
    ];

    return view($this->dirView.'index', $data);
}

public function getView(Request $request)
{
    try {
        $query = $this->model->select('*')->latest()->where('kode', 'BERANDA_SLIDER');

        if ($request->filled('search.value')) {
            $query->where(function ($query) use ($request) {
                foreach ($this->searchableColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $request->input('search.value') . '%');
                }
            });
        }

        if ($request->input('order')) {
            foreach ($request->input('order') as $order) {
                $query->orderBy($request->input('columns')[$order['column']]['data'], $order['dir']);
            }
        }

        $data = $query->paginate($request->input('length'));

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menampilkan data',
            'data' => $data->items(),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
            'imageBaseUrl' => asset('public/banner/'),
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function create()
    {
        $typeOptions = Banner::getTypeOptions();

        $data = [
            'typeOptions' => $typeOptions,
            'title' => 'Tambah Banner',
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(CreateRequest $request, $id = null)
    {
        // dd($request->all());
        try {
            $validatedData = $request->validated();
    
            $typeOptions = Banner::getTypeOptions();
    
            if (!in_array($request->input('type'), array_keys($typeOptions))) {
                throw new \Exception('Tipe yang dipilih tidak valid');
            }
    
            $validatedData['type'] = $request->input('type');
            $validatedData['color'] = $request->input('color') ?? $request->input('color');
    
            if ($request->hasFile('image')) {
                $file = $request->file('image')->getContent();
                $file_extension = $request->file('image')->extension();
                $date = now()->toDateString();
    
                $fileUploadResult = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/banner/'.$date
                );
    
                $validatedData['image'] = $fileUploadResult['filename'];
            }
    
            $validatedData['kode'] = 'BERANDA_SLIDER';
    
            $data = Banner::create($validatedData);
    
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
    
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: '.$th->getMessage(),
            ], 500);
        }
    }
    

    public function edit(string $id)
    {
        $data = Banner::findOrFail($id);
        $typeOptions = Banner::getTypeOptions();

        $data = [
            'typeOptions' => $typeOptions,
            'title' => 'Edit Banner',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $banner = Banner::findOrFail($id);
    
            $typeOptions = Banner::getTypeOptions();
    
            if (!in_array($request->input('type'), array_keys($typeOptions))) {
                throw new \Exception('Tipe yang dipilih tidak valid');
            }
    
            if ($request->hasFile('image')) {
                $file = $request->file('image')->getContent();
                $file_extension = $request->file('image')->extension();
                $date = now()->toDateString();
    
                $fileUploadResult = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/banner/'.$date
                );
    
                $validatedData['image'] = $fileUploadResult['filename'];
    
                if ($banner->image) {
                    file_helper()->delete($banner->image);
                }
            }
    
            $banner->type = $request->input('type');
            $validatedData['color'] = $request->input('color') ?? $request->input('color');
    
            unset($validatedData['kode']);
    
            $banner->update($validatedData);
    
            return response()->json([
                'status' => true,
                'message' => 'Banner berhasil diperbarui',
                'data' => $banner,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function destroy(string $id)
    {
        try {
            $data = $this->model->find($id);

            if ($data['image']) {
                file_helper()->delete($data['image']);
            }

            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function actions(ActionsRequest $request)
{
    try {
        $data = $request->validated();
        
        $result = DB::transaction(function () use ($data, $request) {
            foreach ($request->all() as $key => $value) {
                if ($request->file($key)) {
                    $file = $request->file($key);
                    
                    $uppercaseKey = strtoupper($key);

                    $titles = [
                        'BERANDA_KONTAK' => 'Beranda Kontak',
                        'BERANDA_KURSUS' => 'Beranda Kursus',
                        'SEJARAH_SINGKAT' => 'Sejarah Singkat',
                        'VISI_DAN_MISI' => 'Visi dan Misi',
                        'STRUKTUR_ORGANISASI' => 'Struktur Organisasi',
                        'PROGRAM_KERJA' => 'Program Kerja',
                        'ANGGARAN_DASAR' => 'Anggaran Dasar',
                        'PUBLIKASI' => 'Publikasi',
                        'KEANGGOTAAN' => 'Keanggotaan',
                        'ELMS_AAIP' => 'E-LMS AAIPI',
                        'TELAAH_SEJAWAT' => 'Telaahh Sejawat',
                        'KONTAK' => 'Kontak',
                    ];
                    
                    $title = $titles[$uppercaseKey] ?? ucwords(str_replace('_', ' ', $key));

                    $fileContent = $file->getContent();
                    $fileExtension = $file->extension();

                    $date = now()->toDateString();
                    $path = 'img/banner/'.$date;
                    $fileUploadResult = file_helper()->upload(
                        fileContent: $fileContent,
                        ext: $fileExtension,
                        path: $path
                    );

                    $oldBanner = Banner::where('kode', $uppercaseKey)->first();
                    if ($oldBanner) {
                        file_helper()->delete($oldBanner->image);
                    }

                    Banner::updateOrCreate(['kode' => $uppercaseKey], [
                        'title' => $title,
                        $uppercaseKey => $fileUploadResult['filename'],
                        'image' => $fileUploadResult['filename']
                    ]);
                }
            }
    
            return true;
        }); 

        if (! $result) {
            file_helper()->delete($data['image']);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menyimpan Data',
            'data' => $data,
        ]);
    
    } catch (Exception $e) {
        return response()->json($e, 500);
    }
}


}
