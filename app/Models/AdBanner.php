<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdBanner extends Model
{
    use HasFactory;

    protected $table = 'ad_banners';

    protected $fillable = ['title', 'image', 'url', 'target'];

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }
}
