<?php

namespace App\Models;

use App\Traits\ModelBootObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    use ModelBootObserver;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    public function permissions()
    {
        return $this->hasMany(RoleHasPermission::class);
    }
}
