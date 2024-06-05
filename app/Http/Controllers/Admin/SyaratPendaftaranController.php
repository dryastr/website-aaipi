<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SyaratPendaftaran\CreateRequest;
use App\Http\Requests\Dashboard\SyaratPendaftaran\UpdateRequest;
use App\Models\SyaratPendaftaran;
use Exception;

class SyaratPendaftaranController extends Controller
{
    protected $dirView = 'admin.pages.setting.syarat-pendaftaran.';

    protected $model;

    public function __construct()
    {
        $this->middleware('can:setting.syarat-pendaftaran.view')->only(['index', 'getView']);
        $this->middleware('can:setting.syarat-pendaftaran.create')->only(['create', 'store']);
        $this->middleware('can:setting.syarat-pendaftaran.edit')->only(['edit', 'update']);
        $this->middleware('can:setting.syarat-pendaftaran.delete')->only(['delete']);
        $this->model = new SyaratPendaftaran();
    }

    public function index()
    {
        $data = [
            'title' => 'Syarat Pendaftaran',
        ];

        return view($this->dirView.'index', $data);
    }

    public function getView()
    {
        $query = $this->model->getAll();

        return response()->json([
            'message' => 'Berhasil Menampilkan data',
            'data' => $query,
        ]);
    }

    public function create(?string $parent = null)
    {
        $data = [
            'title' => 'Tambah Syarat Pendaftaran',
            'parent' => $parent,
        ];

        return view($this->dirView.'add', $data);

    }

    public function store(CreateRequest $request)
    {
        try {
            $data = $request->validated();
            $order_position = $this->model->max('order_position') + 1;
            $data['order_position'] = $order_position;
            if ($data['type'] == 'file') {
                $data = [
                    'title' => $data['title'],
                    'label' => $data['label'],
                    'order_position' => $data['order_position'],
                    'parent_id' => $data['parent_id'],
                    'type' => 'file',
                    'requirment_filed' => json_encode([
                        'required' => $data['diwajibkan'] == 'ya',
                        'mimes' => $data['type_file'] == '*' ? null : $data['type_file'],
                        'max' => $data['max_file'],
                    ]),
                ];
            }
            $this->model->create($data);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Ubah Syarat Pendaftaran',
            'item' => $this->model->find($id),
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();

            if ($data['type'] == 'file') {
                $data = [
                    'title' => $data['title'],
                    'label' => $data['label'],
                    'type' => 'file',
                    'requirment_filed' => json_encode([
                        'required' => $data['diwajibkan'] == 'ya',
                        'mimes' => $data['type_file'] == '*' ? null : $data['type_file'],
                        'max' => $data['max_file'],
                    ]),
                ];
            }

            $this->model->find($id)->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah data',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
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
            return $this->response($e);
        }
    }
}
