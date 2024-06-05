<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FungsiUnitKerja extends Model
{
    use HasFactory;

    protected $table = 'fungsi_unit_kerja';

    protected $fillable = ['title', 'desc'];
}
