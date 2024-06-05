<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'ref_provinsi';

    protected $fillable = [
        'kode',
        'nama',
        'is_active',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];
}
