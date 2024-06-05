<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AnggaranDasar extends Model
{
    use HasFactory;

    protected $table = 'anggaran_dasar';

    protected $fillable = [
        'title',
        'image',
        'title_banner',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }
}
