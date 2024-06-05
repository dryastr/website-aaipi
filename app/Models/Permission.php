<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'name',
        'action',
    ];

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }

    public function hasPermissions()
    {
        return $this->hasOne(RoleHasPermission::class, 'permission_id', 'id');
    }
}
