<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontak';

    protected $fillable = [
        'title_content',
        'title_banner',
        'image_banner',
        'title',
        'kode',
        'description',
        'icon',
        'content',
        'image',
    ];

    protected $appends = [
        'banner_url',
        'image_url',
    ];

    public function getBannerUrlAttribute()
    {
        return $this->image_banner ? Storage::disk('assets')->url($this->image_banner) : null;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }
}
