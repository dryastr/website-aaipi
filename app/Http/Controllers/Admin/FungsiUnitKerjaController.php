<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\FungsiUnitKerja\CreateRequest;
use App\Http\Requests\Dashboard\FungsiUnitKerja\UpdateRequest;
use App\Models\FungsiUnitKerja;
use Illuminate\Http\Request;
use View;

class FungsiUnitKerjaController extends Controller
{
    protected $dirView;

    protected $model;

    public function __construct()
    {
        $this->middleware('can:CMS.fungsi-unit-kerja.view')->only(['index', 'getView']);
        $this->middleware('can:CMS.fungsi-unit-kerja.create')->only(['create', 'store']);
        $this->middleware('can:CMS.fungsi-unit-kerja.edit')->only(['edit', 'update']);
        $this->middleware('can:CMS.fungsi-unit-kerja.delete')->only(['delete']);
        $this->dirView = 'admin.pages.CMS.fungsi-unit-kerja.';
        $this->model = new FungsiUnitKerja();

    }

    public function index()
    {

        $fungsiUnitKerja = FungsiUnitKerja::all();

        $data = [
            'title' => 'Produk AAIPI',
            'fungsiUnitKerja' => $fungsiUnitKerja,
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
            'title' => 'Tambah Produk AAIPI',
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(CreateRequest $request)
    {

        try {
            $validatedData = $request->validated();

            $data = FungsiUnitKerja::create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

//     public function store(CreateRequest $request)
// {
//     try {
//         $data = $request->validated();
        
//         // Hapus 'icon' dari data jika kosong
//         if(empty($data['icon'])) {
//             unset($data['icon']);
//         }

//         $fungsiUnitKerja = FungsiUnitKerja::create($data);

//         return response()->json([
//             'status' => true,
//             'message' => 'Berhasil Mengubah data',
//             'data' => $fungsiUnitKerja,
//         ]);
//     } catch (Exception $e) {
//         return $this->response($e);
//     }
// }

    public function edit(string $id)
    {
        $data = FungsiUnitKerja::findOrFail($id);

        $data = [
            'title' => 'Edit Produk AAIPI',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $data = FungsiUnitKerja::find($id)->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah data',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }

    public function destroy(string $id)
    {
        try {
            FungsiUnitKerja::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }
}