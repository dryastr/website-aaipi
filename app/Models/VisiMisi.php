<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VisiMisi extends Model
{
    use HasFactory;

    protected $table = 'visi_misi';

    protected $fillable = [
        'title_banner',
        'conten_tentang',
        'banner',
        'image',
        'visi',
        'misi',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $appends = [
        'banner_url',
        'image_url',
    ];

    public function getBannerUrlAttribute()
    {
        return $this->banner ? Storage::disk('assets')->url($this->banner) : null;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }
}
