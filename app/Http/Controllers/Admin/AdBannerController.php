<?php

namespace App\Http\Controllers\admin;

use App\Models\AdBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdBanner\CreateRequest;
use App\Http\Requests\Dashboard\AdBanner\UpdateRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class AdBannerController extends Controller
{
    protected $dirView;
    protected $model;
    // protected $module = 'KONTAK';

    public function __construct()
    {
        $this->middleware('can:cms.iklan-banner.view')->only(['index', 'getView']);
        $this->middleware('can:cms.iklan-banner.create')->only(['create', 'store']);
        $this->middleware('can:cms.iklan-banner.edit')->only(['edit', 'update']);
        $this->middleware('can:cms.iklan-banner.delete')->only(['delete']);
        $this->dirView = 'admin.pages.cms.iklan-banner.';
        $this->model = new AdBanner();
    }

    public function index()
    {
        $adBanners = AdBanner::all();
    
        $data = [
            'title' => 'Banner',
            'adBanners' => $adBanners,
        ];
    
        return view($this->dirView.'index', $data);
    }

    public function getView(Request $request)
    {
        $columns = $request->input('columns');
        $query = $this->model->select('*')->latest();
        if ($request->filled('search.value')) {
            $query->where(function ($query) use ($columns, $request) {
                foreach ($columns as $column) {
                    if ($column['searchable'] == 'true') {
                        $query->orWhere($column['data'], 'like', '%'.$request->input('search.value').'%');
                    }
                }
            });
        }

        // Order by specific columns
        if ($request->input('order')) {
            foreach ($request->input('order') as $order) {
                $query->orderBy($request->input('columns')[$order['column']]['data'], $order['dir']);
            }
        }

        // Paginate the results
        $data = $query->paginate($request->input('length'));

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menampilkan data',
            'data' => $data->items(),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
            'imageBaseUrl' => asset('public/banner/'),
        ]);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Ad Banner',
        ];

        return view($this->dirView.'add', $data);

    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'url' => 'required|string|max:255',
                'target' => 'required|string|max:255',
            ]);
    
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
    
            $data = AdBanner::create($validatedData);
    
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function edit(string $id)
    {
        $data = AdBanner::findOrFail($id);

        $data = [
            'title' => 'Update Iklan Banner',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $adBanner = AdBanner::findOrFail($id);
    
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
    
                if ($adBanner->image) {
                    file_helper()->delete($adBanner->image);
                }
            }
    
            $adBanner->update($validatedData);
    
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah Data',
                'data' => $validatedData,
            ]);
        } catch (\Exception $e) {
            // Handle exceptions as needed
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }    

    public function destroy(string $id)
    {
        try {
            AdBanner::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
