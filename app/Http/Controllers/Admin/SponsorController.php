<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Sponsor\CreateRequest;
use App\Http\Requests\Dashboard\Sponsor\UpdateRequest;
use App\Models\Sponsor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SponsorController extends Controller
{
    protected $dirView;

    protected $model;

    public function __construct()
    {
        $this->dirView = 'admin.pages.CMS.sponsor.';
        $this->model = new Sponsor();
    }

    public function index()
    {
        $data = [
            'title' => 'Sponsor',
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
            'title' => 'Tambah Sponsor',
        ];

        return view($this->dirView.'add', $data);

    }

    public function store(CreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Handle image file
            if ($request->file('image')) {
                $file = $request['image']->getContent();
                $file_extension = $request['image']->extension();
                $date = now()->toDateString();

                $file = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/sponsor/'.$date
                );

                $validatedData['image'] = $file['filename'];
            }

            $data = $this->model->create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);
        }

    }

    public function destroy(string $id)
    {
        try {
            $this->model->find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(string $id)
    {
        $data = $this->model->findOrFail($id);

        $data = [
            'title' => 'Edit Sponsor',
            'item' => $data,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $sponsor = $this->model->find($id);

            // Handle image file
            $image = $sponsor->image;
            if ($request->file('image')) {
                $file = $request['image']->getContent();
                $file_extension = $request['image']->extension();
                $date = now()->toDateString();

                $file = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/sponsor/'.$date
                );

                $validatedData['image'] = $file['filename'];
            } else {
                $validatedData['image'] = null;
            }

            $result = DB::transaction(function () use ($validatedData, $sponsor) {
                if ($validatedData['image'] == null) {
                    unset($validatedData['image']);
                }
                $sponsor->update($validatedData);

                return $validatedData;
            });

            if (! $result) {
                if ($validatedData['image']) {
                    file_helper()->delete($validatedData['image']);
                }
            }

            if ($result) {
                if ($validatedData['image']) {
                    if ($image) {
                        file_helper()->delete($image);
                    }
                }
            }

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
}
