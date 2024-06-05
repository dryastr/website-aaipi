<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleHasPermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    protected $dirView;

    protected $model;

    protected $modelRoleHasPermission;

    public function __construct()
    {
        $this->dirView = 'admin.pages.user-management.role-permission.';
        $this->model = new Menu();
        $this->modelRoleHasPermission = new RoleHasPermission();
    }

    public function index()
    {
        $data = [
            'title' => 'Role Permission',
            'roles' => Role::get(),
        ];

        return view($this->dirView.'index', $data);
    }

    public function view($id)
    {
        return $this->model->getMenuPermissionWithChild($id);
    }

    public function store(Request $request)
    {
        $role_id = $request->role_id;
        $permission_id = json_decode($request->permission_id);
        $data = collect();
        foreach ($permission_id as $row) {
            $dataPermission = $this->modelRoleHasPermission->where([['role_id', '=', $role_id], ['permission_id', '=', $row->value]])->first();
            if ($row->check) {
                if (! $dataPermission) {
                    $this->modelRoleHasPermission->create([
                        'role_id' => $role_id,
                        'permission_id' => $row->value,
                    ]);
                }
            } else {
                if ($dataPermission) {
                    $this->modelRoleHasPermission->where([['role_id', '=', $role_id], ['permission_id', '=', $row->value]])->delete();
                }
            }
            $data->push($dataPermission);
        }

        return response()->json([$data]);
    }
}
