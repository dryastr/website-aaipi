<?php

namespace App\Http\Controllers\Dashboard\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AnggaranDasar\ActionsRequest;
use App\Http\Requests\Dashboard\AnggaranDasar\CreateRequest;
use App\Http\Requests\Dashboard\AnggaranDasar\UpdateRequest;
use App\Models\AnggaranDasar;
use App\Models\ParamsWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggranDasarController extends Controller
{
    protected $dirView;

    protected $model;

    protected $modelParams;

    protected $module = 'TENTANG_KAMI';

    public function __construct()
    {
        $this->dirView = 'dashboard.anggaran-dasar.';
        $this->model = new AnggaranDasar();
        $this->modelParams = new ParamsWebsite();

    }

    public function index()
    {
        $item = $this->modelParams->getSingleData($this->module, 'ANGGARAN_DASAR');
        $dataForm = [
            'title' => $item ? $item['title'] : null,
            'content' => $item ? $item['content'] : null,
            'image_url' => $item ? $item['image_url'] : null,
        ];

        $data = [
            'title' => 'Anggaran Dasar',
            'item' => $dataForm,
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
        $data = [
            'title' => 'Anggaran Dasar',
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(CreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('file')) {
                $fileImage = $request->file('file');

                // Handle image file
                if ($request->file('file')) {
                    $file = $request['file']->getContent();
                    $file_extension = $request['file']->extension();

                    $file = file_helper()->upload(
                        fileContent: $file,
                        ext: $file_extension,
                        path: 'anggaran_dasar'
                    );

                    $validatedData['image'] = $file['filename'];
                }
            }

            $data = AnggaranDasar::create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);
        }

    }

    public function edit(string $id)
    {
        $data = AnggaranDasar::findOrFail($id);
        $data = [
            'title' => 'Anggaran Dasar',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {

        try {
            $validatedData = $request->validated();
            $visiMisi = AnggaranDasar::findOrFail($id);

            // Handle image file
            if ($request->hasFile('file')) {
                $file = $request->file('file')->getContent();
                $file_extension = $request->file('file')->extension();

                $fileUploadResult = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'anggaran_dasar'
                );

                $validatedData['image'] = $fileUploadResult['filename'];

            } else {
                $validatedData['image'] = null;
            }

            if ($validatedData['image'] == null) {
                unset($data['image']);
            }

            $visiMisi->update($validatedData);

            return response()->json(['message' => 'Berhasil Mengupdate Data'], 200);
        } catch (\Exception $e) {
            // Handle exceptions as needed
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            AnggaranDasar::find($id)->delete();

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
            if ($request->file('image')) {
                $file = $request['image']->getContent();
                $file_extension = $request['image']->extension();
                $date = now()->toDateString();

                $file = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/content/'.$date
                );

                $data['image'] = $file['filename'];
            } else {
                $data['image'] = null;
            }

            $result = DB::transaction(function () use ($data) {
                $dataInput = [
                    'title' => $data['title'],
                    'content' => $data['content'],
                ];

                if ($data['image']) {
                    $dataInput['image'] = $data['image'];
                }

                $this->modelParams->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'ANGGARAN_DASAR',
                ], $dataInput);

                return $data;
            });

            if (! $result) {
                file_helper()->delete($data['image']);
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan Data',
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
}
