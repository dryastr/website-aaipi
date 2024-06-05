<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StrukturOrganisasi\CreateRequest;
use App\Http\Requests\Dashboard\StrukturOrganisasi\UpdateRequest;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    protected $dirView;

    protected $model;

    public function __construct()
    {
        $this->middleware('can:CMS.struktur-organisasi.view')->only(['index', 'getView']);
        $this->middleware('can:CMS.struktur-organisasi.create')->only(['create', 'store']);
        $this->middleware('can:CMS.struktur-organisasi.edit')->only(['edit', 'update']);
        $this->middleware('can:CMS.struktur-organisasi.delete')->only(['delete']);
        $this->dirView = 'admin.pages.CMS.struktur-organisasi.';
        $this->model = new StrukturOrganisasi();
    }

    public function index()
    {
        $keuangan = StrukturOrganisasi::all();

        $data = [
            'title' => 'Struktur Organisasi',

        ];

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

        $data = [
            'title' => 'Organisasi  ',
        ];

        return view($this->dirView.'add', $data);

    }

    public function store(CreateRequest $request)
    {

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
                        path: 'img/struktur-organisasi/'.$date
                    );

                    $validatedData['image'] = $file['filename'];
                }

            }

            $data = StrukturOrganisasi::create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return $this->response($th);
        }

    }

    public function destroy(string $id)
    {
        try {
            StrukturOrganisasi::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }

    public function edit(string $id)
    {
        $data = StrukturOrganisasi::findOrFail($id);
        $data = [
            'title' => 'update',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $strukturOrganisasi = StrukturOrganisasi::findOrFail($id);

            // Handle image file
            if ($request->hasFile('image')) {
                $file = $request->file('image')->getContent();
                $file_extension = $request->file('image')->extension();
                $date = now()->toDateString();

                $fileUploadResult = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/struktur-organisasi/'.$date
                );

                $validatedData['image'] = $fileUploadResult['filename'];

                // Log path file lama dan baru untuk debugging
                info('Old Image Path: '.$strukturOrganisasi->image);

                if (Storage::exists($strukturOrganisasi->image)) {
                    Storage::delete($strukturOrganisasi->image);
                    info('Old Image Deleted');
                }
            }

            // Update the visiMisi model with the new data
            $strukturOrganisasi->update($validatedData);

        } catch (\Exception $e) {
            // Handle exceptions as needed
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Data Organisasi updated successfully'], 200);
    }
}
