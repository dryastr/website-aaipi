<?php

namespace App\Http\Controllers\Dashboard\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProgramKerja\CreateRequest;
use App\Http\Requests\Dashboard\ProgramKerja\UpdateRequest;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramKerjaController extends Controller
{
    protected $dirView;

    protected $model;

    public function __construct()
    {
        $this->middleware('can:program-kerja.view')->only(['index', 'getView']);
        $this->middleware('can:program-kerja.create')->only(['create', 'store']);
        $this->middleware('can:program-kerja.edit')->only(['edit', 'update']);
        $this->middleware('can:program-kerja.delete')->only(['delete']);
        $this->dirView = 'dashboard.program-kerja.';
        $this->model = new ProgramKerja();
    }

    public function index()
    {
        $program = ProgramKerja::all();
        // dd($program);
        $data = [
            'title' => 'Program Kerja',
            'program' => $program,
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
        ]);

    }

    public function create()
    {
        $title_content = ProgramKerja::whereNotNull('title_content')->first(['title_content']);
        // $image = ProgramKerja::getSin('image')->first(['image']);
        // $banner = ProgramKerja::whereNotNull('banner')->first(['banner']);
        $data = [
            'title_content' => $title_content,
            // 'image' => $image,
            // 'banner' => $banner,
            'title' => 'Program Kerja',
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(CreateRequest $request)
    {

        // try {
        //     $validatedData = $request->validated();

        //     // Cek apakah data pertama
        //     if (ProgramKerja::count() === 0 && empty($validatedData['title_description'])) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'Title Description harus diisi pada data pertama.'
        //         ], 422);
        //     }

        //     $data = ProgramKerja::create($validatedData);

        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Berhasil Menyimpan data',
        //         'data' => $data,
        //     ]);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Gagal menyimpan data',
        //         'error' => $th->getMessage(),
        //     ], 500);
        // }

        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');

                // Handle image file
                if ($request->file('image')) {
                    $file = $request['image']->getContent();
                    $file_extension = $request['image']->extension();
                    $date = now()->toDateString();

                    $file = file_helper()->upload(
                        fileContent: $file,
                        ext: $file_extension,
                        path: 'img/service/'.$date
                    );

                    $validatedData['image'] = $file['filename'];
                }
            }

            $data = ProgramKerja::create($validatedData);

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
        $data = ProgramKerja::findOrFail($id);
        $data = [
            'title' => 'Program Kerja',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $programKerja = ProgramKerja::findOrFail($id);

            // Handle image file
            if ($request->hasFile('image')) {
                $file = $request->file('image')->getContent();
                $file_extension = $request->file('image')->extension();
                $date = now()->toDateString();

                $fileUploadResult = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/visi-misi/'.$date
                );

                $validatedData['image'] = $fileUploadResult['filename'];

                // Log path file lama dan baru untuk debugging
                info('Old Image Path: '.$programKerja->image);

                if (Storage::exists($programKerja->image)) {
                    Storage::delete($programKerja->image);
                    info('Old Image Deleted');
                }
            }

            // Update the programKerja model with the new data
            $programKerja->update($validatedData);

        } catch (\Exception $e) {
            // Handle exceptions as needed
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'programKerja updated successfully'], 200);

        // try {
        //     $programKerja = ProgramKerja::findOrFail($id);
        //     $validatedData = $request->validated();

        //     if ($request->hasFile('image')) {
        //         $fileImage = $request->file('image');
        //         if ($fileImage->isValid()) {
        //             $fileName = $fileImage->getClientOriginalName();
        //             $filePath = 'assets/img/service/' . $fileName;

        //             // Hapus file lama jika ada
        //             $oldFilePath = public_path($programKerja->image ?? '');
        //             if (is_file($oldFilePath)) {
        //                 unlink($oldFilePath);
        //             }

        //             $fileImage->move(public_path('assets/img/service'), $fileName);
        //             $validatedData['image'] = $filePath;
        //         }
        //     } else {
        //         $validatedData['image'] = $programKerja->image;
        //     }

        //     if ($request->hasFile('banner')) {
        //         $fileBanner = $request->file('banner');
        //         if ($fileBanner->isValid()) {
        //             $fileName = $fileBanner->getClientOriginalName();
        //             $filePath = 'assets/img/service/' . $fileName;

        //             // Hapus file lama jika ada
        //             $oldFilePath = public_path($programKerja->banner ?? '');
        //             if (is_file($oldFilePath)) {
        //                 unlink($oldFilePath);
        //             }

        //             $fileBanner->move(public_path('assets/img/service'), $fileName);
        //             $validatedData['banner'] = $filePath;
        //         }
        //     } else {
        //         $validatedData['banner'] = $programKerja->banner;
        //     }

        //     $programKerja->update($validatedData);

        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Berhasil Memperbarui data',
        //         'data' => $programKerja,
        //     ]);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Gagal memperbarui data',
        //         'error' => $th->getMessage(),
        //     ], 500);
        // }
    }

    public function destroy(string $id)
    {
        try {
            $programKerja = ProgramKerja::findOrFail($id);

            // Hapus image
            if ($programKerja->image) {
                $imagePath = 'assets/img/service/'.$programKerja->image;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            // Hapus banner
            if ($programKerja->banner) {
                $bannerPath = 'assets/img/service/'.$programKerja->banner;
                if (Storage::exists($bannerPath)) {
                    Storage::delete($bannerPath);
                }
            }

            // Hapus record dari database
            $programKerja->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }
}
