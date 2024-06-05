<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryOnGaleri\CreateRequest;
use App\Http\Requests\Dashboard\CategoryOnGaleri\UpdateRequest;
use App\Models\CategoryOnGaleri;
use Exception;
use Illuminate\Http\Request;

class CategoryOnGaleriController extends Controller
{
    protected $dirView;

    protected $model;

    public function __construct()
    {
        $this->middleware('can:setting.category-on-galeri.view')->only(['index', 'getView']);
        $this->middleware('can:setting.category-on-galeri.create')->only(['create', 'store']);
        $this->middleware('can:setting.category-on-galeri.edit')->only(['edit', 'update']);
        $this->middleware('can:setting.category-on-galeri.delete')->only(['delete']);
        $this->dirView = 'admin.pages.setting.category-on-galeri.';
        $this->model = new CategoryOnGaleri();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Kategori Galeri',
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data = [
            'title' => 'Tambah Kategori Galeri',
        ];

        return view($this->dirView.'add', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {

            $jenisKeanggotaan = $request->input('kode');

            if ($jenisKeanggotaan === '') {
                $jenisKeanggotaan = null;
            }

            $validatedData = $request->validate([
                'kode' => 'nullable|string',
                'title' => 'required|string',
                'date' => 'required|date',
                'location' => 'required|string',
            ]);

            $validatedData['kode'] = $jenisKeanggotaan;

            $data = CategoryOnGaleri::create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menambahkan Category',
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
        $data = CategoryOnGaleri::findOrFail($id);
        $data = [
            'title' => 'Ubah Kategori Galeri',
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
            $data = CategoryOnGaleri::find($id)->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah Category',
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
            CategoryOnGaleri::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }
}
