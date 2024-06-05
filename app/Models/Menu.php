<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'title',
        'icon',
        'url',
        'type',
        'order_menu',
        'status',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'menu_id', 'id');
    }

    /**
     * Get the parent.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    public function getMenuPermission($role = null)
    {
        $data = $this->with(['permissions' => function ($query) use ($role) {
            $query->with(['hasPermissions' => function ($q) use ($role) {
                $q->where('role_id', $role);
            }]);
        }])->get();
        $result = collect();
        foreach ($data->toArray() as $row) {
            if (count($row['permissions'])) {
                $permissions = collect();
                foreach ($row['permissions'] as $item) {
                    $item['has_permissions'] = $item['has_permissions'] ? true : false;
                    $permissions->push($item);
                }
                $row['permissions'] = $permissions->toArray();
            } else {
                $row['permissions'] = null;
            }

            $result->push($row);
        }

        return $result->toArray();
    }

    public function getMenuUser($role = null)
    {
        $items = $this->getMenuPermission($role);

        function collectData($data = [], $parent = null)
        {
            $dataFilter = array_filter($data, function ($f) use ($parent) {
                return $f['parent_id'] == $parent;
            });

            $result = collect();

            foreach ($dataFilter as $item) {
                if ($item['type'] == 'item') {
                    if ($item['permissions'] == null) {
                        $result->push($item);
                    } else {
                        $checkPermission = array_filter($item['permissions'], function ($f) {
                            return $f['name'] == 'View' && $f['has_permissions'] == true;
                        });

                        if (count($checkPermission) != 0) {
                            $result->push($item);
                        }
                    }
                } else {
                    $childrens = collectData($data, $item['id']);
                    if (count($childrens) != 0) {
                        foreach ($childrens as $itemChildren) {
                            $result->push($itemChildren);
                        }
                        $result->push($item);
                    }
                }
            }

            return $result;
        }

        $result = collectData($items);

        return $result;
    }

    public function getMenuPermissionWithChild($role = null)
    {
        return $this->getMenu($this->getMenuPermission($role));
    }

    protected function getMenu($data = [], $parent = null)
    {
        $dataFilter = array_filter($data, function ($f) use ($parent) {
            return $f['parent_id'] == $parent;
        });
        $result = collect();

        foreach ($dataFilter as $item) {
            // $item['permissions'] = count($item['permissions']) == 0 ? null : $item['permissions'];
            $childrens = $this->getMenu($data, $item['id']);
            if (count($childrens) > 0) {
                $item['childrens'] = $childrens;
            }
            $result->push($item);
        }

        return $result;
    }
}
