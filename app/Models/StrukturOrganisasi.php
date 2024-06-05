<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'cms_struktur_organisasi';

    protected $fillable = [

        'jabatan',
        'jabatan_title',
        'desc_jabatan',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];
}
