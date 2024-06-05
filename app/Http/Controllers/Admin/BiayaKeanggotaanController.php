<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BiayaKeanggotaan\CreateRequest;
use App\Http\Requests\Dashboard\BiayaKeanggotaan\UpdateRequest;
use App\Models\BiayaKeanggotaan;
use Illuminate\Http\Request;

class BiayaKeanggotaanController extends Controller
{
    protected $dirView;

    protected $model;

    public function __construct()
    {
        $this->middleware('can:setting.biaya-keanggotaan.view')->only(['index', 'getView']);
        $this->middleware('can:setting.biaya-keanggotaan.create')->only(['create', 'store']);
        $this->middleware('can:setting.biaya-keanggotaan.edit')->only(['edit', 'update']);
        $this->middleware('can:setting.biaya-keanggotaan.delete')->only(['delete']);
        $this->dirView = 'admin.pages.setting.biaya-keanggotaan.';
        $this->model = new BiayaKeanggotaan();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keuangan = BiayaKeanggotaan::all();

        $data = [
            'title' => 'Biaya Keanggotaan',
            'keuangan' => $keuangan,
        ];

        // return view('admin.pages.setting.biaya-keuangan.index');

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data = [
            'title' => 'Tambah Data Biaya Keanggotaan ',
        ];

        return view($this->dirView.'add', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {

            $jenisKeanggotaan = $request->input('jenis_keanggotaan');
            if ($jenisKeanggotaan === '') {
                $jenisKeanggotaan = null;
            }

            $validatedData = $request->validated();

            $validatedData['jenis_keanggotaan'] = $jenisKeanggotaan;

            $data = BiayaKeanggotaan::create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BiayaKeanggotaan::findOrFail($id);
        $data = [
            'title' => 'update data biaya keanggotaan ',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $data = BiayaKeanggotaan::find($id)->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah data',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            BiayaKeanggotaan::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }
}
