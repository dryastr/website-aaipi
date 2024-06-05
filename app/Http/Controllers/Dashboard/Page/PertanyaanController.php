<?php

namespace App\Http\Controllers\Dashboard\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Pertanyaan\CreateRequest;
use App\Http\Requests\Dashboard\Pertanyaan\UpdateRequest;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    protected $dirView;

    protected $model;

    public function __construct()
    {
        $this->dirView = 'dashboard.pertanyaan.';
        $this->model = new Pertanyaan();

    }

    public function index()
    {
        $pertanyaan = Pertanyaan::all();
        $data = [
            'title' => 'Pertanyaan',
            'pertanyaan' => $pertanyaan,
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
        $displayedQuestionsCount = Pertanyaan::where('is_displayed', true)->count();
        $hideCheckbox = $displayedQuestionsCount >= 4;

        $data = [
            'hideCheckbox' => $hideCheckbox,
            'title' => 'Pertanyaan',
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(CreateRequest $request)
    {

        try {
            $validatedData = $request->validated();
            $validatedData['is_displayed'] = $request->has('is_displayed');

            $data = Pertanyaan::create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menyimpan data',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data. Terjadi kesalahan internal.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function edit(string $id)
    {
        $data = Pertanyaan::findOrFail($id);

        $data = [
            'title' => 'Edit Pertanyaan',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {

            $checkedCount = Pertanyaan::where('is_displayed', true)->count();

            if ($request->has('is_displayed') && $checkedCount >= 4) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda tidak dapat menampilkan lebih dari 4 pertanyaan.',
                ], 422);
            }

            $pertanyaan = Pertanyaan::find($id);

            if (! $pertanyaan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pertanyaan tidak ditemukan.',
                ], 404);
            }

            $data = $request->validated();
            $data['is_displayed'] = $request->has('is_displayed');

            $pertanyaan->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah data',
                'data' => $pertanyaan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengubah data. Terjadi kesalahan internal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            Pertanyaan::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }
}
