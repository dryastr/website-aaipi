<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\CreateRequest;
use App\Http\Requests\Dashboard\User\UpdateRequest;
// use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $dirView;

    public function __construct()
    {
        $this->middleware('can:user-management.user.view')->only(['index', 'getView']);
        $this->middleware('can:user-management.user.create')->only(['create', 'store']);
        $this->middleware('can:user-management.user.edit')->only(['edit', 'update']);
        $this->middleware('can:user-management.user.delete')->only(['delete']);

        $this->dirView = 'admin.pages.user-management.user.';
    }

    public function index(Request $request)
    {
        $type = $request->type ? $request->type : 'admin';

        $status = [
            ['value' => 'admin', 'title' => 'Admin'],
            ['value' => 'anggota-biasa', 'title' => 'Anggota Biasa'],
            ['value' => 'anggota-luar-biasa', 'title' => 'Anggota Luar Biasa'],
            ['value' => 'anggota-kehormatan', 'title' => 'Anggota Kehormatan'],
        ];

        $actionBtn = false;

        if($type == 'admin' || $type == 'anggota-kehormatan'){
            $actionBtn = true;
        }


        $data = [
            'title' => 'User',
            'type' => $type,
            'status' => $status,
            'actionBtn' => $actionBtn,
        ];

        return view($this->dirView.'index', $data);
    }

    public function getView(Request $request, $type)
    {
        $typeId = $this->getTypeId($type);
        $columns = $request->input('columns');
        $query = User::select('*')->latest()->where('role_id', $typeId);
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

        // relation
        $query->with(['role:id,name']);

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

    public function create($type)
    {
        $type = $type ? $type : 'admin';
        $data = [
            'title' => 'Tambah Role',
            // 'roles' => Role::select('*')->get(),
            'type' => $type
        ];

        return view($this->dirView.'add', $data);

    }

    public function store(CreateRequest $request, $type)
    {
        try {
            $validateRequest = $request->validated();
            $validateRequest['password'] = Hash::make($validateRequest['password']);
            $type = $type ? $type : 'admin';
            $role_id = $this->getTypeId($type);
            $validateRequest['role_id'] = $role_id;
            $data = User::create($validateRequest);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan data',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e
            ], 500);
        }
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Ubah User',
            'item' => User::find($id),
            // 'roles' => Role::select('*')->get(),
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $data = User::find($id)->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah data',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e
            ], 500);
        }
    }

    public function changeProfile()
    {
        $data = [
            'title' => 'Ubah Profile',
        ];

        return view($this->dirView.'change-profile', $data);
    }

    public function destroy(string $id)
    {
        try {
            User::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e
            ], 500);
        }
    }

    private function getTypeId($type = '')
    {
        $type = $type ? $type : 'admin';

        switch($type){
            case "admin":
                return 1;
            case "anggota-biasa":
                return 2;
            case "anggota-luar-biasa":
                return 3;
            case "anggota-kehormatan":
                return 4;
            default:
                return 1;
        }
    }
}
