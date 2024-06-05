<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutHistory extends Model
{
    use HasFactory;

    protected $table = 'about_history';

    protected $fillable = [
        'title_banner',
        'image_banner',
        'title',
        'description',
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
