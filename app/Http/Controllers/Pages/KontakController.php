<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Kontak\CreateRequest;
use App\Http\Requests\Dashboard\Kontak\UpdateRequest;
use App\Models\Banner;
use App\Models\Kontak;
use App\Models\ParamsWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontakController extends Controller
{
    protected $dirView;

    protected $model;

    protected $modelParams;

    public function __construct()
    {
        $this->dirView = 'dashboard.kontak.';
        $this->model = new Kontak();
        $this->modelParams = new ParamsWebsite();
    }

    public function index()
    {
        $banner = Banner::where('kode', 'KONTAK')->first();

        $data = [
            'title' => 'Kontak',
            'image_banner' => $banner ? $banner->image_url : asset('assets/img/breadcrumb/01.jpg'),
            'title_banner' => $banner ? $banner->title : null,
            'alamatKantor' => $this->modelParams->getSingleData('KONTAK', 'KONTAK_ALAMAT_KANTOR'),
            'hubungiKami' => $this->modelParams->getSingleData('KONTAK', 'KONTAK_HUBUNGI_KAMI'),
            'emailKami' => $this->modelParams->getSingleData('KONTAK', 'KONTAK_EMAIL_KAMI'),
            'jamKerja' => $this->modelParams->getSingleData('KONTAK', 'KONTAK_JAM_KERJA'),
            'data' => $this->modelParams->getSingleData('KONTAK', 'KONTAK_DESCRIPTION'),
        ];

        return view('pages.kontak', $data);
    }

    public function table()
    {
        $kontak = Kontak::all();
        $alamat = Kontak::where('kode', 'ALAMAT_KANTOR')->first();
        $data = [
            'alamat' => $alamat,
            'title' => 'Kontak',
            'kontak' => $kontak,
        ];

        // return view('pages/kontak', $data);
        return view($this->dirView.'index', $data);
    }

    public function getView(Request $request)
    {
        $columns = $request->input('columns');
        $query = $this->model->select('*');
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
        ]);
    }

    public function create()
    {
        $image = Kontak::whereNotNull('image')->first(['image']);
        $image_banner = Kontak::whereNotNull('image_banner')->first(['image_banner']);
        $title_banner = Kontak::whereNotNull('title_banner')->first(['title_banner']);
        $content = Kontak::whereNotNull('content')->first(['content']);
        $title_content = Kontak::whereNotNull('title_content')->first(['title_content']);
        $data = [
            'title_banner' => $title_banner,
            'image_banner' => $image_banner,
            'image' => $image,
            'content' => $content,
            'title_content' => $title_content,
            'title' => 'Kontak',
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(CreateRequest $request)
    {

        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image') && $request->hasFile('image_banner')) {
                $fileImage = $request->file('image');
                $fileBanner = $request->file('image_banner');

                // Handle image file
                if ($request->file('image')) {
                    $file = $request['image']->getContent();
                    $file_extension = $request['image']->extension();
                    $date = now()->toDateString();

                    $file = file_helper()->upload(
                        fileContent: $file,
                        ext: $file_extension,
                        path: 'img/contact/'.$date
                    );

                    $validatedData['image'] = $file['filename'];
                }

                if ($request->file('image_banner')) {
                    $file2 = $request['image_banner']->getContent();
                    $file_extension2 = $request['image_banner']->extension();
                    $date = now()->toDateString();

                    $file2 = file_helper()->upload(
                        fileContent: $file2,
                        ext: $file_extension2,
                        path: 'img/contact/'.$date
                    );

                    $validatedData['image_banner'] = $file2['filename'];
                }
                $existingAlamat = Kontak::where('kode', $validatedData['kode'])->first();

                if ($existingAlamat) {
                    // Jika title sudah ada di database, perbarui data tersebut
                    $existingAlamat->update([
                        'description' => $validatedData['description'],
                        'title' => $validatedData['title'],
                        // Tambahan: perbarui data lainnya sesuai kebutuhan
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Berhasil memperbarui data '.$validatedData['title'],
                        'data' => $existingAlamat,
                    ]);
                }
            }

            $data = Kontak::create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return $this->response($th);
        }

    }

    public function edit(string $id)
    {
        $data = Kontak::findOrFail($id);
        $data = [
            'title' => 'Edit Kontak',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    // public function update(UpdateRequest $request, string $id)
    // {

    //     try {
    //         $programKerja =  Kontak::find($id);

    //         if (!$programKerja) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data tidak ditemukan',
    //             ], 404);
    //         }

    //         $validatedData = $request->validated();

    //         if ($request->hasFile('image')) {
    //             $file = $request->file('image');
    //             $file_content = $file->getContent();
    //             $file_extension = $file->extension();
    //             $date = now()->toDateString();

    //             $fileUploadPath = 'public/kontak/' . $date . '/' . $file->getClientOriginalName();
    //             Storage::put($fileUploadPath, $file_content);

    //             $validatedData['image'] = $fileUploadPath;

    //             // Hapus file lama jika ada
    //             if (Storage::exists($programKerja->image)) {
    //                 Storage::delete($programKerja->image);
    //             }
    //         }

    //         $programKerja->update($validatedData);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Berhasil Mengubah data',
    //             'data' => $programKerja,
    //         ]);
    //     } catch (Exception $e) {
    //         return $this->response($e);
    //     }
    // }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $visiMisi = Kontak::findOrFail($id);

            // Handle image file
            if ($request->hasFile('image')) {
                $file = $request->file('image')->getContent();
                $file_extension = $request->file('image')->extension();
                $date = now()->toDateString();

                $fileUploadResult = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/contact/'.$date
                );

                $validatedData['image'] = $fileUploadResult['filename'];

                // Log path file lama dan baru untuk debugging
                info('Old Image Path: '.$visiMisi->image);

                if (Storage::exists($visiMisi->image)) {
                    Storage::delete($visiMisi->image);
                    info('Old Image Deleted');
                }
            }

            // Handle banner file
            if ($request->hasFile('image_banner')) {
                $file = $request->file('image_banner')->getContent();
                $file_extension = $request->file('image_banner')->extension();
                $date = now()->toDateString();

                $fileUploadResult = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/contact/'.$date
                );

                $validatedData['image_banner'] = $fileUploadResult['filename'];

                // Log path file lama dan baru untuk debugging
                info('Old Banner Path: '.$visiMisi->banner);

                if (Storage::exists($visiMisi->image_banner)) {
                    Storage::delete($visiMisi->image_banner);
                    info('Old Banner Deleted');
                }
            }

            // Update the visiMisi model with the new data
            $visiMisi->update($validatedData);

        } catch (\Exception $e) {
            // Handle exceptions as needed
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Kontak updated successfully'], 200);
    }

    public function destroy(string $id)
    {
        try {
            Kontak::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }
}
