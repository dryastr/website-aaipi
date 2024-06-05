<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ParamsWebsite extends Model
{
    use HasFactory;

    protected $fillable = [
        'module',
        'kode',
        'type',
        'title',
        'content',
        'image',
        'icon',
        'order_params',
        'status',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }

    public function getSingleData($module = null, $kode = null)
    {
        $query = $this->where('module', $module)->where('kode', $kode)->first();

        return $query;
    }
}
